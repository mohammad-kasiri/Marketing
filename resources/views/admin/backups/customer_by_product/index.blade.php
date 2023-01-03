@extends('admin.layout.master')
@section('title' , "پشتیبان گیری از مشتری ها بر اساس محصول" )
@section('headline', "پشتیبان گیری از مشتری ها بر اساس محصول")

@section('subheader')
    <x-dashboard.subheader :links='$buttons??[]' :title="'پشتیبان گیری از مشتری ها بر اساس محصول'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        پشتیبان گیری از مشتری ها بر اساس محصول
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.backup.customers-by-product.post')}}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="product_id"  label="محصول">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}"> {{$product->title}} </option>
                                @endforeach
                            </x-dashboard.form.select.row>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit"> دانلود </button>
                </form>
            </div>
        </div>
    </div>
@endsection

