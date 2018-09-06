<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PetArrived extends Notification
{
    use Queueable;

    protected $email;
    protected $token;
    protected $zip;
    protected $distance;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $zip, $distance)
    {
        $this->email = $user->email;
        $this->token = $user->token;
        $this->zip = $zip;
        $this->distance = $distance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('We Found Puppies Near You')
                    ->greeting('Good News! ')
                    ->line("A puppy has been dropped off within $this->distance miles of a shelter near zip code $this->zip.  Check it out below!")
                    ->action('Show Me', url("/results/$this->email/$this->token"))
                    ->line('Thank you for using our service! We hope you find your new best friend.');
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
