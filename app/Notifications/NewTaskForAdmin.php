<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTaskForAdmin extends Notification
{
    use Queueable;

    public $task;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
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
            ->subject('📋 Nieuwe Taak in het Systeem')
            ->greeting('Hallo Admin!')
            ->line('Er is een nieuwe taak aangemaakt door een gebruiker:')
            ->line('**Gebruiker:** ' . $this->user->name . ' (' . $this->user->email . ')')
            ->line('**Taak:** ' . $this->task->title)
            ->line('**Beschrijving:** ' . ($this->task->description ?? 'Geen beschrijving'))
            ->line('**Status:** ' . ucfirst(str_replace('_', ' ', $this->task->status)))
            ->action('Bekijk Alle Taken', route('tasks.index'))
            ->line('Dit is een automatische melding van het taken-systeem.')
            ->salutation('Systeem Notificatie');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->user->name . ' heeft een nieuwe taak aangemaakt: ' . $this->task->title,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'task_status' => $this->task->status,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'action_url' => route('tasks.index'),
            'type' => 'new_task_for_admin'
        ];
    }
}
