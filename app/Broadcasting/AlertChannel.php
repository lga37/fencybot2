<?php

namespace App\Broadcasting;

use App\User;
use App\Alert;

class AlertChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, Alert $alert)
    {
        return true;
        #return $user->id === $order->user_id;
    }
}
