<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorsRequest;
use App\Models\User;

class VendorsRequestController extends Controller
{
    public function index()
    {
        $existingRequest = VendorsRequest::where('user_id', Auth::id())->latest()->first();
        return view('vendors-requests.index', compact('existingRequest'));
    }

    public function create()
    {
        $existingRequest = VendorsRequest::where('user_id', Auth::id())->latest()->first();
        return view('vendors-requests.create', compact('existingRequest'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'required|string|max:10',
            'store_logo' => 'required|string|max:255',
            'description' =>   'required|string|max:1000',
        ]);

        Auth::user()->vendorsRequests()->create([
            'store_name' => $request->store_name,
            'store_email' => $request->store_email,
            'store_phone' => $request->store_phone,
            'store_logo' => $request->store_logo,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        // منعمل هي رسالة توصل للمستخدم notification
        return response('The request has been sent successfully');
    }
}
