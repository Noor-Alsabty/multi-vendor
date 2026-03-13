<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $notifications=Auth::user()->notifications;
    return view('welcome',compact('notifications'));
        //
    }
    public function read($notification_id){
    $notification=Notification::find($notification_id);
    if($notification->status == "unread"){
    $notification->status="read";
    $notification->save();}
    // return redirect()->back()->with('success','notification marked as read');
      if (Auth::user()->role == 'admin') {
        return redirect()->route('vendors-requests.indexAdmin');
    } else {
        return redirect()->route('vendor.dashboard');
    }

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
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
