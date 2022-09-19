<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::query()->latest()->paginate(25);
        return view('admin.transactions.index')->with(['transactions' => $transactions]);
    }

    public function store(User $user,Request $request)
    {
        $this->validate($request, [
            'total'          => ['required'],
            'percentage'     => ['required'],
            'from_date'      => ['required'],
            'to_date'        => ['required'],
            'tracing_number' => ['nullable' , 'max:100'],
            'description'    => ['nullable' , 'max:300']
        ]);

        Transaction::query()->create([
           'agent_id'        => $user->id,
           'admin_id'       => auth()->user()->id,
           'total'          => str_replace(',' , '', $request->total),
           'percentage'     => str_replace(',' , '', $request->percentage),
           'from_date'      => DateFormatter::format($request->from_date, "00:00"),
           'to_date'        => DateFormatter::format($request->to_date, "00:00"),
           'tracing_number' => $request->tracing_number,
           'description'    => $request->description,
        ]);

        Session::flash('message', ' پورسانت   با موفقیت ایجاد شد.');
        return redirect()->back();
    }

    public function edit(Transaction $transaction)
    {
        return view('admin.transactions.edit')
            ->with(['transaction' => $transaction]);
    }

    public function update(Transaction $transaction, Request $request)
    {
        $this->validate($request, [
            'tracing_number' => ['nullable' , 'max:100'],
            'status'         => ['required' , 'in:created,paid'],
            'description'    => ['nullable' , 'max:300']
        ]);

        $transaction->update([
            'status'         => $request->status,
            'tracing_number' => $request->tracing_number,
            'description'    => $request->description,
        ]);

        Session::flash('message', ' پورسانت   با موفقیت ایجاد شد.');
        return redirect()->route('admin.transaction.index');
    }

    public function status(Transaction $transaction, Request $request)
    {
        $this->validate($request, [
            'status' => ['required' , 'in:created,paid']
        ]);

        $transaction->status = $request->status;
        $transaction->save();
        return redirect()->back();

    }
}
