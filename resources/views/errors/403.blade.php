@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shield-alt fa-5x text-danger"></i>
                    </div>
                    <h1 class="display-4 text-danger mb-3">403</h1>
                    <h2 class="mb-3">Access Denied</h2>
                    <p class="lead text-muted mb-4">
                        You don't have permission to access this page or perform this action.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
