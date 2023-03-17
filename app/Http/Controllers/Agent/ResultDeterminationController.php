<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResultDeterminationController extends Controller
{
    public function index()
    {
        $beforeLastStepStatus= SalesCaseStatus::query()->where('is_before_last_step', true)->first();
        $firstStepStatus= SalesCaseStatus::query()->where('is_first_step', true)->first();
        $lastStepStatus= SalesCaseStatus::query()->where('is_last_step', true)->first();

        $awaitingForResultDeterminationSalesCases=SalesCase::query()
            ->where('status_id', $beforeLastStepStatus->id)
            ->where('agent_id', auth()->id())
            ->whereNull('invoice_id')
            ->with('agent')
            ->with('tag')
            ->with('status')
            ->with('products')
            ->get();

        $stagnantSalesCases=SalesCase::query()
            ->where('status_id', '!=', $firstStepStatus->id)
            ->where('status_id', '!=', $beforeLastStepStatus->id)
            ->where('status_id', '!=', $lastStepStatus->id)
            ->whereNull('failure_reason_id')
            ->where('agent_id', auth()->id())
            ->whereDate('updated_at', '<=' , Carbon::now()->subMonths(2))
            ->with('agent')
            ->with('tag')
            ->with('status')
            ->with('products')
            ->get();

        return view('agent.result_determination_sales_cases.index')->with([
            'awaitingForResultDeterminationSalesCases' => $awaitingForResultDeterminationSalesCases,
            'stagnantSalesCases'                       => $stagnantSalesCases
        ]);
    }

    public function chooseInvoice(SalesCase $salesCase){
        $invoices= Invoice::query()
            ->where('user_id', auth()->id())
            ->whereDoesntHave('salesCase')
            ->with('salesCase')
            ->with('products')
            ->with('user')
            ->get();

        return view('agent.result_determination_sales_cases.choose')->with([
            'invoices' => $invoices,
            'salesCase' => $salesCase,
        ]);
    }

    public function submitInvoice(SalesCase $salesCase, Invoice $invoice)
    {
        $lastStepStatus= SalesCaseStatus::query()->where('is_last_step', true)->first();
        $salesCase->update([
           'status_id'   => $lastStepStatus->id,
            'invoice_id' => $invoice->id
        ]);
        Session::flash('message', 'پرونده فروش با موفقیت به رسید لینک شد.');
        return redirect()->route('agent.result-determination.index');
    }
}
