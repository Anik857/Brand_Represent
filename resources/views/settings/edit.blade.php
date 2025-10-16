@extends('layouts.app')

@section('title', 'Edit Settings')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Edit {{ ucfirst($group) }} Settings</h4>
          <p class="text-muted mb-0">Configure your {{ $group }} settings</p>
        </div>
        <div>
          <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Settings
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('settings.update', $group) }}">
    @csrf
    @method('PUT')
    <div class="row">
      <!-- Main Form -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">{{ ucfirst($group) }} Configuration</h5>
          </div>
          <div class="card-body">
            @if($settings->count() > 0)
              @foreach($settings as $setting)
              <div class="mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <label for="setting_{{ $setting->key }}" class="form-label">
                      {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                      @if($setting->is_public)
                        <span class="badge bg-success badge-sm">Public</span>
                      @endif
                    </label>
                    @if($setting->description)
                      <div class="form-text">{{ $setting->description }}</div>
                    @endif
                  </div>
                  <div class="col-md-8">
                    @if($setting->type === 'boolean')
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                          id="setting_{{ $setting->key }}" 
                          name="settings[{{ $setting->key }}]" 
                          value="1" 
                          {{ $setting->getValue() ? 'checked' : '' }}>
                        <label class="form-check-label" for="setting_{{ $setting->key }}">
                          {{ $setting->getValue() ? 'Enabled' : 'Disabled' }}
                        </label>
                      </div>
                    @elseif($setting->type === 'json')
                      <textarea class="form-control" 
                        id="setting_{{ $setting->key }}" 
                        name="settings[{{ $setting->key }}]" 
                        rows="3">{{ json_encode($setting->getValue(), JSON_PRETTY_PRINT) }}</textarea>
                      <div class="form-text">Enter valid JSON format</div>
                    @elseif($setting->type === 'integer')
                      <input type="number" class="form-control" 
                        id="setting_{{ $setting->key }}" 
                        name="settings[{{ $setting->key }}]" 
                        value="{{ $setting->getValue() }}">
                    @else
                      <input type="text" class="form-control" 
                        id="setting_{{ $setting->key }}" 
                        name="settings[{{ $setting->key }}]" 
                        value="{{ $setting->getValue() }}">
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <div class="text-center py-5">
                <i class="fas fa-cog fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No settings found for {{ $group }}</h5>
                <p class="text-muted">Create some settings to get started.</p>
                <a href="{{ route('settings.create') }}" class="btn btn-primary">
                  <i class="fas fa-plus me-2"></i>Add First Setting
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Group Navigation -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Settings Groups</h5>
          </div>
          <div class="card-body">
            @foreach($availableGroups as $availableGroup)
            <a href="{{ route('settings.edit', $availableGroup) }}" 
               class="btn btn-outline-{{ $availableGroup === $group ? 'primary' : 'secondary' }} w-100 mb-2">
              <i class="fas fa-{{ $availableGroup === 'general' ? 'cog' : ($availableGroup === 'email' ? 'envelope' : ($availableGroup === 'payment' ? 'credit-card' : 'settings')) }} me-2"></i>
              {{ ucfirst($availableGroup) }}
            </a>
            @endforeach
          </div>
        </div>

        <!-- Actions -->
        @if($settings->count() > 0)
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Settings
              </button>
              <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </form>
</div>
@endsection
