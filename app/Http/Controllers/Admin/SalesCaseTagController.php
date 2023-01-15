<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCaseTag;
use Illuminate\Http\Request;

class SalesCaseTagController extends Controller
{
    public function index(){
        $tags= SalesCaseTag::query()->orderBy('sort', 'ASC')->get();
        return view('admin.setting.sales_case_tag.index', ['tags' => $tags]);
    }

    public function sort(Request $request)
    {
        $tags= SalesCaseTag::all();

        foreach ($tags as $tag) {
            foreach ($request->order as $order) {
                if ($order['id'] == $tag->id) {
                    $tag->update(['sort' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }
}
