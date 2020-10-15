<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    private $notification;
    private $user;
    /**
     * NotificationController constructor.
     */
    public function __construct(Notification $notification, User $user)
    {
        $this->notification = $notification;
        $this->user = $user;
    }

    /*
     * Created By: Kade Price
     * Purpose: Return all unread notification for the logged in user. Uses Token from Login to accept logged in user.
     */
    public function showUnread()
    {
        $this->user = \Auth::user();

        return response()->json(['success' => $this->user->notificationsUnread()->get()], 200);
    }

    /*
     * Created By: Kade Price
     * Purpose: Return all notification for the logged in user. Uses Token from Login to accept logged in user.
     */
    public function showAll()
    {
        $this->user = \Auth::user();

        return response()->json(['success' => $this->user->notificationsAll()->get()], 200);
    }

    public function markRead(Request $request)
    {
        $this->user = \Auth::user();
        if($this->notification->find($request->id)->setReadStatus(true)){
            return response()->json(['success' => 'Notification marked as Read'], 200);

        }
        return response()->json(['unauthorized' => 'Unauthorized'], 403);

    }


    public function markUnread(Request $request)
    {
        $this->user = \Auth::user();

        if($this->notification->find($request->id)->setReadStatus(false)) {
            return response()->json(['success' => 'Notification marked as Unread'], 200);
        }

        return response()->json(['unauthorized' => 'Unauthorized'], 403);

    }
}