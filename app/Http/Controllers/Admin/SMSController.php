<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SMSController extends Controller
{
    public function index()
    {
        $smses= SMS::query()->get();
        return view('admin.sms.index')->with(['smses' => $smses]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'template_id' => ['required', 'max:30'],
            'text'        => ['required', 'max:191'],
            'is_active'   => ['required', 'in:0,1']
        ]);

        SMS::query()->create([
           'template_id' => $request->template_id,
           'text'        => $request->text,
           'is_active'   => (bool) $request->is_active
        ]);

        Session::flash('message', 'پیامک با موفقیت ایجاد شد.');
        return redirect()->route('admin.sms.index');
    }
    public function edit(SMS $sms)
    {
        return view('admin.sms.edit')->with(['sms' => $sms]);
    }

    public function update(SMS $sms, Request $request)
    {
        $this->validate($request, [
            'template_id' => ['required', 'max:30'],
            'text'        => ['required', 'max:191'],
            'is_active'   => ['required', 'in:0,1']
        ]);

        $sms->update([
            'template_id' => $request->template_id,
            'text'        => $request->text,
            'is_active'   => (bool) $request->is_active
        ]);

        Session::flash('message', 'پیامک با موفقیت ویرایش شد.');
        return redirect()->route('admin.sms.edit', ['sms' => $sms->id]);
    }

}
