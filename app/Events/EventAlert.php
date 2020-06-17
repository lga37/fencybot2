<?php

namespace App\Events;

use App\Alert;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $alert;
    public function __construct( $alert)
    {
        $this->alert = $alert;
    }

    public function broadcastOn()
    {
        return ['status-liked'];
        #dd('canallllllll');
        return new PrivateChannel('canal');
    }

    public function broadcastWith ()
    {
        return ['dataaaaaaaaaaaaaa'];
        #return $this->alert->toArray();
    }

    public function broadcastAs()
    {
        #return 'my-event';
        return 'newMessage';
    }


}
