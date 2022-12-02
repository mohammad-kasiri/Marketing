<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCaseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalesCaseStatusController extends Controller
{
    public function index()
    {
        $statuses= SalesCaseStatus::all();
        return view('admin.sales_cases.status.index')->with(['statuses' => $statuses]);
    }

    public function create()
    {
        return view('admin.sales_cases.status.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => ['required', 'max:15'],
            'place'     => ['nullable', 'in:0,1,2,3'],
            'is_active' => ['required', 'in:0,1'],
        ]);

        if ($request->place == 1) {
            $alreadyExists= SalesCaseStatus::query()->where('is_first_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }
        if ($request->place == 2) {
            $alreadyExists= SalesCaseStatus::query()->where('is_before_last_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }
        if ($request->place == 3) {
            $alreadyExists= SalesCaseStatus::query()->where('is_last_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }

        SalesCaseStatus::query()->create([
            "name"                => $request->name,
            "is_active"           => $request->is_active,
            "is_first_step"       => $request->place == 1 ? true : false,
            "is_before_last_step" => $request->place == 2 ? true : false,
            "is_last_step"        => $request->place == 3 ? true : false,
        ]);
        Session::flash('message', 'وضعیت با موفقیت ایجاد شد.');
        return redirect()->route('admin.sales-case-status.index');
    }

    public function edit(SalesCaseStatus $status)
    {
        return view('admin.sales_cases.status.edit')->with(['status' => $status]);
    }

    public function update(SalesCaseStatus $status, Request $request)
    {
        $this->validate($request, [
            'name'      => ['required', 'max:15'],
            'place'     => ['nullable', 'in:0,1,2,3'],
            'is_active' => ['required', 'in:0,1'],
        ]);

        if ($request->place == 1) {
            $alreadyExists= SalesCaseStatus::query()->where('id', '!=', $status->id)->where('is_first_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }
        if ($request->place == 2) {
            $alreadyExists= SalesCaseStatus::query()->where('id', '!=', $status->id)->where('is_before_last_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }
        if ($request->place == 3) {
            $alreadyExists= SalesCaseStatus::query()->where('id', '!=', $status->id)->where('is_last_step', true)->exists();
            if ($alreadyExists)
                return  redirect()->back()->withErrors(['place' => 'این جایگاه قبلا برای یک وضعیت دیگر ثبت شده است']);
        }

        $status->update([
            "name"                => $request->name,
            "is_active"           => $request->is_active,
            "is_first_step"       => $request->place == 1 ? true : false,
            "is_before_last_step" => $request->place == 2 ? true : false,
            "is_last_step"        => $request->place == 3 ? true : false,
        ]);
        Session::flash('message', 'وضعیت با موفقیت ویرایش شد.');
        return redirect()->route('admin.sales-case-status.index');
    }
}
