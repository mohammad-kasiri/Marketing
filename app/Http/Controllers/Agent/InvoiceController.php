<?php

namespace App\Http\Controllers\Agent;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Rules\AvoidRepetitive;
use App\Rules\PhoneNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoice()->latest()->paginate(Invoice::PAGINATION_LIMIT);
        return  view('agent.invoices.index')->with(['invoices' => $invoices]);
    }

    public function createInvoice()
    {
        $products= Product::all();
        return view('agent.invoices.create.1_choose_customer')
            ->with(['products' => $products]);
    }
    public function checkCustomerExists  ()
    {
        if (! request()->has('mobile')){
            return view('agent.invoices.create.1_choose_customer');
        }

        $mobile = request()->input('mobile');
        $customer= Customer::query()->where('mobile',$mobile)->first();

        return is_null($customer)
            ? redirect()->route('agent.invoice.create.without_customer', ['mobile' => $mobile])
            : redirect()->route('agent.invoice.create.customer_exist', ['customer_id' => $customer->id]);


    }
    public function customerExists()
    {
        $customer_id= request()->input('customer_id');
        $customer= Customer::query()
            ->with('salesCases.tag')
            ->with('salesCases.products')
            ->with('salesCases.status')
            ->with('salesCases.agent')
            ->findOrFail($customer_id);
        return view('agent.invoices.create.02_choose_sales_case')->with(['customer' => $customer]);
    }

    public function createWithoutCustomer(Request $request)
    {
        $request->validate(['mobile' => [ 'required',  new PhoneNumber(), 'bail' ]]);
        $products= Product::all();
        return view('agent.invoices.create.03_create_invoice_without_customer')
            ->with(['mobile' => $request->mobile])
            ->with(['products' => $products]);
    }
    public function storeWithOutCustomer(Request $request)
    {
        $this->validate($request , [
            'customer_fullname'     => ['required', 'max:40'],
            'customer_mobile'       => ['required',  new PhoneNumber(), 'bail' ],
            'customer_email'        => ['required', 'email'],

            'price'                 => ['required'],
            'paid_by'               => ['required' , 'in:card,gateway,site'],

            'account_number'        => ['required_if:paid_by,==,card','nullable' ,  'numeric' ],
            'gateway_tracking_code' => ['required_if:paid_by,==,gateway','nullable' , 'numeric'],
            'order_number'          => ['required_if:paid_by,==,site'],

            'description'           => ['nullable'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'products'              => ['required' , 'array'],
            'paid_at_time'          => ['required'],
        ]);

        if (Customer::query()->where('mobile',$request->mobile)->exists())
            return redirect()->back()->withErrors([ 'customer_mobile' => "مشتری با این شماره موبایل از قبل وجود دارد"]);

        if (count($request->products) != 1 )
            return redirect()->back()->withErrors([ 'products' => "تنها یک کالا میتوانید انتخاب کنید"]);

        $customer= Customer::query()->create([
            'fullname'  => $request->customer_fullname,
            'mobile'    => $request->customer_mobile,
            'email'     => $request->customer_email
        ]);

        $salesCase = SalesCase::query()->create([
           'agent_id'  => auth()->id(),
           'customer_id' => $customer->id,
           'status_id' => SalesCaseStatus::query()->where('is_before_last_step', '=', true)->first()->id,
        ]);
        $salesCase->products()->attach($request->products);

        $status = $this->checkStatus();

        $invoice = auth()->user()->invoice()->create(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'order_number'          => $request->order_number,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        $invoice->products()->attach($salesCase->products->pluck('id'));

        //لینک رسید به پرونده
        $salesCase->update(['invoice_id'  => $invoice->id]);

        Session::flash('message','رسید با موفقیت ایجاد شد.');
        return redirect()->route('agent.invoice.index');
    }

    public function createWithoutSalesCase()
    {
        $customer= Customer::query()->findOrFail(request()->input('customer'));
        $products= Product::all();
        return view('agent.invoices.create.03_create_invoice_without_salescase')
            ->with([
                'products' => $products,
                'customer' => $customer
            ]);
    }
    public function storeWithoutSalesCase(Request $request)
    {
        $this->validate($request , [
            'customer'              => ['required'],

            'price'                 => ['required'],
            'paid_by'               => ['required' , 'in:card,gateway,site'],

            'account_number'        => ['required_if:paid_by,==,card','nullable' ,  'numeric' ],
            'gateway_tracking_code' => ['required_if:paid_by,==,gateway','nullable' , 'numeric'],
            'order_number'          => ['required_if:paid_by,==,site'],

            'products'              => ['required' , 'array'],
            'description'           => ['nullable'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

        if (count($request->products) != 1 )
            return redirect()->back()->withErrors([ 'products' => "تنها یک کالا میتوانید انتخاب کنید"]);

        $customer= Customer::query()->where('id', $request->customer)->with('salesCases.products')->firstOrFail();

        foreach ($customer->salesCases as $salesCase){
            foreach ($salesCase->products as $product){
                foreach ($request->products as $selectedProductID)
                {
                    if($selectedProductID == $product->id)
                    {
                        return redirect()->back()->withErrors([ 'products' => "با محصول انتخاب شده یک پرونده وجود دارد"]);
                    }
                }
            }
        }

        $salesCase = SalesCase::query()->create([
            'agent_id'  => auth()->id(),
            'customer_id' => $customer->id,
            'status_id' => SalesCaseStatus::query()->where('is_before_last_step', '=', true)->first()->id,
        ]);

        $salesCase->products()->attach($request->products);

        $status = $this->checkStatus();

        $invoice = auth()->user()->invoice()->create(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'order_number'          => $request->order_number,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        $invoice->products()->attach($salesCase->products->pluck('id'));

        //لینک رسید به پرونده
        $salesCase->update(['invoice_id'  => $invoice->id, 'agent_id' => auth()->id()]);

        Session::flash('message','رسید با موفقیت ایجاد شد.');
        return redirect()->route('agent.invoice.index');
    }

    public function createWithSalesCase(SalesCase $salesCase)
    {
        if($salesCase->status->is_last_step || ( ! is_null($salesCase->agent) && $salesCase->agent->id != auth()->id() ))
        {abort(403);}

        $products= Product::all();
        return view('agent.invoices.create.03_create_invoice_with_salescase')
            ->with([
                'products' => $products,
                'salesCase'=> $salesCase
            ]);
    }
    public function storeWithSalesCase(Request $request)
    {
        $this->validate($request , [
            'price'                 => ['required'],
            'paid_by'               => ['required' , 'in:card,gateway,site'],

            'salesCase'             => ['required'],

            'account_number'        => ['required_if:paid_by,==,card','nullable' ,  'numeric' ],
            'gateway_tracking_code' => ['required_if:paid_by,==,gateway','nullable' , 'numeric'],
            'order_number'          => ['required_if:paid_by,==,site'],

            'description'           => ['nullable'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

//        if (count($request->products) != 1 )
//            return redirect()->back()->withErrors([ 'products' => "تنها یک کالا میتوانید انتخاب کنید"]);

        $salesCase= SalesCase::query()->where('id', $request->salesCase)->firstOrFail();

        $status = $this->checkStatus();

        $invoice = auth()->user()->invoice()->create(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'order_number'          => $request->order_number,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        $invoice->products()->attach($salesCase->products->pluck('id'));

        //لینک رسید به پرونده
        $salesCase->update([
            'invoice_id'  => $invoice->id,
            'agent_id'    => auth()->id(),
            'status_id'   => SalesCaseStatus::query()->where('is_before_last_step', '=', true)->first()->id
        ]);

        Session::flash('message','رسید با موفقیت ایجاد شد.');
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
            'paid_by'               => ['required' , 'in:card,gateway,site'],

            'account_number'        => ['required_if:paid_by,==,card'   ,'bail'],
            'gateway_tracking_code' => ['required_if:paid_by,==,gateway','bail'],
            'order_number'          => ['required_if:paid_by,==,site'   ,'bail'],

            'description'           => ['nullable'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

        $status = $this->checkStatus($invoice->id);

        $invoice->update(array_merge([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'order_number'          => $request->order_number,
            'description'           => $request->description,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ] , $status));

        Session::flash('message', 'رسید   با موفقیت ویرایش شد.');
        return redirect()->route('agent.invoice.index');
    }


    public function destroy(Invoice $invoice)
    {
        SalesCase::query()->where('invoice_id', $invoice->id)->update([
            'invoice_id' => null,
            'status_id'  => SalesCaseStatus::query()->where('is_first_step',1)->first()->id,
        ]);
        $invoice->delete();
        Session::flash('message', 'رسید با موفقیت حذف شد.');
        return redirect()->route('agent.invoice.index');
    }


    private function checkStatus($id = null) : array
    {
        $metric_map = [
            'card'     => 'account_number',
            'gateway'  => 'gateway_tracking_code',
            'site'     => 'order_number'
        ];

        $tracking_metric = $metric_map[request()->input('paid_by')];


        if (is_null($id)) {

            $suspiciousInvoice = Invoice::query()
                ->whereDay('paid_at' ,DateFormatter::format(request()->input('paid_at_date') ,request()->input('paid_at_time')))   // CHECK PAID_AT
                ->where('price'      , str_replace(',' , '' , request()->input('price')))          // PRICE
                ->where('paid_by'    , request()->input('paid_by'))
                ->where($tracking_metric    , request()->input($tracking_metric))->first();     // TRACKING METRIC
        }else{
            $suspiciousInvoice = Invoice::query()
                ->whereDay('paid_at' ,DateFormatter::format(request()->input('paid_at_date') ,request()->input('paid_at_time')))   // CHECK PAID_AT
                ->where('price'      , str_replace(',' , '' , request()->input('price')))          // PRICE
                ->where('paid_by'    , request()->input('paid_by'))
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
