@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Your Orders</h2>

    <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">Place New Order</a>

    @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Order #{{ $order->id }} for {{ $order->customer->name }}</h5>
                <ul>
                    @foreach ($order->products as $product)
                        <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }}</li>
                    @endforeach
                </ul>

                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>

                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
