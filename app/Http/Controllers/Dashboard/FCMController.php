<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class FCMController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        $fcm_token = $input['fcm_token'];
        $user_id = auth()->user()->id; //$input['user_id'];

        $user = User::findOrFail($user_id);
        $user->fcm_token = $fcm_token;
        $user->save();

        return response()->json([
            'success' => true,

            'message' => 'User Successe Update Token'
        ]);
    }
}
