<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification 
{
    use Queueable;

    public $comment, $post;
    public function __construct($comment, $post)
    {
        //
        $this->comment = $comment;
        $this->post = $post;
    }
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' =>  $this->post->slug,
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' =>  $this->post->slug,
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' =>  $this->post->slug,
        ];
    }

    public function databaseType(): string
    {
        return 'NewCommentNotify';
    }
}
