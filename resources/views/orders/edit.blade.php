@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Order #{{ $order->id }}</h2>

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        @foreach($products as $product)
            <div class="mb-3">
                <label class="form-label">{{ $product->name }}</label>
                <input type="number" name="products[{{ $product->id }}]" class="form-control"
                       value="{{ $order->products->where('id', $product->id)->first()?->pivot->quantity ?? 0 }}">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</div>
@endsection
