<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCase;
use App\Models\SalesCaseTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DistributeController extends Controller
{
    public function index()
    {
        $unassignedSalesCases= SalesCase::query()->unassigned()->count();
        $agents= User::query()->agents()->active()->get();
        $tags= SalesCaseTag::query()->latest()->take(10)->get();

        return view('admin.distribute.index')
            ->with(['unassignedSalesCases' => $unassignedSalesCases])
            ->with(['tags' => $tags])
            ->with(['agents' => $agents]);

    }

    public function distribute(Request $request)
    {
        $unassignedSalesCases= SalesCase::query()->unassigned()->count();

        if (count($request->agents) * $request->countToAssign >  $unassignedSalesCases)
            return redirect()->back()->withErrors(['countToAssign' => 'به تعداد کافی پرونده برای توزیع به همه ی ایجنت های انتخابی وجود ندارد.']);

        foreach ($request->agents as $agent){
            $agent = User::query()->find($agent);
            $salesCases=SalesCase::query();
            $salesCases= is_null($request->tag)
                ? $salesCases->unassigned()->limit($request->countToAssign)->get()
                : $salesCases->unassigned()->where('tag_id', $request->tag)->limit($request->countToAssign)->get();
            foreach ($salesCases as $salesCase)
                $salesCase->update(['agent_id' => $agent->id]);
        }
        Session::flash('message', 'پرونده ها با موفقیت توزیع شدند.');
        return redirect()->route('admin.distribute.index');
    }
}
