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
            ->where('remind_at', '>=', now()->minutes(5))
            ->where('first_notify', null)
            ->with('user')
            ->get();

        foreach ($tasks as $task)
        {
            $message='این پیام جهت یادآوری کار" '. Str::limit($task->title , 25) .' "ارسال شده است. ';
            SMS::for($task->user->mobile)->send($message);
            $task->first_notify = true;
            $task->save();
        }

        $tasks= Task::query()
            ->where('done_at', null)
            ->where('remind_at','<=', now()->subMinutes(5))
            ->where('remind_at', '>=', now()->minutes(10))
            ->where('first_notify', true)
            ->where('second_notify', null)
            ->with('user')
            ->get();

        foreach ($tasks as $task)
        {
            $message='این دومین پیام جهت یادآوری کار" '. Str::limit($task->title , 25) .' "ارسال شده است. ';
            SMS::for($task->user->mobile)->send($message);
            $task->second_notify = true;
            $task->save();
        }
    }
}
