@extends('agent.layout.master')
@section('title' , " ویرایش فاکتور " )
@section('headline', "ویرایش فاکتور")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست فاکتور ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.invoice.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'لیست فاکتور ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        ویرایش فاکتور
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('agent.invoice.update' , $invoice->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="مبلغ" name="price" type="number" value="{{$invoice->price}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="شماره ی حساب" name="account_number" value="{{$invoice->account_number}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات" name="description" value="{{$invoice->description}}"/>
                        </div>
                    </div>

                    <h4 class="card-label mt-10">
                        انتخاب محصولات
                    </h4>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-3 my-5">
                                        <x-dashboard.form.checkbox
                                            name="products[{{$product->id}}]"
                                            value="{{ $product->id }}"
                                            checked="{{ $invoice->products->contains($product->id) ? '1' : 0}}"
                                        >
                                            {{ $product->title }}
                                        </x-dashboard.form.checkbox>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary float-right" type="submit"> ویرایش فاکتور</button>
                </form>
            </div>
        </div>
    </div>
@endsection


