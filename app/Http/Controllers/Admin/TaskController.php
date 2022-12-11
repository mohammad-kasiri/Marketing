<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\SalesCase;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function index()
    {
        $tasks= Task::query()->with('salesCase')->where('user_id', auth()->id())->latest()->get();
        return view('admin.tasks.index')
            ->with(['tasks' => $tasks]);
    }

    public function create(SalesCase $salesCase)
    {
        return view('admin.tasks.create')
            ->with(['salesCase' => $salesCase]);
    }

    public function store(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'title'       => ['required' ,'max:200'],
            'note'        => ['nullable'],
            'remind_date' => ['required' , 'min:10' , 'max:10'],
            'remind_time' => ['required'],
        ]);

        $task= Task::query()->create([
            'user_id'      => auth()->id(),
            'sales_case_id'=> $salesCase->id,
            'title'        => $request->title,
            'note'         => $request->note,
            'remind_at'    => DateFormatter::format($request->remind_date , $request->remind_time),
        ]);

        Session::flash('message', 'کار با موفقیت ایجاد شد.');
        return redirect()->route('admin.task.index', ['salesCase' => $salesCase->id]);
    }

    public function edit(Task $task)
    {
        if ($task->user_id != auth()->id())    abort(401);
        return view('admin.tasks.edit')->with(['task'=> $task]);
    }

    public function update(Task $task, Request $request)
    {
        if ($task->user_id != auth()->id())    abort(401);
        $this->validate($request, [
            'title'       => ['required' ,'max:200'],
            'note'        => ['nullable'],
            'remind_date' => ['required' , 'min:10' , 'max:10'],
            'remind_time' => ['required'],
        ]);

        $task->update([
            'title'        => $request->title,
            'note'         => $request->note,
            'remind_at'    => DateFormatter::format($request->remind_date , $request->remind_time),
        ]);

        Session::flash('message', 'کار با موفقیت ویرایش شد.');
        return redirect()->route('admin.task.edit', ['task' => $task->id]);
    }

    public function destroy(SalesCase $salesCase, Task $task)
    {
        if ($task->user_id != auth()->id())    abort(401);
        $task->delete();
        Session::flash('message', 'کار با موفقیت حذف شد.');
        return redirect()->route('admin.task.index', ['saleCase' => $salesCase->id]);
    }

    public function markAsDone(Task $task)
    {
        if ($task->user_id != auth()->id())    abort(401);
        $task->markAsDone();
        return redirect()->back();
    }
    public function markAllAsDone(Task $task)
    {
        Task::markAllAsRead();
        return redirect()->back();
    }
}
