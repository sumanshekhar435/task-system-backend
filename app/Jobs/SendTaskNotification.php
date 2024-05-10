<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssignedNotification;

class SendTaskNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $task_assigned, public Array $deatles)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->task_assigned, new TaskAssignedNotification($this->deatles));
    }
}
