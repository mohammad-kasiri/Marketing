<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FailureReason;
use App\Models\SalesCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FailureReasonController extends Controller
{
    public function index()
    {
        $reasons= FailureReason::query()->get();
        return view('admin.failure_reasons.index')->with(['reasons' => $reasons]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'min:1', 'max:20']
        ]);

        FailureReason::query()->create([
           'title' => $request->title
        ]);

        Session::flash('message', ' دلیل شکست با موفقیت ایجاد شد.');
        return  redirect()->route('admin.failure-reasons.index');
    }

    public function destroy(FailureReason $reason)
    {
        if (!$reason->is_deletable)
            return redirect()->back();

        SalesCase::query()->where('failure_reason_id', $reason->id)->update(
            ['failure_reason_id' => null]
        );
        $reason->delete();

        Session::flash('message', 'حذف دلیل شکست با موفقیت انجام شد.');
        return  redirect()->route('admin.failure-reasons.index');
    }
}
