<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    // Create a new order
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ]);

            $customer = Customer::firstOrCreate(['name' => $validated['customer_name']]);

            $order = $customer->orders()->create();

            foreach ($validated['products'] as $item) {
                $order->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all orders for a specific customer
    public function getCustomerOrders(Customer $customer): JsonResponse
    {
        $orders = $customer->orders()->with('products')->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // Get all orders
    public function index(): JsonResponse
    {
        $orders = Order::with('customer', 'products')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // Update an order
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Detach old products
        $order->products()->detach();

        // Attach new products with quantities
        foreach ($validated['products'] as $item) {
            $order->products()->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
            'order_id' => $order->id
        ]);
    }

    // Delete an order
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.'
        ]);
    }
}