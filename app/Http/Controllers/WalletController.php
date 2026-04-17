<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $vendor = $user?->vendor;

        if (!$vendor) {
            return view('vendor.wallet.index', [
                'wallet' => null,
                'totalDeposits' => 0,
                'totalWithdrawals' => 0,
                'transactions' => collect(),
            ]);
        }

        $wallet = $vendor->wallet()->firstOrCreate([], ['balance' => 0]);
        $transactions = $wallet->transactions()->latest()->get();

        // Build vendor-local order sequence for deposit transactions only.
        $depositIdsByOrder = $wallet->transactions()
            ->where('type', 'deposit')
            ->oldest()
            ->pluck('id')
            ->values();

        $depositSequenceById = $depositIdsByOrder
            ->flip()
            ->map(fn ($index) => $index + 1);

        $transactions->transform(function ($transaction) use ($depositSequenceById) {
            $transaction->display_description = $transaction->description;

            if ($transaction->type === 'deposit' && isset($depositSequenceById[$transaction->id])) {
                $transaction->display_description = 'أرباح الطلب رقم: ' . $depositSequenceById[$transaction->id];
            }

            return $transaction;
        });

        $totalDeposits = $wallet->transactions()->deposits()->sum('amount');
        $totalWithdrawals = $wallet->transactions()->withdrawals()->sum('amount');

        return view('vendor.wallet.index', compact('wallet', 'totalDeposits', 'totalWithdrawals', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        Gate::authorize('view', $wallet);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        Gate::authorize('update', $wallet);
        $wallet->update([
        'balance' => $request->balance
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
