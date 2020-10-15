<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'read', 'notification'];

    /*
     * Created By: Kade Price
     * Purpose: Set the status of the notification to true or false. Verify that this notification is owned by the logged in user.
     * Set Status and save.
     *
     */
    public function setReadStatus($status)
    {
        if (\Auth::user()->id == $this->user_id) {

            $this->read = $status;
            $this->save();
            return true;

        } else return false;

    }


}
