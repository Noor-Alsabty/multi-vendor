@extends('layouts.app')

@section('content')
<div class="container py-5" style="font-family: 'Inter', sans-serif;">
    <h2 class="mb-4 fw-bold">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm mb-4" style="border-radius: 12px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: #f8f9fa;">
                    <h5 class="mb-4 fw-bold text-dark">Shipping Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted small">Full Name</label>
                            <input type="text" name="customer_name" class="form-control border-0 p-3 shadow-sm" placeholder="John Doe" required style="border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Phone Number</label>
                            <input type="text" name="phone" class="form-control border-0 p-3 shadow-sm" placeholder="+123 456 789" required style="border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">City</label>
                            <input type="text" name="city" class="form-control border-0 p-3 shadow-sm" placeholder="New York" required style="border-radius: 10px;">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted small">Address Details</label>
                            <textarea name="address" class="form-control border-0 p-3 shadow-sm" rows="3" placeholder="Street, Apartment, Building..." required style="border-radius: 10px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-4 p-4" style="border-radius: 16px;">
                    <h5 class="mb-3 fw-bold">Payment Method</h5>
                    <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                        <input type="radio" checked class="form-check-input me-3">
                        <span class="fw-bold">Credit Card (Stripe)</span>
                        <div class="ms-auto">
                            <i class="fab fa-cc-visa me-2 text-primary h4"></i>
                            <i class="fab fa-cc-mastercard text-danger h4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg p-4 text-white" style="border-radius: 20px; background: #000;">
                    <h5 class="mb-4 opacity-75">Order Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="opacity-75">Subtotal</span>
<span class="fw-bold">${{ number_format($totalAmount, 2) }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-4 border-top pt-3">
                    <span class="h5">Total</span>
                    <span class="h4 fw-black">${{ number_format($totalAmount, 2) }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 fw-bold shadow-lg mt-3" 
                            style="border-radius: 12px; background: #635bff; border: none; font-size: 1.1rem;">
                        Pay Securely with Stripe
                    </button>
                    
                    <p class="text-center small opacity-50 mt-4">
                        <i class="fas fa-lock me-1"></i> Your payment is encrypted and secure.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection