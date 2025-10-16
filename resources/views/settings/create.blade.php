@extends('layouts.app')

@section('title', 'Create Setting')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Create New Setting</h4>
          <p class="text-muted mb-0">Add a new configuration setting</p>
        </div>
        <div>
          <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Settings
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('settings.store') }}">
    @csrf
    <div class="row">
      <!-- Main Form -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Setting Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="key" class="form-label">Setting Key <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('key') is-invalid @enderror"
                    id="key" name="key" value="{{ old('key') }}" 
                    placeholder="e.g., app_name, email_host" required>
                  @error('key')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">Use lowercase with underscores (e.g., app_name)</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                  <select class="form-select @error('group') is-invalid @enderror" id="group" name="group" required>
                    <option value="">Select Group</option>
                    <option value="general" {{ old('group') == 'general' ? 'selected' : '' }}>General</option>
                    <option value="email" {{ old('group') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="payment" {{ old('group') == 'payment' ? 'selected' : '' }}>Payment</option>
                    <option value="system" {{ old('group') == 'system' ? 'selected' : '' }}>System</option>
                    @foreach($availableGroups as $availableGroup)
                      @if(!in_array($availableGroup, ['general', 'email', 'payment', 'system']))
                        <option value="{{ $availableGroup }}" {{ old('group') == $availableGroup ? 'selected' : '' }}>
                          {{ ucfirst($availableGroup) }}
                        </option>
                      @endif
                    @endforeach
                  </select>
                  @error('group')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="type" class="form-label">Data Type <span class="text-danger">*</span></label>
                  <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">Select Type</option>
                    <option value="string" {{ old('type') == 'string' ? 'selected' : '' }}>String</option>
                    <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                    <option value="integer" {{ old('type') == 'integer' ? 'selected' : '' }}>Integer</option>
                    <option value="json" {{ old('type') == 'json' ? 'selected' : '' }}>JSON</option>
                  </select>
                  @error('type')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="value" class="form-label">Default Value</label>
                  <input type="text" class="form-control @error('value') is-invalid @enderror"
                    id="value" name="value" value="{{ old('value') }}">
                  @error('value')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror"
                id="description" name="description" rows="3">{{ old('description') }}</textarea>
              @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1"
                {{ old('is_public') ? 'checked' : '' }}>
              <label class="form-check-label" for="is_public">
                Public Setting
              </label>
              <div class="form-text">Allow this setting to be accessed publicly</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Actions -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create Setting
              </button>
              <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </div>
        </div>

        <!-- Help -->
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Setting Guidelines</h5>
          </div>
          <div class="card-body">
            <ul class="list-unstyled small">
              <li><i class="fas fa-check text-success me-2"></i>Use descriptive keys</li>
              <li><i class="fas fa-check text-success me-2"></i>Use lowercase with underscores</li>
              <li><i class="fas fa-check text-success me-2"></i>Choose appropriate data type</li>
              <li><i class="fas fa-check text-success me-2"></i>Add helpful descriptions</li>
              <li><i class="fas fa-check text-success me-2"></i>Mark public settings carefully</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
