@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Place an Order</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <h5>Select Products</h5>

        @foreach($products as $product)
            <div class="mb-2 row align-items-center">
                <div class="col-sm-4">
                    <label class="form-check-label">
                        <input type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}" class="form-check-input">
                        {{ $product->name }}
                    </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" name="products[{{ $product->id }}][quantity]" class="form-control" placeholder="Quantity" min="1">
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
