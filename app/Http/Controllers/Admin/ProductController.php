<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->paginate(Product::PAGINATION_LIMIT);
        return view('admin.products.index')->with(['products' => $products]);
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'title' => ['required']
        ]);

        Product::query()->create([
            'title' => $request->title
        ]);

        Session::flash('message', 'محصول جدید با موفقیت اضافه شد.');
        return redirect()->back();
    }


    public function edit(Product $product)
    {
        return view('')->with(['product' => $product]);
    }


    public function update(Request $request, Product $product)
    {
        $this->validate($request , [
            'title' => ['required']
        ]);

        $product->update([
            'title' => $request->title
        ]);

        Session::flash('message', 'محصول جدید با موفقیت ویرایش شد.');
        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Session::flash('message', 'محصول با موفقیت حذف شد.');
        return redirect()->back();
    }
}
