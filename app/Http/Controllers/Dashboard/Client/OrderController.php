<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Order;
use App\Product;

class OrderController extends Controller
{
    public function index(Request $request)
    {
    }
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(2);
        return view('dashboard.clients.orders.create', compact('client', 'categories', 'orders'));
    }

    public function store(Request $request, Client $client)
    {
        //dd($request->all());
        //$request->validate(['products_ids' => 'required|array', 'quantities' => 'required|array',]);

        $request->validate(['products' => 'required|array']);

        $this->attach_order($request,  $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(3);
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories', 'orders'));
    }

    public function update(Request $request, Client $client, Order $order)
    {

        $request->validate(['products' => 'required|array']);

        $this->dattach_order($order);
        $this->attach_order($request,  $client, $order);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }
    public function destroy(Client $client, Order $order)
    {
        # code...
    }



    private function attach_order($request,  $client, $order = null)
    {
        if ($order == null) {
            $order = $client->orders()->create([]);
        }
        $order->products()->sync($request->products);
        $total_price = 0;
        $checkout_type = $order->checkout_type;
        $bank_transaction_id = $order->bank_transaction_id;
        if ($request->checkout_type == 'monetary') {
            $checkout_type = 'monetary';
        } else if ($request->checkout_type == 'online') {
            $checkout_type = 'online';
        }

        //foreach ($request->products_ids as $index => $products_id) {
        foreach ($request->products as $id => $quantity) {
            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];
            $product->update(['stock' => $product->stock - $quantity['quantity']]);

            //$total_price += $product->sale_price * $request->quantities[$index];
            //$order->products()->attach($products_id, ['quantity' => $request->quantities[$index]]);
            //$product->update(['stock' => $product->stock - $request->quantities[$index]]);
        }

        $order->update(['total_price' => $total_price, 'checkout_type' => $checkout_type, 'bank_transaction_id' => $bank_transaction_id]);
    }


    private function dattach_order($order)
    {
        foreach ($order->products as $product) {
            //dd($product);
            $product->update(['stock' => $product->pivot->quantity + $product->stock]);
        }
        //$order->delete();
    }


    public function categories()
    {
        $categories = Category::with('products')->get();
        //dd();
        if ($id = request('id')) {
            $order = Order::where('id', $id)->first();

            return view('dashboard.clients.orders._categories', compact('categories', 'order'));
        }
        return view('dashboard.clients.orders._categories', compact('categories'));
    }
}
