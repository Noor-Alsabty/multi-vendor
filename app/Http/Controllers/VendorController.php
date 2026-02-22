<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vendor.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {/*
        $user = Auth::user();
        return view('vendors.request-to-join', compact('user'));*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($user_id, Request $request)
    {/*
        $user = User::findOrFail($user_id);
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'required|string|max:10',
            'store_logo' => 'required|string|max:255',
            'description' =>   'required|string|min:20|max:1000',
        ]);

        /* if ($user_id->vendor) {
            return back()->with('error', 'Can not create 2 store');
        }
*/
        /*    $user->vendor()->create([
            'store_name' => $request->store_name,
            'store_email' => $request->store_email,
            'store_phone' => $request->store_phone,
            'store_logo' => $request->store_logo,
            'description' => $request->description,
            'verification_status' => 'pending',
            'verification_reject_reason' => null,
            'verification_date' => null,
        ]);
        منعمل هي رسالة توصل للمستخدم notification
        return response('Your request is pending');
        */
    }



    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
