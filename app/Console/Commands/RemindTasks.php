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
            ->where('remind_at', '>=', now()->subHour())
            ->with('user')
            ->get();

        foreach ($tasks as $task)
        {
            $message='این پیام جهت یادآوری کار" '. Str::limit($task->title , 25) .' "ارسال شده است. ';
            SMS::for($task->user->mobile)->send($message);
        }
    }
}
