<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use TelegramNotifications\TelegramChannel;
use Illuminate\Notifications\Messages\MailMessage;
use TelegramNotifications\Messages\TelegramMessage;
use TelegramNotifications\Messages\TelegramCollection;

class TelegramNotification extends Notification
{
    use Queueable;



    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return [TelegramChannel::class];
    }

/*
    public function toTelegram ()
    {
        return (new TelegramMessage())->text('Hello, world!');
    }
*/

    public function toTelegram($msg,$type,$lat,$lng)
    {
        return (new TelegramCollection())
            ->message(['text' => $msg,'parse_mode'=>'html'])
            ->location(['latitude' => 55.755768, 'longitude' => 37.617671])
            ->venue(
                ['latitude' => 55.755768, 'longitude' => 37.617671,
                'title'=>'title','address'=>'address','foursquare_id'=>'foursquare_id',]
                )

            ->sticker(['sticker' => 'CAADBQADJwEAAl7ylwK4Q0M5P7UxhQI']);
    }




    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
