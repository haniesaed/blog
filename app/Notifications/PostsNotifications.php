<?php

namespace App\Notifications;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostsNotifications extends Notification
{
    use Queueable;

    protected Post $post;
    protected Author $author;
    /**
     * Create a new notification instance.
     */
    public function __construct($post , $author)
    {
        $this->author = $author;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "author" => $this->author,
            "post" => $this->post
        ];
    }
}
