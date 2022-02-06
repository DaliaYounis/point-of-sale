<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(5);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function create($client_id)
    {
        $client = Client::findorfail($client_id);
        $categories = Category::with('products')->get();
        return view('dashboard.orders.create', ['categories' => $categories, 'client' => $client]);

    }

    public function store(Request $request,Client $client)
    {
        $this->attach_order($request,$client);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    public function products(Order $order)
    {
        $products = $order->products()->get();
        return view('dashboard.orders.products', compact('products', 'order'));
    }

    public function edit(Order $order, Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.orders.edit', compact('client', 'order', 'categories', 'orders'));

    }

    public function update(Request $request, Order $order, Client $client)
    {
        $this->detach_order($order);
        $this->attach_order($request,$client);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }

    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }

        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    private function attach_order($request,$client)
    {
        $total_price = 0;
        $order = $client->orders()->create([
            'total_price' => 0,
        ]);
        $order->products()->attach($request->products);
        foreach ($request->products as $id => $quantity) {
            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];
            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }
        $order->update([
            'total_price' => $total_price
        ]);
    }

    private function detach_order($order)
    {
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();

    }

}
