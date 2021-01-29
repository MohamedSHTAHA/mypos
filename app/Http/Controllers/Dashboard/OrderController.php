<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\PaymentDetials;
use PhpParser\Node\Expr\Print_;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    use PaymentsTraid;

    public function __construct()
    {
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:update_orders'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_orders'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->paginate(10);
        //dd($orders);
        return view('dashboard.orders.index', compact('orders'));
        //$orders = Order::paginate(5);
        //return view('dashboard.orders.index', compact('orders'));
    }

    public function clientsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::all();
            return Datatables::of($data)
                ->addColumn('setClient', function ($row) {
                    $btn = '<input type="radio" onclick="setClient($(this))" name="client" data-id="' . $row->id . '" value="' . $row->name . '"/>';
                    return $btn;
                })
                ->addColumn('test', function ($row) {
                    $btn = '<input type="checkbox" name="id[]" value="' . $row->id . '">';
                    return $btn;
                })
                ->rawColumns(['setClient', 'test'])
                ->make(true);
        }
    } //end of data table


    public function create()
    {
        return view('dashboard.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function showOrderCheckOut(Order $order)
    {
        $res = $this->TransactionSearchUsingpaymentId($order->bank_transaction_id);
        dd($res);
    }
    public function orderCheckOut(Order $order)
    {
        if ($order->total_price > $order->payments->sum('total_price'))
            $price = $order->total_price - $order->payments->sum('total_price');
        $res = $this->getCheckOutId($price);
        //dd($res);
        if (isset($res['id'])) {
            return view('dashboard.orders._payments')->with(['responseData' => $res, 'id' => $order->id]);
        }

        return $res['result']['description'];
    }
    public function orderCheckOutFinal(Order $order, Request $request)
    {
        if (request('id') && request('resourcePath')) {
            $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
            //dd($payment_status);
            if (isset($payment_status['id'])) { //success payment id -> transaction bank id
                $showSuccessPaymentMessage = true;
                if (($order->total_price - $order->payments->sum('total_price')) == $payment_status['amount']) {
                    $order->update(['bank_transaction_id' => $payment_status['id']]);
                    $paymentDetials = [
                        'bank_transaction_id' => $payment_status['id'],
                        'order_id' => $order->id,
                        'client_id' => $order->client_id,
                        'total_price' => $payment_status['amount'],
                        'currency' => $payment_status['currency'],
                        'paymentBrand' => $payment_status['paymentBrand'],
                    ];
                    PaymentDetials::create($paymentDetials);
                } else {
                    $showFailPaymentMessage = true;
                    return redirect()->route('dashboard.orders.index')->with(['fail'  => 'احتمال وجود عملية احتيال على الموقع']);
                }

                //save order in orders table with transaction id  = $payment_status['id']
                //session()->flash('success', __('site.updated_successfully'));
                return redirect()->route('dashboard.orders.index')->with(['success' =>  'تم الدفغ بنجاح']);
            } else {
                $showFailPaymentMessage = true;
                return redirect()->route('dashboard.orders.index')->with(['fail'  => 'فشلت عملية الدفع']);
            }
        }
        return redirect()->route('dashboard.orders.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('products', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {


        foreach ($order->products as $product) {
            //dd($product);
            $product->update(['stock' => $product->pivot->quantity + $product->stock]);
        }

        $order->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.orders.index');
    }
}
