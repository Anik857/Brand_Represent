@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Edit Order</h1>
      <p class="text-muted">Order #{{ $order->order_number }}</p>
    </div>
    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left me-2"></i>Back to Details
    </a>
  </div>

  <form method="POST" action="{{ route('orders.update', $order) }}">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Addresses</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Shipping Address</label>
              <textarea name="shipping_address" rows="3" class="form-control" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Billing Address</label>
              <textarea name="billing_address" rows="3" class="form-control">{{ old('billing_address', $order->billing_address) }}</textarea>
            </div>
            <div class="mb-0">
              <label class="form-label">Notes</label>
              <textarea name="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Statuses</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Order Status</label>
              <select class="form-select" name="status" required>
                @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $st)
                  <option value="{{ $st }}" {{ old('status', $order->status) === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Status</label>
              <select class="form-select" name="payment_status" required>
                @foreach(['pending','paid','failed','refunded'] as $pst)
                  <option value="{{ $pst }}" {{ old('payment_status', $order->payment_status) === $pst ? 'selected' : '' }}>{{ ucfirst($pst) }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <input type="text" class="form-control" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}">
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Changes
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
