@extends('agent.layout.master')
@section('title' , "افزودن رسید   جدید" )
@section('headline', "افزودن رسید   جدید")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست رسید   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.invoice.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'افزودن رسید   جدید'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        افزودن رسید   جدید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('agent.invoice.store')}}" method="post"> @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <x-dashboard.form.row-input label="مبلغ (تومان)" name="price" type="text" separate="1"/>
                    </div>
                    <div class="col-md-8">
                        <x-dashboard.form.row-input label="چهار رقم آخر شماره کارت" name="account_number"/>
                    </div>
                    <div class="col-md-8">
                        <x-dashboard.form.row-input label="توضیحات" name="description"/>
                    </div>
                    <div class="col-md-8">
                        <x-dashboard.form.row-input label="تاریخ پرداخت"  name="paid_at_date" datepicker="true"/>
                    </div>
                    <div class="col-md-8">
                        <x-dashboard.form.row-input label="ساعت پرداخت"  name="paid_at_time" type="time"/>
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
                                        checked="{{ old('products.'.$product->id) ? '1' : 0}}"
                                    >
                                        {{ $product->title }}
                                    </x-dashboard.form.checkbox>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary float-right" type="submit"> افزودن رسید  </button>
                </form>
            </div>
        </div>
    </div>
@endsection


