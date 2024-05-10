<?php

namespace App\Listeners;

use App\Events\TaskAssignedEvent;
use App\Jobs\SendTaskNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssignedNotification;

class SendTaskAssignedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssignedEvent $event): void
    {
        $task_assigned = $event->task->user;

        $user_name = $event->task->user->name;
        $deatles = compact('user_name');

        SendTaskNotification::dispatch($task_assigned, $deatles);
    }
}
