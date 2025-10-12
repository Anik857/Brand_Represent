@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <!-- Stats Cards -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon primary me-3">
            <i class="{{ $stats['total_sales']['icon'] }}"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Total Sales</h6>
            <h4 class="mb-1">{{ $stats['total_sales']['value'] }}</h4>
            <small class="text-success">
              <i class="fas fa-arrow-up me-1"></i>{{ $stats['total_sales']['change'] }}
            </small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon success me-3">
            <i class="{{ $stats['total_orders']['icon'] }}"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Total Orders</h6>
            <h4 class="mb-1">{{ $stats['total_orders']['value'] }}</h4>
            <small class="text-success">
              <i class="fas fa-arrow-up me-1"></i>{{ $stats['total_orders']['change'] }}
            </small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon warning me-3">
            <i class="{{ $stats['total_customers']['icon'] }}"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Total Customers</h6>
            <h4 class="mb-1">{{ $stats['total_customers']['value'] }}</h4>
            <small class="text-success">
              <i class="fas fa-arrow-up me-1"></i>{{ $stats['total_customers']['change'] }}
            </small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon danger me-3">
            <i class="{{ $stats['revenue']['icon'] }}"></i>
          </div>
          <div>
            <h6 class="text-muted mb-1">Revenue</h6>
            <h4 class="mb-1">{{ $stats['revenue']['value'] }}</h4>
            <small class="text-success">
              <i class="fas fa-arrow-up me-1"></i>{{ $stats['revenue']['change'] }}
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Recent Orders Table -->
  <div class="row">
    <div class="col-12">
      <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Recent Orders</h5>
          <a href="#" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>View All Orders
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
              <tr>
                <td>
                  <strong>{{ $order['id'] }}</strong>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="https://via.placeholder.com/32x32" class="rounded-circle me-2" alt="Customer">
                    {{ $order['customer'] }}
                  </div>
                </td>
                <td>
                  <strong>{{ $order['amount'] }}</strong>
                </td>
                <td>
                  <span class="status-badge status-{{ $order['status'] }}">
                    {{ ucfirst($order['status']) }}
                  </span>
                </td>
                <td>{{ $order['date'] }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" title="View">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-success" title="Edit">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Dashboard scripts can be added here if needed
</script>
@endsection