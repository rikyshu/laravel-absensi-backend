<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PermissionController extends Controller
{
    //create
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'reason' => 'required',
        ]);

        $permission = new Permission();
        $permission->user_id = $request->user()->id;
        $permission->date_permission = $request->date;
        $permission->reason = $request->reason;
        $permission->is_approved = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/permissions', $image->hashName());
            $permission->image = $image->hashName();
        }

        $permission->save();

        return response()->json(['message' => 'Permission created successfully'], 201);

    }

    //view
    public function show($id)
    {
        $permission = Permission::with('user')->find($id);
        return view('pages.permission.show', compact('permission'));
    }

    //edit
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('pages.permission.edit', compact('permission'));
    }

    //update
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->is_approved = $request->is_approved;
        $str = $request->is_approved == 1 ? 'Disetujui' : 'Ditolak';
        $permission->save();
        $this->sendNotificationToUser($permission->user_id, 'Status Izin anda adalah ' . $str);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    public function sendNotificationToUser($userId, $message)
    {
        // Dapatkan FCM token user dari tabel 'users'

        $user = User::find($userId);
        $token = $user->fcm_token;

        // Kirim notifikasi ke perangkat Android
        $messaging = app('firebase.messaging');
        $notification = Notification::create('Status Izin', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }
}
