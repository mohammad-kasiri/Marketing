@extends('admin.layout.master')
@section('title' , "ویرایش رسید   " .$agent->full_name)
@section('headline', "ویرایش رسید   " .$agent->full_name)

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست رسید   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('admin.agent.invoice.index', ['agent' => $agent->id]) ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'لیست رسید   ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                        ویرایش و مشاهده ی رسید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('admin.agent.invoice.update' , ['agent' => $agent->id, 'invoice' => $invoice->id])}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="مبلغ (تومان)" name="price" type="text" value="{{$invoice->price}}" separate="1" />
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="شماره ی حساب" name="account_number" value="{{$invoice->account_number}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات" name="description" value="{{$invoice->description}}"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.select.row name="status"  label="وضعیت">
                                <option value="sent"     {{$invoice->status == 'sent' ? 'selected' : ''}}>ارسال شده</option>
                                <option value="approved" {{$invoice->status == 'approved' ? 'selected' : ''}}>تایید شده</option>
                                <option value="rejected" {{$invoice->status == 'rejected' ? 'selected' : ''}}>رد شده</option>
                            </x-dashboard.form.select.row>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="تاریخ پرداخت"  name="paid_at_date" datepicker="true" value="{{$invoice->jalaliPaidDate()}}" />
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="ساعت پرداخت"  name="paid_at_time" type="time"  value="{{$invoice->jalaliPaidTime()}}"/>
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

                    <button class="btn btn-primary float-right" type="submit"> ویرایش رسید  </button>
                </form>
            </div>
        </div>
    </div>
@endsection


