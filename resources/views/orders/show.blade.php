@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Order Details</h1>
      <p class="text-muted">Order #{{ $order->order_number }}</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary">
        <i class="fas fa-edit me-2"></i>Edit Order
      </a>
      <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Orders
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Order Information -->
    <div class="col-lg-8">
      <!-- Order Items -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Product</th>
                  <th>SKU</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ $item->product->main_image }}" alt="{{ $item->product_name }}" 
                           class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                      <div>
                        <div class="fw-medium">{{ $item->product_name }}</div>
                        <small class="text-muted">{{ $item->product->category }}</small>
                        @if($item->variant_color || $item->variant_size)
                          <div class="small mt-1">
                            @if($item->variant_color)
                              <span class="badge bg-light text-dark border me-1">Color: {{ $item->variant_color }}</span>
                            @endif
                            @if($item->variant_size)
                              <span class="badge bg-light text-dark border">Size: {{ $item->variant_size }}</span>
                            @endif
                          </div>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>
                    <code>{{ $item->product_sku }}</code>
                  </td>
                  <td>
                    <span class="badge bg-secondary">{{ $item->quantity }}</span>
                  </td>
                  <td>{{ $item->formatted_unit_price }}</td>
                  <td>
                    <strong>{{ $item->formatted_total_price }}</strong>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Customer Information -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Customer Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6>Contact Details</h6>
              <p class="mb-1"><strong>Name:</strong> {{ $order->customer_name }}</p>
              <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
              @if($order->customer_phone)
              <p class="mb-0"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
              @endif
            </div>
            <div class="col-md-6">
              <h6>Shipping Address</h6>
              <p class="mb-0">{{ nl2br(e($order->shipping_address)) }}</p>
            </div>
          </div>
          @if($order->billing_address && $order->billing_address !== $order->shipping_address)
          <hr>
          <div class="row">
            <div class="col-12">
              <h6>Billing Address</h6>
              <p class="mb-0">{{ nl2br(e($order->billing_address)) }}</p>
            </div>
          </div>
          @endif
        </div>
      </div>

      @if($order->notes)
      <!-- Order Notes -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Notes</h5>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ $order->notes }}</p>
        </div>
      </div>
      @endif
    </div>

    <!-- Order Summary -->
    <div class="col-lg-4">
      <!-- Order Status -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Status</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Order Status</label>
            <select class="form-select" id="orderStatus" data-order-id="{{ $order->id }}">
              <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
              <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
              <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
              <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
              <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Payment Status</label>
            <select class="form-select" id="paymentStatus" data-order-id="{{ $order->id }}">
              <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
              <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
              <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
          </div>
          @if($order->payment_method)
          <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <p class="mb-0">{{ $order->payment_method }}</p>
          </div>
          @endif
          @if($order->payment_transaction_id || $order->payment_number)
          <div class="mb-0">
            <label class="form-label">Payment Details</label>
            <div class="small text-muted">
              @if($order->payment_number)
                <div><strong>Number:</strong> <span class="font-monospace">{{ $order->payment_number }}</span></div>
              @endif
              @if($order->payment_transaction_id)
                <div><strong>TrxID:</strong> <span class="font-monospace">{{ $order->payment_transaction_id }}</span></div>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>

      <!-- Order Summary -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <span>Subtotal:</span>
            <span>{{ $order->formatted_subtotal }}</span>
          </div>
          @if($order->shipping_option)
          <div class="d-flex justify-content-between mb-2">
            <span>Shipping Option:</span>
            <span>{{ $order->shipping_option }}</span>
          </div>
          @endif
          @if($order->discount_amount > 0)
          <div class="d-flex justify-content-between mb-2">
            <span>Discount:</span>
            <span class="text-success">-${{ number_format($order->discount_amount, 2) }}</span>
          </div>
          @endif
          @if($order->tax_amount > 0)
          <div class="d-flex justify-content-between mb-2">
            <span>Tax:</span>
            <span>${{ number_format($order->tax_amount, 2) }}</span>
          </div>
          @endif
          @if($order->shipping_cost > 0)
          <div class="d-flex justify-content-between mb-2">
            <span>Shipping:</span>
            <span>${{ number_format($order->shipping_cost, 2) }}</span>
          </div>
          @endif
          <hr>
          <div class="d-flex justify-content-between">
            <strong>Total:</strong>
            <strong>{{ $order->formatted_total }}</strong>
          </div>
          @if($order->payment_method)
          <div class="mt-2 d-flex justify-content-between">
            <span>Payment Method:</span>
            <strong>{{ $order->payment_method }}</strong>
          </div>
          @endif
        </div>
      </div>

      <!-- Order Timeline -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Order Timeline</h5>
        </div>
        <div class="card-body">
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-marker bg-primary"></div>
              <div class="timeline-content">
                <h6 class="mb-1">Order Created</h6>
                <small class="text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</small>
              </div>
            </div>
            @if($order->shipped_at)
            <div class="timeline-item">
              <div class="timeline-marker bg-success"></div>
              <div class="timeline-content">
                <h6 class="mb-1">Order Shipped</h6>
                <small class="text-muted">{{ $order->shipped_at->format('M d, Y h:i A') }}</small>
              </div>
            </div>
            @endif
            @if($order->delivered_at)
            <div class="timeline-item">
              <div class="timeline-marker bg-success"></div>
              <div class="timeline-content">
                <h6 class="mb-1">Order Delivered</h6>
                <small class="text-muted">{{ $order->delivered_at->format('M d, Y h:i A') }}</small>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .timeline {
    position: relative;
    padding-left: 30px;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 20px;
  }

  .timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
  }

  .timeline-content {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 6px;
    border-left: 3px solid #007bff;
  }
</style>
@endsection

@section('scripts')
<script>
  // Update order status
  document.getElementById('orderStatus').addEventListener('change', function() {
    const orderId = this.dataset.orderId;
    const status = this.value;
    
    fetch(`/orders/${orderId}/update-status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Show success message
        showAlert('success', data.message);
      } else {
        // Revert selection
        this.value = '{{ $order->status }}';
        showAlert('error', 'Failed to update order status');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      this.value = '{{ $order->status }}';
      showAlert('error', 'Failed to update order status');
    });
  });

  // Update payment status
  document.getElementById('paymentStatus').addEventListener('change', function() {
    const orderId = this.dataset.orderId;
    const paymentStatus = this.value;
    
    fetch(`/orders/${orderId}/update-payment-status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ payment_status: paymentStatus })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showAlert('success', data.message);
      } else {
        this.value = '{{ $order->payment_status }}';
        showAlert('error', 'Failed to update payment status');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      this.value = '{{ $order->payment_status }}';
      showAlert('error', 'Failed to update payment status');
    });
  });

  function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alert = document.createElement('div');
    alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alert.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
      alert.remove();
    }, 5000);
  }
</script>
@endsection
