<?php

namespace App\Notifications;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
  
class WelcomeMailNotification extends Notification
{
    use Queueable;
  
    public $user;
  
    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
  
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
  
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $mailData = [
            'first_name' => $this->user->first_name, // Changed from 'name' to 'first_name'
            'email' => $this->user->email
        ];
  
        return (new MailMessage)->markdown(
            'email.welcome', ['mailData' => $mailData]
        );
    }
  
    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
