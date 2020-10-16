<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     * Purpose: Create a notification by rest URL. Accepts the notification text. Creates it and links to the authenticated user.
     */
    public function store(Request $request)
    {
        /**Validate the data using validation rules*/
        $validator = Validator::make($request->all(), [
            'notification'     => 'required',
        ]);

        /**Check the validation becomes fails or not */
        if ($validator->fails()) {
            /**Return error message */
            return response()->json(['error' => $validator->errors()], 400);
        }

        $this->user = \Auth::user();
        $notification = $this->notification->create([
            'user_id' => \Auth::user()->id,
            'notification' => $request->notification
        ]);

        return response()->json(['success' => $notification], 200);

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

    /*
     * Created By: Kade Price
     * Purpose: Mark selected notification for the logged in user as read. Uses Token from Login to accept logged in user.
     */
    public function markRead(Request $request)
    {
        $this->user = \Auth::user();

        if ($this->notification->findOrFail($request->id)->setReadStatus(true)) {
            return response()->json(['success' => 'Notification marked as Read'], 200);

        }
        //User doesn't own this notification, so return unauthorized.
        return response()->json(['unauthorized' => 'Unauthorized'], 403);

    }

    /*
     * Created By: Kade Price
     * Purpose: Mark selected notification for the logged in user as unread. Uses Token from Login to accept logged in user.
     */
    public function markUnread(Request $request)
    {
        $this->user = \Auth::user();

        if ($this->notification->findOrFail($request->id)->setReadStatus(false)) {
            return response()->json(['success' => 'Notification marked as Unread'], 200);
        }
        //User doesn't own this notification, so return unauthorized.
        return response()->json(['unauthorized' => 'Unauthorized'], 403);

    }
}
