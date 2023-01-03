<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query()->with('user')->with('salesCase.customer')->filter(request()->all()) ;
        $users    = User::all();

        return view('admin.invoices.index')
            ->with(['users'    => $users])
            ->with(['invoices' => $invoices]);
    }
    public function edit(Invoice $invoice)
    {
        $products= Product::all();
        $saleCase= SalesCase::query()->where('invoice_id', $invoice->id)->first();

        return view('admin.invoices.edit')
            ->with(['invoice' => $invoice])
            ->with(['saleCase' => $saleCase])
            ->with(['products' => $products]);
    }

    public function update(Invoice $invoice, Request $request)
    {
        $this->validate($request , [
            'price'                 => ['required'],
            'paid_by'               => ['required','in:card,gateway,site'],

            'account_number'        => ['required_if:paid_by,==,card'   ,'bail'],
            'gateway_tracking_code' => ['required_if:paid_by,==,gateway','bail'],
            'order_number'          => ['required_if:paid_by,==,site'   ,'bail'],

            'description'           => ['nullable'],
            'products'              => ['required' , 'array'],
            'products.*'            => ['required' , 'numeric'],
            'status'                => ['required' , 'in:sent,approved,rejected,suspicious'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);
        $firstStatus= $invoice->status;
        $invoice->update([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'order_number'          => $request->order_number,
            'description'           => $request->description,
            'status'                => $request->status,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }

        if ($firstStatus != 'approved' && $request->status == 'approved'){
            $saleCase= SalesCase::query()->where('invoice_id', $invoice->id)->first();
            if ($saleCase) {
                $saleCaseLastStatus = SalesCaseStatus::query()->where('is_last_step', true)->first();
                $saleCase->update([
                    'status_id' => $saleCaseLastStatus->id
                ]);
            }
        }

        Session::flash('message', 'رسید با موفقیت ویرایش شد.');
        return redirect()->route('admin.invoice.index');
    }

    public function destroy(User $agent, Invoice $invoice)
    {
        SalesCase::query()->where('invoice_id', $invoice->id)->update([
           'invoice_id' => null,
           'status_id'  => SalesCaseStatus::query()->where('is_first_step',1)->first()->id,
        ]);
        $invoice->delete();
        Session::flash('message', 'رسید با موفقیت حذف شد.');
        return redirect()->route('admin.invoice.index');
    }

    public function status(Invoice $invoice, Request $request)
    {
        $this->validate($request, [
            'status' => ['required' , 'in:approved,rejected,sent']
        ]);
        if ($invoice->status != 'approved' && $request->status == 'approved'){
            $saleCase= SalesCase::query()->where('invoice_id', $invoice->id)->first();
            if ($saleCase) {
                $saleCaseLastStatus = SalesCaseStatus::query()->where('is_last_step', true)->first();
                $saleCase->update([
                    'status_id' => $saleCaseLastStatus->id
                ]);
            }
        }

        $invoice->status = $request->status;
        $invoice->save();
        return redirect()->back();
    }
}
