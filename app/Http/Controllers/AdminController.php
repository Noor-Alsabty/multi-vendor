<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorsRequest;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        $vendorsRequests = VendorsRequest::where('status', 'pending')->get();
        return view('vendors-requests.indexAdmin', compact('vendorsRequests'));
    }
    public function verify($id)
    {
        $vendorsRequest = VendorsRequest::findOrFail($id);
        $vendorsRequest->update([
            'status' => 'verified',
        ]);
        $user = $vendorsRequest->user;
        $user->role = 'vendor';
        $user->status = 'active';
        $user->save();
        return redirect()->route('vendors-requests.indexAdmin');
    }
    public function reject(Request $request, $id)
    {
        $vendorsRequest = VendorsRequest::findOrFail($id);
        $vendorsRequest->status = 'rejected';
        $vendorsRequest->reject_reason = $request->reject_reason;
        $vendorsRequest->save();
        return redirect()->route('vendors-requests.indexAdmin');
    }
}
