@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-store me-2"></i>All Vendors Management</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Store Name</th>
                        <th>Owner</th>
                        <th>Contact Info</th>
                        <th class="text-center">Current Balance</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <div class="fw-bold text-dark">{{ $vendor->store_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $vendor->user->name ?? 'N/A' }}</td>
                        <td>
                            <small class="d-block">
                                <i class="fas fa-envelope text-muted me-1"></i> {{ $vendor->store_email }}
                            </small>
                            <small class="d-block">
                                <i class="fas fa-phone text-muted me-1"></i> {{ $vendor->store_phone }}
                            </small>
                        </td>
                        <td class="text-center">
                            {{-- Wallet Balance Integration --}}
                            <span class="badge bg-soft-success text-success fs-6 border border-success px-3">
                                {{ number_format($vendor->wallet->balance ?? 0, 2) }} $
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Financial Statement">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No vendors registered yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: #e8f5e9; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endsection