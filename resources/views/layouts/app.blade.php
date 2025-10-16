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
      overflow-y: auto;
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      display: none;
    }

    .sidebar-overlay.show {
      display: block;
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
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1rem;
      font-weight: 600;
      border: 3px solid white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      position: relative;
    }

    .avatar-circle:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .avatar-circle::after {
      content: '';
      position: absolute;
      bottom: 2px;
      right: 2px;
      width: 12px;
      height: 12px;
      background: #10b981;
      border: 2px solid white;
      border-radius: 50%;
      box-shadow: 0 0 0 1px var(--light-bg);
    }

    .profile-button {
      background: white;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      transition: all 0.3s ease;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
    }

    .profile-button:hover {
      background: var(--light-bg);
      border-color: var(--primary-color);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transform: translateY(-1px);
    }

    .profile-button:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .profile-info {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      min-width: 0;
    }

    .profile-name {
      font-weight: 600;
      color: var(--text-primary);
      font-size: 0.9rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 120px;
    }

    .profile-role {
      font-size: 0.75rem;
      color: var(--text-secondary);
      font-weight: 500;
    }

    .profile-chevron {
      color: var(--text-secondary);
      font-size: 0.8rem;
      transition: transform 0.3s ease;
    }

    .profile-button[aria-expanded="true"] .profile-chevron {
      transform: rotate(180deg);
    }

    .profile-dropdown {
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      padding: 0.5rem 0;
      margin-top: 0.5rem;
      min-width: 200px;
      animation: dropdownFadeIn 0.2s ease-out;
    }

    @keyframes dropdownFadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .profile-dropdown .dropdown-item {
      padding: 0.75rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      transition: all 0.2s ease;
      border-radius: 8px;
      margin: 0.25rem 0.5rem;
    }

    .profile-dropdown .dropdown-item:hover {
      background: var(--light-bg);
      color: var(--primary-color);
      transform: translateX(4px);
    }

    .profile-dropdown .dropdown-item i {
      width: 16px;
      text-align: center;
    }

    .profile-dropdown .dropdown-divider {
      margin: 0.5rem 0;
      border-color: var(--border-color);
    }

    .profile-header {
      padding: 1rem;
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      color: white;
      border-radius: 12px 12px 0 0;
      margin: -0.5rem -0.5rem 0.5rem -0.5rem;
    }

    .profile-header-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .profile-header-name {
      font-weight: 600;
      font-size: 1rem;
      margin-bottom: 0.25rem;
    }

    .profile-header-email {
      font-size: 0.8rem;
      opacity: 0.9;
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
        width: 280px;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .sidebar.collapsed {
        width: 280px;
        transform: translateX(-100%);
      }

      .sidebar.collapsed.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .main-content.expanded {
        margin-left: 0;
      }

      .content-wrapper {
        padding: 0 1rem 1rem;
      }

      .top-navbar {
        padding: 1rem;
      }

      .search-box input {
        width: 200px !important;
      }

    .nav-link span {
      display: block;
    }

    .sidebar-brand h4 {
      font-size: 1.1rem;
    }

    .nav-link {
      padding: 1rem 1.5rem;
      font-size: 0.95rem;
    }

    .nav-link i {
      width: 24px;
      margin-right: 1rem;
    }

    @media (max-width: 576px) {
      .search-box {
        display: none;
      }

      .content-wrapper {
        padding: 0 0.5rem 1rem;
      }

      .top-navbar {
        padding: 0.75rem;
      }

      .stats-card {
        padding: 1rem;
      }

      .table-responsive {
        font-size: 0.875rem;
      }

      .profile-button {
        padding: 0.4rem 0.8rem;
      }

      .profile-name {
        max-width: 80px;
        font-size: 0.85rem;
      }

      .profile-role {
        font-size: 0.7rem;
      }

      .profile-dropdown {
        min-width: 180px;
      }
    }

    @media (max-width: 480px) {
      .profile-button {
        padding: 0.3rem 0.6rem;
        gap: 0.5rem;
      }

      .profile-info {
        display: none;
      }

      .profile-button {
        min-width: 40px;
        justify-content: center;
      }

      .avatar-circle {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
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
          <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
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
            <button class="profile-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="avatar-circle">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <div class="profile-info">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">
                  @if(Auth::user()->hasRole('admin'))
                    Administrator
                  @elseif(Auth::user()->hasRole('manager'))
                    Manager
                  @elseif(Auth::user()->hasRole('employee'))
                    Employee
                  @else
                    Customer
                  @endif
                </div>
              </div>
              <i class="fas fa-chevron-down profile-chevron"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
              <li class="profile-header">
                <div class="profile-header-avatar">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="profile-header-name">{{ Auth::user()->name }}</div>
                <div class="profile-header-email">{{ Auth::user()->email }}</div>
              </li>
              <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user"></i>View Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-edit"></i>Edit Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.password') }}"><i class="fas fa-key"></i>Change Password</a></li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i>Settings</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i>Logout
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
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
      if (window.innerWidth <= 768) {
        // Mobile behavior
        sidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
      } else {
        // Desktop behavior
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
      }
    }

    function closeSidebar() {
      sidebar.classList.remove('show');
      sidebarOverlay.classList.remove('show');
      document.body.style.overflow = '';
    }

    // Toggle sidebar on button click
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking overlay
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      if (window.innerWidth <= 768 && 
          !sidebar.contains(event.target) && 
          !sidebarToggle.contains(event.target) &&
          sidebar.classList.contains('show')) {
        closeSidebar();
      }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        // Desktop: remove mobile classes
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
        document.body.style.overflow = '';
      } else {
        // Mobile: remove desktop classes
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('expanded');
      }
    });

    // Close sidebar on navigation link click (mobile)
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          closeSidebar();
        }
      });
    });

    // Handle escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && sidebar.classList.contains('show')) {
        closeSidebar();
      }
    });
  </script>

  @yield('scripts')
</body>

</html>