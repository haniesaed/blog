<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{
    use ApiResponser;
    function all()
    {
        $admin = Admin::find(auth()->id());
        return $this->successResponse([
            'notifications' => $admin->notifications
        ]);
    }

    function unread()
    {
        $admin = Admin::find(auth()->id());
        return $this->successResponse($admin->unread->notifications);
    }

    function markReadAll()
    {
        $admin = Admin::find(auth()->id());
        foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return $this->successResponse(['message' => 'success']);
    }

    function deleteAll()
    {
        $admin = Admin::find(auth()->id());
        $admin->notifications()->delete();
        return $this->successResponse(['message' => 'deleted']);
    }

    function delete($id)
    {
        DB::table('notifications')->where('id' , $id)->delete();
        return $this->successResponse(['message' => 'deleted']);
    }

}
