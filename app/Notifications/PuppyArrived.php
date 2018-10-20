<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PuppyArrived extends Notification
{
    use Queueable;

    protected $email;
    protected $token;
    protected $options;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $options)
    {
        $this->email = $user->email;
        $this->token = $user->token;

        $this->options = $options;
        $this->options['greeting'] = 'Good News!';
        $this->options['body'] = "A puppy has been dropped off within ". $this->options['miles']. " miles of a shelter near zip code ".$this->options['zip']. "Check it out below!";
        $this->options['line'] = "Thank you for using our service! We hope you find your new best friend.";
        $this->options['actionText1'] = 'Show Me';
        $this->options['actionText2'] = 'Unsubscribe';
        $this->options['actionUrl1'] = url("/results/$this->email/$this->token");
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
            ->markdown('mail.puppyarrived', $this->options);
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
