<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    public function index()
    {
        $users= User::query()->orderBy('is_active', 'DESC')->get();
        $statuses= SalesCaseStatus::query()->where('is_last_step', false)->where('is_before_last_step',false)->get();
        $assignments= Assignment::query()->with('from_user')->with('to_user')->with('sales_case_status')->latest()->get();

        return view('admin.assignments.index')
            ->with(["users"          => $users])
            ->with(["assignments"    => $assignments])
            ->with(["statuses"       => $statuses]);
    }

    public function store(Request $request)
    {
        if ($request->from_user_id === $request->to_user_id)
             throw ValidationException::withMessages([
                 'from_user_id' => 'هر دو کاربر نمیتوانند یکی باشند.',
                 'to_user_id'   => 'هر دو کاربر نمیتوانند یکی باشند.'
             ]);

        $fromUser= User::query()->findOrFail($request->from_user_id);
        $toUser= User::query()->findOrFail($request->to_user_id);

        if ($request->sales_case_status_id != 0) {
            $salesCaseStatus= SalesCaseStatus::query()
                ->where('is_last_step', false)
                ->where('is_before_last_step',false)
                ->findOrFail($request->sales_case_status_id);

            $salesCases= SalesCase::query()
                ->where('agent_id', $fromUser->id)
                ->where('status_id', $salesCaseStatus->id)
                ->whereNull('invoice_id')
                ->get();
            $salesCaseStatusID=$salesCaseStatus->id;
        }else{
            $last_status= SalesCaseStatus::query()->where('is_last_step', true)->first();
            $before_last_status= SalesCaseStatus::query()->where('is_before_last_step', true)->first();
            $salesCases= SalesCase::query()
                ->where('agent_id', $fromUser->id)
                ->where('status_id','!=', $last_status->id)
                ->where('status_id','!=', $before_last_status->id)
                ->whereNull('invoice_id')
                ->get();
            $salesCaseStatusID=null;
        }
        $assignment= Assignment::query()->create([
            'from_user_id'         => $fromUser->id,
            'to_user_id'           => $toUser->id,
            'sales_case_status_id' => $salesCaseStatusID,
            'failure_reason_id'    => null,
            'count'                => $salesCases->count()
        ]);
        foreach ($salesCases as $salesCase){
            $assignment->salescases()->attach($salesCase->id);

            $salesCase->update([
               'agent_id' => $toUser->id,
            ]);
        }

        Session::flash('message', 'انتقال با موفقیت انجام شد!');
        return redirect()->back();

    }
}
