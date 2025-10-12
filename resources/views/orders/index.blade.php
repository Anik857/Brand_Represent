@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Orders</h1>
      <p class="text-muted">Manage customer orders and track their status</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Create Order
    </a>
  </div>

  <!-- Filters -->
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" 
                 value="{{ request('search') }}" placeholder="Order number, customer name, email...">
        </div>
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="payment_status" class="form-label">Payment Status</label>
          <select class="form-select" id="payment_status" name="payment_status">
            <option value="">All Payment Statuses</option>
            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="date_from" class="form-label">Date From</label>
          <input type="date" class="form-control" id="date_from" name="date_from" 
                 value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
          <label for="date_to" class="form-label">Date To</label>
          <input type="date" class="form-control" id="date_to" name="date_to" 
                 value="{{ request('date_to') }}">
        </div>
        <div class="col-md-1">
          <label class="form-label">&nbsp;</label>
          <div class="d-grid">
            <button type="submit" class="btn btn-outline-primary">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Orders ({{ $orders->total() }})</h5>
        <div class="d-flex gap-2">
          <select class="form-select form-select-sm" id="bulkAction" style="width: auto;">
            <option value="">Bulk Actions</option>
            <option value="confirm">Confirm</option>
            <option value="process">Mark as Processing</option>
            <option value="ship">Mark as Shipped</option>
            <option value="deliver">Mark as Delivered</option>
            <option value="cancel">Cancel</option>
            <option value="delete">Delete</option>
          </select>
          <button type="button" class="btn btn-sm btn-outline-primary" onclick="applyBulkAction()">
            Apply
          </button>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>
                <input type="checkbox" id="selectAll" class="form-check-input">
              </th>
              <th>Order #</th>
              <th>Customer</th>
              <th>Items</th>
              <th>Total</th>
              <th>Status</th>
              <th>Payment</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
            <tr>
              <td>
                <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
              </td>
              <td>
                <strong>{{ $order->order_number }}</strong>
              </td>
              <td>
                <div>
                  <div class="fw-medium">{{ $order->customer_name }}</div>
                  <small class="text-muted">{{ $order->customer_email }}</small>
                </div>
              </td>
              <td>
                <span class="badge bg-secondary">{{ $order->total_items }} items</span>
              </td>
              <td>
                <strong>{{ $order->formatted_total }}</strong>
              </td>
              <td>
                <span class="badge bg-{{ $order->status_badge }}">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td>
                <span class="badge bg-{{ $order->payment_status_badge }}">
                  {{ ucfirst($order->payment_status) }}
                </span>
              </td>
              <td>
                <div>
                  <div>{{ $order->created_at->format('M d, Y') }}</div>
                  <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                </div>
              </td>
              <td>
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary" title="View">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-success" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button type="button" class="btn btn-outline-danger" 
                          onclick="deleteOrder({{ $order->id }})" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-4">
                <div class="text-muted">
                  <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                  <p>No orders found</p>
                  <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    Create First Order
                  </a>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer">
      {{ $orders->links() }}
    </div>
    @endif
  </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="{{ route('orders.bulk-action') }}" style="display: none;">
  @csrf
  <input type="hidden" name="action" id="bulkActionValue">
  <div id="bulkOrderIds"></div>
</form>
@endsection

@section('scripts')
<script>
  // Select All functionality
  document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
  });

  // Individual checkbox change
  document.querySelectorAll('.order-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const allCheckboxes = document.querySelectorAll('.order-checkbox');
      const checkedCheckboxes = document.querySelectorAll('.order-checkbox:checked');
      document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
    });
  });

  // Delete order
  function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
      const form = document.getElementById('deleteForm');
      form.action = `/orders/${orderId}`;
      form.submit();
    }
  }

  // Bulk actions
  function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
    
    if (!action) {
      alert('Please select an action');
      return;
    }
    
    if (checkedBoxes.length === 0) {
      alert('Please select at least one order');
      return;
    }
    
    if (action === 'delete' && !confirm('Are you sure you want to delete the selected orders?')) {
      return;
    }
    
    const form = document.getElementById('bulkActionForm');
    document.getElementById('bulkActionValue').value = action;
    
    const orderIdsContainer = document.getElementById('bulkOrderIds');
    orderIdsContainer.innerHTML = '';
    
    checkedBoxes.forEach(checkbox => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'order_ids[]';
      input.value = checkbox.value;
      orderIdsContainer.appendChild(input);
    });
    
    form.submit();
  }
</script>
@endsection
