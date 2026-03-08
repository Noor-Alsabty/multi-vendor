@extends('layouts.vendor')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-3 text-center">
                    <h6 class="text-white-50 uppercase small">Current Balance</h6>
                    <h2 class="fw-bold mb-0">{{ number_format($wallet->balance, 2) }} $</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <h6 class="text-muted uppercase small">Total Earnings</h6>
                    {{-- استخدام الـ Scope لحساب المجموع --}}
                    <h2 class="fw-bold mb-0 text-success">+{{ number_format($wallet->transactions()->deposits()->sum('amount'), 2) }} $</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <h6 class="text-muted uppercase small">Total Withdrawals</h6>
                    {{-- استخدام الـ Scope لحساب السحوبات --}}
                    <h2 class="fw-bold mb-0 text-danger">-{{ number_format($wallet->transactions()->withdrawals()->sum('amount'), 2) }} $</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold">Recent Transactions</h5>
        </div>
        <div class="card-body p-0 text-center">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wallet->transactions()->latest()->get() as $transaction)
                        <tr>
                            <td>
                                <span class="badge {{ $transaction->type == 'deposit' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} $
                            </td>
                            <td class="text-muted small">{{ number_format($transaction->balance_before, 2) }} $</td>
                            <td class="fw-bold">{{ number_format($transaction->balance_after, 2) }} $</td>
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-5 text-muted">No transactions found in your history.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection