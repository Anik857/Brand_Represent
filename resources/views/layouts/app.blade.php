<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    :root {
      --primary-color: #4f46e5;
      --primary-dark: #3730a3;
      --secondary-color: #64748b;
      --success-color: #10b981;
      --warning-color: #f59e0b;
      --danger-color: #ef4444;
      --light-bg: #f8fafc;
      --sidebar-bg: #1e293b;
      --sidebar-hover: #334155;
      --text-primary: #1e293b;
      --text-secondary: #64748b;
      --border-color: #e2e8f0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--light-bg);
      color: var(--text-primary);
    }

    .sidebar {
      background: var(--sidebar-bg);
      min-height: 100vh;
      width: 280px;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .sidebar-brand {
      padding: 1.5rem;
      border-bottom: 1px solid #334155;
    }

    .sidebar-brand h4 {
      color: white;
      margin: 0;
      font-weight: 600;
    }

    .sidebar-nav {
      padding: 1rem 0;
    }

    .nav-item {
      margin: 0.25rem 0;
    }

    .nav-link {
      color: #cbd5e1;
      padding: 0.75rem 1.5rem;
      display: flex;
      align-items: center;
      text-decoration: none;
      transition: all 0.3s ease;
      border-radius: 0;
    }

    .nav-link:hover {
      background-color: var(--sidebar-hover);
      color: white;
    }

    .nav-link.active {
      background-color: var(--primary-color);
      color: white;
    }

    .nav-link i {
      width: 20px;
      margin-right: 0.75rem;
    }

    .main-content {
      margin-left: 280px;
      transition: all 0.3s ease;
    }

    .main-content.expanded {
      margin-left: 80px;
    }

    .top-navbar {
      background: white;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      padding: 1rem 2rem;
      margin-bottom: 2rem;
    }

    .content-wrapper {
      padding: 0 2rem 2rem;
    }

    .stats-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--border-color);
      transition: all 0.3s ease;
    }

    .stats-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }

    .stats-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
    }

    .stats-icon.primary {
      background: var(--primary-color);
    }

    .stats-icon.success {
      background: var(--success-color);
    }

    .stats-icon.warning {
      background: var(--warning-color);
    }

    .stats-icon.danger {
      background: var(--danger-color);
    }

    .chart-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--border-color);
    }

    .table-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--border-color);
    }

    .avatar-circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 0.875rem;
    }

    .status-badge {
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 500;
    }

    .status-completed {
      background: #dcfce7;
      color: #166534;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
    }

    .status-shipped {
      background: #dbeafe;
      color: #1e40af;
    }

    .status-cancelled {
      background: #fee2e2;
      color: #991b1b;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      padding-left: 2.5rem;
      border-radius: 8px;
      border: 1px solid var(--border-color);
    }

    .search-box i {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-secondary);
    }

    .notification-badge {
      position: relative;
    }

    .notification-badge::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 8px;
      height: 8px;
      background: var(--danger-color);
      border-radius: 50%;
      border: 2px solid white;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .content-wrapper {
        padding: 0 1rem 1rem;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <h4><i class="fas fa-store me-2"></i>Brand Represent</h4>
    </div>
    <nav class="sidebar-nav">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
                       <li class="nav-item">
                           <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                               <i class="fas fa-tags"></i>
                               <span>Categories</span>
                           </a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                               <i class="fas fa-box"></i>
                               <span>Products</span>
                           </a>
                       </li>
               <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                   <i class="fas fa-shopping-cart"></i>
                   <span>Orders</span>
                 </a>
               </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
            <i class="fas fa-shield-alt"></i>
            <span>Roles</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
            <i class="fas fa-key"></i>
            <span>Permissions</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <!-- Top Navbar -->
    <div class="top-navbar">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <button class="btn btn-link me-3" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        </div>

        <div class="d-flex align-items-center">
          <!-- Search Box -->
          <div class="search-box me-3">
            <i class="fas fa-search"></i>
            <input type="text" class="form-control" placeholder="Search..." style="width: 300px;">
          </div>

          <!-- Notifications -->
          <div class="dropdown me-3">
            <button class="btn btn-link notification-badge" type="button" data-bs-toggle="dropdown">
              <i class="fas fa-bell fa-lg"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <h6 class="dropdown-header">Notifications</h6>
              </li>
              <li><a class="dropdown-item" href="#">New order received</a></li>
              <li><a class="dropdown-item" href="#">Payment processed</a></li>
              <li><a class="dropdown-item" href="#">Customer registered</a></li>
            </ul>
          </div>

          <!-- User Profile -->
          <div class="dropdown">
            <button class="btn btn-link d-flex align-items-center" type="button" data-bs-toggle="dropdown">
              <div class="avatar-circle me-2">
                <i class="fas fa-user"></i>
              </div>
              <span>{{ Auth::user()->name }}</span>
              <i class="fas fa-chevron-down ms-2"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-edit me-2"></i>Edit Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.password') }}"><i class="fas fa-key me-2"></i>Change Password</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script>
    // Sidebar toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');

      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('expanded');
    });

    // Mobile sidebar toggle
    if (window.innerWidth <= 768) {
      document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
      });
    }
  </script>

  @yield('scripts')
</body>

</html>