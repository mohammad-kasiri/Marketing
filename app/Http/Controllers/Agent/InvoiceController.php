<?php

namespace App\Http\Controllers\Agent;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoice()->latest()->paginate(Invoice::PAGINATION_LIMIT);
        return  view('agent.invoices.index')->with(['invoices' => $invoices]);
    }

    public function create()
    {
        $products= Product::all();
        return view('agent.invoices.create')
                ->with(['products' => $products]);
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'price'                 => ['required'],
            'paid_by'               => ['required' , 'in:card,gateway'],
            'account_number'        => ['nullable','numeric'],
            'gateway_tracking_code' => ['nullable','numeric'],
            'description'           => ['nullable'],
            'products'              => ['required' , 'array'],
            'products.*'            => ['required' , 'numeric'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

        $status = $this->checkStatus();

        $invoice = auth()->user()->invoice()->create(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->attach($request->products);
        }

        Session::flash('message', 'رسید   با موفقیت ایجاد شد.');
        return redirect()->route('agent.invoice.index');
    }

    public function edit(Invoice $invoice)
    {
        if($invoice->status != 'sent' && $invoice->status != 'suspicious' )
            return redirect()->back();

        $products= Product::all();
        return view('agent.invoices.edit')
            ->with(['invoice'  => $invoice])
            ->with(['products' => $products]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->validate($request , [
            'price'                 => ['required'],
            'paid_by'               => ['required' , 'in:card,gateway'],
            'account_number'        => ['nullable','numeric'],
            'gateway_tracking_code' => ['nullable','numeric'],
            'description'           => ['nullable'],
            'products'              => ['required' , 'array'],
            'products.*'            => ['required' , 'numeric'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

        $status = $this->checkStatus($invoice->id);

        $invoice->update(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }
        Session::flash('message', 'رسید   با موفقیت ویرایش شد.');
        return redirect()->route('agent.invoice.index');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', 'رسید   با موفقیت حذف شد.');
        return redirect()->route('agent.invoice.index');
    }


    private function checkStatus($id = null) : array
    {
        $paid_by =  request()->input('paid_by') == 'card' ? 'card' : 'gateway';
        $tracking_metric = request()->input('paid_by') == 'card' ? 'account_number' : 'gateway_tracking_code';


        if (is_null($id)) {

            $suspiciousInvoice = Invoice::query()
                ->whereDay('paid_at' ,DateFormatter::format(request()->input('paid_at_date') ,request()->input('paid_at_time')))   // CHECK PAID_AT
                ->where('price'      , str_replace(',' , '' , request()->input('price')))          // PRICE
                ->where($tracking_metric    , request()->input($tracking_metric))->first();     // TRACKING METRIC

        }else{
            $suspiciousInvoice = Invoice::query()
                ->whereDay('paid_at' ,DateFormatter::format(request()->input('paid_at_date') ,request()->input('paid_at_time')))   // CHECK PAID_AT
                ->where('price'      , str_replace(',' , '' , request()->input('price')))          // PRICE
                ->where($tracking_metric    , request()->input($tracking_metric))
                ->where('id', '!=' , $id)
                ->first();     // TRACKING METRIC
        }



        if (! $suspiciousInvoice)
            return ['status' => 'sent'];

        return
            [
                'status'            => 'suspicious' ,
                'suspicious_with'   => $suspiciousInvoice->id
            ];
    }
}
