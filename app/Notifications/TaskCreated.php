<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreated extends Notification
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎯 Nieuwe Taak Aangemaakt!')
            ->greeting('Hallo ' . $notifiable->name . '!')
            ->line('Je hebt een nieuwe taak aangemaakt:')
            ->line('**Titel:** ' . $this->task->title)
            ->line('**Beschrijving:** ' . ($this->task->description ?? 'Geen beschrijving'))
            ->line('**Status:** ' . ucfirst(str_replace('_', ' ', $this->task->status)))
            ->action('Bekijk Taak', route('tasks.show', $this->task->id))
            ->line('Succes met het voltooien van je taak!')
            ->salutation('Met vriendelijke groet, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Je hebt een nieuwe taak aangemaakt: ' . $this->task->title,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'task_status' => $this->task->status,
            'action_url' => route('tasks.show', $this->task->id),
            'type' => 'task_created'
        ];
    }
}
