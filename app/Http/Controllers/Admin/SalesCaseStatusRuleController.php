<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCaseStatus;
use App\Models\SalesCaseStatusRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalesCaseStatusRuleController extends Controller
{
    public function index()
    {
        $rules= SalesCaseStatusRule::query()->with('fromStatus')->with('toStatus')->get();
        $statuses= SalesCaseStatus::query()->active()->get();
        return view('admin.sales_cases.status.rules.index')
            ->with(['rules'     => $rules])
            ->with(['statuses'  => $statuses]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'from' => ['required'],
            'to' => ['required'],
        ]);

        $status= SalesCaseStatus::query()->where('id', $request->from)->exists();
        if(!$status)
            return  redirect()->back()->withErrors(['from' => 'این وضعیت وجود ندارد']);

        $status= SalesCaseStatus::query()->where('id', $request->to)->exists();
        if(!$status)
            return  redirect()->back()->withErrors(['to' => 'این وضعیت وجود ندارد']);



        SalesCaseStatusRule::query()->create([
            'from' => $request->from,
            'to'   => $request->to,
            'is_active'   => true,
        ]);

        Session::flash('message', 'جریان با موفقیت ایجاد شد.');
        return redirect()->route('admin.sales-case-status-rule.index');
    }

    public function destroy(SalesCaseStatusRule $rule)
    {
        $rule->delete();
        Session::flash('message', 'جریان با موفقیت حذف شد.');
        return redirect()->route('admin.sales-case-status-rule.index');
    }
}
