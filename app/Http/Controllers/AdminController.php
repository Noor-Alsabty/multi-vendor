<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\VendorsRequest;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        $vendorsRequests = VendorsRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();
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
        $vendor = Vendor::updateOrCreate(
        ['user_id' => $user->id],
        ['store_name' => $vendorsRequest->store_name]
    );
        $vendor->wallet()->firstOrCreate(
    ['vendor_id' => $vendor->id], // ابحث عن محفظة لهذا البائع
    ['balance' => 0]              // إذا لم تجد، أنشئ واحدة برصيد صفر
);
    
    // 🔔    إرسال إشعار للبائع بقبول المتجر
        $notification= new  Notification();
    $notification->user_id = $user->id;
        $notification->title=" store  approved";
    
        $notification->message = "Your store {$vendorsRequest->store_name} has been approved";

        $notification->save();
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

public function allVendors()
{
    $vendors = Vendor::with('wallet')->latest()->get();
    return view('vendors.index', compact('vendors'));
}
}
