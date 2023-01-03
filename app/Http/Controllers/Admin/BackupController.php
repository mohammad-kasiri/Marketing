<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersBackup;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    public function customersByProductIndex()
    {
        $products= Product::query()->get();
        return view('admin.backups.customer_by_product.index')
            ->with(['products' => $products]);
    }

    public function customersByProductPost(Request $request)
    {
       $product= Product::query()->findOrFail($request->product_id);
       $lastStatus= SalesCaseStatus::query()->where('is_last_step' , '=', 1)->firstOrFail();
       $customers= Customer::query()->whereHas('salesCases', function ($q) use ($lastStatus, $product) {
           return $q->where('status_id' , '=' , $lastStatus->id)->whereHas('products', function ($query) use ($product){
               return $query->where('id', '=', $product->id);
           });
       })->get();

        return Excel::download(new UsersBackup($customers), Carbon::now().'_'.$product->title.'_users.xlsx');
    }
}
