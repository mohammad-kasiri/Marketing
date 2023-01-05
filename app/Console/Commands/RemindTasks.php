<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Sms\Kavenegar;
use App\Sms\SMS;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RemindTasks extends Command
{
    protected $signature = 'remind:task';
    protected $description = 'Remind Tasks with SMS';

    public function handle()
    {
        $tasks= Task::query()
            ->where('done_at', null)
            ->where('remind_at','<=', now())
            ->where('remind_at', '>=', now()->subMinutes(5))
            ->where('first_notify', null)
            ->with('user')
            ->get();

        foreach ($tasks as $task)
        {
            SMS::for($task->user->mobile)
                ->template('reminder')
                ->setFirstToken($task->user->first_name)
                ->sendLookUp();
            $task->first_notify = true;
            $task->save();
        }

        $tasks= Task::query()
            ->where('done_at', null)
            ->where('remind_at','<=', now()->subMinutes(5))
            ->where('remind_at', '>=', now()->subMinutes(10))
            ->where('first_notify', true)
            ->where('second_notify', null)
            ->with('user')
            ->get();

        foreach ($tasks as $task)
        {
            SMS::for($task->user->mobile)
                ->template('reminder')
                ->setFirstToken($task->user->first_name)
                ->sendLookUp();
            $task->second_notify = true;
            $task->save();
        }
    }
}
