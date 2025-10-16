@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Application Settings</h4>
          <p class="text-muted mb-0">Manage your application configuration</p>
        </div>
        <div>
          <a href="{{ route('settings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Setting
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Settings Groups -->
  <div class="row">
    @foreach($settings as $group => $groupSettings)
    <div class="col-lg-6 col-xl-4 mb-4">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fas fa-{{ $group === 'general' ? 'cog' : ($group === 'email' ? 'envelope' : ($group === 'payment' ? 'credit-card' : 'settings')) }} me-2"></i>
              {{ ucfirst($group) }} Settings
            </h5>
            <span class="badge bg-primary">{{ $groupSettings->count() }} settings</span>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <p class="text-muted small mb-0">
              @if($group === 'general')
                Basic application settings and configuration
              @elseif($group === 'email')
                Email server and notification settings
              @elseif($group === 'payment')
                Payment gateway and billing settings
              @elseif($group === 'system')
                System-level configuration and security
              @else
                {{ ucfirst($group) }} related settings
              @endif
            </p>
          </div>
          
          @if($groupSettings->count() > 0)
            <div class="mb-3">
              <h6 class="text-primary">Recent Settings:</h6>
              @foreach($groupSettings->take(3) as $setting)
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small">{{ $setting->key }}</span>
                <span class="badge bg-{{ $setting->type === 'boolean' ? ($setting->getValue() ? 'success' : 'secondary') : 'info' }} badge-sm">
                  {{ $setting->type }}
                </span>
              </div>
              @endforeach
              @if($groupSettings->count() > 3)
                <small class="text-muted">+{{ $groupSettings->count() - 3 }} more settings</small>
              @endif
            </div>
          @endif
        </div>
        <div class="card-footer">
          <div class="d-grid">
            <a href="{{ route('settings.edit', $group) }}" class="btn btn-outline-primary">
              <i class="fas fa-edit me-2"></i>Manage {{ ucfirst($group) }} Settings
            </a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Quick Actions -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <a href="{{ route('settings.create') }}" class="btn btn-outline-primary w-100">
                <i class="fas fa-plus me-2"></i>Add Setting
              </a>
            </div>
            <div class="col-md-3 mb-3">
              <a href="{{ route('settings.edit', 'general') }}" class="btn btn-outline-success w-100">
                <i class="fas fa-cog me-2"></i>General Settings
              </a>
            </div>
            <div class="col-md-3 mb-3">
              <a href="{{ route('settings.edit', 'email') }}" class="btn btn-outline-info w-100">
                <i class="fas fa-envelope me-2"></i>Email Settings
              </a>
            </div>
            <div class="col-md-3 mb-3">
              <a href="{{ route('settings.edit', 'system') }}" class="btn btn-outline-warning w-100">
                <i class="fas fa-shield-alt me-2"></i>System Settings
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
