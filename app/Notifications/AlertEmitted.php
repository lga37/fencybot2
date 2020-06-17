<?php

namespace App\Notifications;

use App\Alert;
use Illuminate\Bus\Queueable;
use App\Mail\AlertEmitted as AlertE;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AlertEmitted extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function via()
    {
        #dd($s);
        return ['mail', 'broadcast', 'database', ];
        #return ['mail', ];
    }

    public function toBroadcast ($notifiable) # e o user
    {
        #dd($notifiable);
        return new BroadcastMessage([
            'notification'=>$this->alert,
            'id'=>$this->id,
            'read_at'=> null,
            'data'=> [
                #'device'=>$this->alert->load('device'),
                'device2'=>$this->alert->device,
                'alert'=>$this->alert,
                #'device3'=>$this->device,
            ]
        ]);
    }

    public function toArray ($notifiable)
    {
        #dd($notifiable);
        return [
            'id'=>$this->id,
            'read_at'=> null,
            'data'=> [
                'device'=>$this->alert->load('device'),
                'device2'=>$this->alert->device,
                #'device3'=>$this->device,
            ]
        ];
    }


    public function toDatabase($notifiable)
    {
        return [
            'alert'=>$this->alert,
        ];
    }

    public function toMail($notifiable)
    {
        return (new AlertE($this->alert))->to($notifiable->email);;
/*         return (new MailMessage)
            ->subject('deedeededee')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
 */    }


}
