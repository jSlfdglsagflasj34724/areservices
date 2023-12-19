<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Notification collection
        $notifications =  NotificationResource::collection(Notification::where('user_id', Auth::id())->paginate(100));
        
        // update status of is_read for particular user
        Notification::where('user_id', Auth::id())->update(['is_read' => 1]);

        return $notifications;
    }
}
