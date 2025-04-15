<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderWebController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customer = Customer::firstOrCreate(['name' => $request->customer_name]);

        $order = $customer->orders()->create();

        $order->products()->attach($request->product_id, ['quantity' => $request->quantity]);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        $order->load('products');
        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*' => 'integer|min:0',
        ]);

        $order->products()->detach(); // Clear old data

        foreach ($validated['products'] as $productId => $quantity) {
            if ($quantity > 0) {
                $order->products()->attach($productId, ['quantity' => $quantity]);
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
