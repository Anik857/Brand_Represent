@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Checkout</h4>
      <a href="{{ url('/') }}" class="btn btn-outline-secondary">Continue Shopping</a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Billing & Shipping</h5></div>
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          <form method="POST" action="{{ route('checkout.place') }}">
            @csrf
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
              @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-header"><h5 class="mb-0">Order Summary</h5></div>
        <div class="card-body">
          @forelse($items as $item)
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex align-items-center">
                <img src="{{ $item['image'] }}" alt="" width="50" class="rounded me-2">
                <div>
                  <div class="fw-medium">{{ $item['name'] }}</div>
                  <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                </div>
              </div>
              <div class="fw-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
            </div>
          @empty
            <p class="text-muted">Your cart is empty.</p>
          @endforelse
          <hr>
          <div class="d-flex justify-content-between">
            <span class="fw-medium">Subtotal</span>
            <span class="fw-medium">${{ number_format($subtotal, 2) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


