<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FailureReason;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Models\SalesCaseStatusHistory;
use App\Models\SalesCaseStatusRule;
use App\Models\SMS;
use App\Models\SMSLog;
use App\Models\User;
use App\Sms\Kavenegar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Morilog\Jalali\Jalalian;

class SalesCaseController extends Controller
{
    public function index()
    {
        $agents= User::query()->agents()->get();
        $statuses= SalesCaseStatus::query()->active()->get();
        $salesCases= SalesCase::query();

        if (request()->has('fullname') && request()->input('fullname') != null )
        {
            $salesCases= $salesCases->whereRelation('customer','fullname', 'LIKE' , '%'.\request()->input('fullname').'%');
        }else{
            $salesCases= $salesCases->with('customer');
        }

        if (request()->has('mobile') && request()->input('mobile') != null )
        {
            $salesCases= $salesCases->whereRelation('customer','mobile', 'LIKE' , '%'.\request()->input('mobile').'%');
        }else{
            $salesCases= $salesCases->with('customer');
        }

        if (\request()->has('status_id') &&  \request()->input('status_id') != null)
        {
            $salesCases= $salesCases->where('status_id', \request()->get('status_id'));
        }

        if (\request()->has('agent_id')  &&  \request()->input('agent_id') != null)
        {
            $salesCases= \request()->input('agent_id') == 0
                ? $salesCases->where('agent_id', null)
                : $salesCases->where('agent_id', \request()->get('agent_id'));
        }

        $salesCases= $salesCases
            ->with('products')
            ->with('agent')
            ->with('status')
            ->latest()
            ->paginate(50);

        return view('admin.sales_cases.index')
            ->with(['statuses'  => $statuses])
            ->with(['agents'  => $agents])
            ->with(['salesCases'  => $salesCases]);
    }

    public function show(SalesCase $salesCase)
    {
        $salesCase= SalesCase::query()->where('id', $salesCase->id)->with('invoice.products')->first();
        $smsTemplates= SMS::query()->active()->get();
        $smsLogs= SMSLog::query()->where('sales_case_id', $salesCase->id)->with('agent')->get();
        $salesCaseStatuses = SalesCaseStatus::query()->where('id', '!=', $salesCase->status_id)->get();
        $failureReasons=FailureReason::query()->get();
        $salesCaseStatusHistories= SalesCaseStatusHistory::query()->where('sales_case_id', $salesCase->id)->with('status')->latest()->get();
        $agents= User::query()->agents()->latest()->get();

        return view('admin.sales_cases.show')
            ->with(['smsTemplates' => $smsTemplates])
            ->with(['smsLogs' => $smsLogs])
            ->with(['salesCaseStatuses' => $salesCaseStatuses])
            ->with(['salesCaseStatusHistories' => $salesCaseStatusHistories])
            ->with(['failureReasons' => $failureReasons])
            ->with(['agents' => $agents])
            ->with(['salesCase' => $salesCase]);
    }

    public function sendSms(SalesCase $salesCase, Request $request)
    {
        //$sms = SMS::query()->findOrFail($request->sms_id);
        \App\Sms\SMS::for($salesCase->customer->mobile)->send($request->sms);

        SMSLog::query()->create([
            'sales_case_id'  => $salesCase->id,
            'customer_id'    => $salesCase->customer->id,
            'agent_id'       => auth()->id(),
            'template_id'    => 0,
            'text'           => $request->sms
        ]);

        Session::flash('message', 'پیام با موفقیت ارسال شد.');
        return redirect()->back();
    }

    public function status(SalesCase $salesCase, Request $request )
    {
        $this->validate($request, [
            'status_id'   => ['required'],
            'description' => ['required', 'max:190']
        ]);
        $status= SalesCaseStatus::query()->findOrFail($request->status_id);

        SalesCaseStatusHistory::query()->create([
            'sales_case_id' => $salesCase->id,
            'status_id'     => $status->id,
            'user_id'       => auth()->id(),
            'description'   => $request->description
        ]);
        $salesCase->update([
            'status_id'  => $status->id
        ]);

        Session::flash('message', 'وضعیت پرونده با موفقیت ویرایش شد.');
        return redirect()->back();
    }
    public function description(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'description'   => ['required', 'max:600'],
            ]);

        $separator = $salesCase->description != null ? "<br><br>" :null;
        $salesCase->update([
            'description'  => $salesCase->description.
                "$separator<b>".
                auth()->user()->full_name.
                "</b> [ ".Jalalian::now()."] : " .$request->description
        ]);

        Session::flash('message', 'توضیحات پرونده با موفقیت ویرایش شد.');
        return redirect()->back();
    }
    public function adminNote(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'admin_note'   => ['required', 'max:600'],
        ]);


        $separator = $salesCase->admin_note != null ? "<br><br>" :null;


        $salesCase->update([
            'admin_note'  => $salesCase->admin_note.
                            "$separator<b>مدیریت: </b> [ ".Jalalian::now()." ] :" .$request->admin_note
        ]);

        Session::flash('message', 'توضیحات مدیر با موفقیت ویرایش شد.');
        return redirect()->back();
    }

    public function close(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'failure_reason_id'=> ['required', 'int'],
            'failure_reason'   => ['max:190'],
        ]);

        $failureReason= FailureReason::query()->findOrFail($request->failure_reason_id);

        $salesCase->update([
            'failure_reason_id'  => $failureReason->id,
            'failure_reason'     => $request->failure_reason,
        ]);

        Session::flash('message', 'پرونده بسته شد.');
        return redirect()->back();
    }
    public function open(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'open'=> ['required', 'in:open'],
        ]);
        $salesCase->update([
            'failure_reason_id'  =>null,
            'failure_reason'     =>null,
        ]);

        Session::flash('message', 'پرونده از سر گرفته شد.');
        return redirect()->back();
    }

    public function promotion(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'is_promoted'=> ['required', 'in:1,0'],
        ]);
        $salesCase->update([
            'is_promoted' => (bool)$request->is_promoted,
        ]);

        Session::flash('message', ' الویت پرونده تغییر کرد.');
        return redirect()->back();
    }
    public function changeAgent(SalesCase $salesCase, Request $request)
    {
        $this->validate($request, [
            'agent_id'=> ['required'],
        ]);
        $user = User::query()->findOrFail($request->agent_id);
        $salesCase->update([
            'agent_id' => $user->id,
        ]);

        Session::flash('message', ' ایجنت پرونده تغییر کرد.');
        return redirect()->back();
    }
}
