<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Chat;
use App\ChatsRealtime;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index()
    {
        //echo Route::currentRouteAction() . '<br>';
        /*$routes = Route::getRoutes(); //$app->routes->getRoutes(); //
        //dd($routes);

        foreach ($routes as $value) {
            if (Route::getFacadeRoot()->current()->uri() == $value->uri()) {
                echo 'uri() : ' . $value->uri() . '-----------------';
                echo 'getActionName() : ' . $value->getActionName() . '-----------------';
                echo 'getName() : ' . $value->getName() . '<br>';
            }
        }*/
        //dd(User::limit(10)->pluck('id')->toarray());
        ///$chats = Chat::all();
        //dd((Route::currentRouteName() == 'dashboard.index') ? 'yes' : 'no');
        $users = User::where('id', '!=', auth()->user()->id)->orderBy('id', 'ASC')->withCount('chatsReseviedTotal')->get();
        $products_count = Product::count();
        $categories_count = Category::count();
        $clients_count = Client::count();
        $users_count = User::whereRoleIs('admin')->count();

        $sales_data = Order::select(
            DB::raw('year(`created_at`) as year'),
            DB::raw('month(`created_at`) as month'),
            DB::raw('day(`created_at`) as day'),
            DB::raw('SUM(`total_price`) as sum'),
        )->groupBy('day', 'month', 'year')->get();
        //dd($sales_data);
        //dashboard.index-firebase
        return view('dashboard.index-socketio', compact('products_count', 'categories_count', 'clients_count', 'users_count', 'sales_data', 'users'));
    }

    public function notifyMe()
    {
        return view('dashboard.notifyMe');
    }


    public function createChat(Request $request)
    {
        $message = $request->message;

        $chat = Chat::create([
            'sender_id' => auth()->user()->id,
            'sender_name' => auth()->user()->first_name,
            'message' => $message,
            'to_id' => $request->to_id,

        ]);

        //$this->broadCastMessage($chat);
        return $this->FunctionName($chat);

        return response()->json($chat);
        //return redirect()->back();
    }

    public function FunctionName($chat)
    {
        define('API_ACCESS_KEY', 'AAAAL1xGZPA:APA91bEIabntQ2z1CjMWZo96s50fKWzmwpBhIbY378qlu1C3jdK8OGZeQc49UJIru0cfWhyEY1daFZBrWfZOys-bJJjp28vkYzqU8ZwiO0aweDxN405ffE1LkDHcn_4sKJFTVB0V6659');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $user = User::where('id', $chat->to_id)->first();

        $token = $user->fcm_token;

        $notification = [
            'title' => $chat->sender_name,
            'body' => $chat->message,
            'icon' => 'myIcon',
            'sound' => 'mySound'
        ];
        $extraNotificationData = $chat->toArray();

        $fcmNotification = [
            //'registration_ids' => User::pluck('fcm_token')->toArray(), //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


        return $result;
    }

    private function broadCastMessage($chat)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($chat->sender_name);
        $notificationBuilder->setBody($chat->message)
            ->setSound('default')
            ->setClickAction('test');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($chat->toArray());


        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();



        $user = User::where('id', $chat->to_id)->first();

        $tokens = $user->fcm_token;
        //$tokens = User::pluck('fcm_token')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }


    public function getUserMessages(Request $request)
    {
        $chats = Chat::whereIn('sender_id', [auth()->user()->id, $request->to_id])->whereIn('to_id', [auth()->user()->id, $request->to_id])->get();

        $to = User::find($request->to_id);
        return  view('dashboard.userMessage', compact('chats', 'to'));   //response()->json($chats);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getUserchats(Request $request)
    {

        $chats = ChatsRealtime::whereIn('sender_id', [auth()->user()->id, $request->receiver_id])->whereIn('receiver_id', [auth()->user()->id, $request->receiver_id])->get();
        //dd($chats);
        $to = User::withCount('chatsReseviedTotal')->find($request->receiver_id);
        //dd($to);
        return  view('dashboard.userChats', compact('chats', 'to'));   //
        //response()->json($chats);
    }

    public function saveChat(Request $request)
    {
        $message = $request->message;
        $files_json = [];
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach ($files as $file) {
                $file->store('chat_files', 'public_uploads');
                $name = $file->hashName();
                $viewname = $file->getClientOriginalName();
                $type = $file->getMimeType();
                array_push($files_json, ['name' => $name, 'type' => $type, 'viewname' => $viewname]);

                //$filename = $file->getClientOriginalName();
                //$file->move(public_path() . '/uploads/chat_files/', $filename);
            }
            $message = isset($request->message) ? $request->message : '';
        }
        //dd(json_encode($files_json));


        $chat = ChatsRealtime::create([
            'sender_id' => auth()->user()->id,
            'message' => $message,
            'files' => json_encode($files_json),
            'receiver_id' => $request->receiver_id,

        ]);
        return response()->json(ChatsRealtime::with('sender:id,first_name,last_name,image')->find($chat->id));
        //return response()->json(ChatsRealtime::with('sender:id,first_name,last_name,image')->with('receiver:id,first_name,last_name,image')->find($chat->id));
    }

    public function readChat(Request $request)
    {
        ChatsRealtime::where('receiver_id', auth()->user()->id)->where('sender_id', $request->read_chat_of_id)->update(['read' => '2']);
        return response()->json(['read' => true,  'read_chat_of_id' => $request->read_chat_of_id]);
    }

    public function chatsReseviedTotal(Request $request) //return total msg of user reseve when me send msg 
    {
        $chats_resevied_total_count = ChatsRealtime::where('sender_id', $request->sender_id)->where('receiver_id', auth()->user()->id)->where('read', '!=', '2')->get()->count();


        //dd($user);
        return response()->json(['sender_id' => $request->sender_id, 'receiver_id' => auth()->user()->id, 'chats_resevied_total_count' => $chats_resevied_total_count]);
    }

    public function myFriend(Request $request)
    {
        $user = User::find($request->myfrind);

        if ($user) {
            $replay = ['status' => true, 'myFriend' => $user];
        } else {
            $replay = ['status' => false, 'myFriend' => null];
        }
        return response()->json($replay);
    }
}
