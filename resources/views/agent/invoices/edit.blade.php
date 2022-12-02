@extends('agent.layout.master')
@section('title' , " ویرایش رسید   " )
@section('headline', "ویرایش رسید  ")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست رسید   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.invoice.index') ],
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
                        ویرایش رسید
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('agent.invoice.update' , $invoice->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="مبلغ (تومان) " name="price" type="text" value="{{$invoice->price}}" separate="1"/>
                        </div>
                        <div class="col-md-8">
                            <x-dashboard.form.radio.row label="پرداخت شده توسط:">
                                <x-dashboard.form.radio.button name="paid_by" value="card" label="کارت به کارت" checked="{{$invoice->paid_by == 'card'}}"/>
                                <x-dashboard.form.radio.button name="paid_by" value="gateway" label="درگاه پرداخت" checked="{{$invoice->paid_by == 'gateway'}}"/>
                                <x-dashboard.form.radio.button name="paid_by" value="site" label="درگاه سایت"  checked="{{$invoice->paid_by == 'site'}}"/>
                            </x-dashboard.form.radio.row>
                        </div>
                        <div class="col-md-8" id="AccountNumberRow">
                            <x-dashboard.form.row-input label="چهار رقم آخر شماره کارت" type="number" name="account_number"  value="{{$invoice->account_number}}"/>
                        </div>
                        <div class="col-md-8" id="GatewayTrackingCodeRow">
                            <x-dashboard.form.row-input label="شماره تراکنش" name="gateway_tracking_code" value="{{$invoice->gateway_tracking_code}}"/>
                        </div>
                        <div class="col-md-8" id="OrderNumberRow">
                            <x-dashboard.form.row-input label="شماره سفارش" name="order_number" value="{{$invoice->order_number}}"/>
                        </div>

                        <div class="col-md-8">
                            <x-dashboard.form.row-input label="توضیحات" name="description" value="{{$invoice->description}}"/>
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

@section('script')
    <script>
        $('document').ready(function (){
            let paid_by = $('input[name="paid_by"]:checked').val()

            let AccountNumberRow = $('#AccountNumberRow');
            let GatewayTrackingCodeRow = $('#GatewayTrackingCodeRow');
            let OrderNumberRow = $('#OrderNumberRow');

            if (paid_by == 'card'){
                GatewayTrackingCodeRow.hide();
                OrderNumberRow.hide()
            }

            if (paid_by == 'gateway') {
                AccountNumberRow.hide();
                OrderNumberRow.hide();
            }
            if (paid_by == 'site') {
                AccountNumberRow.hide();
                GatewayTrackingCodeRow.hide();
            }


            $("input[name='paid_by']").click(function() {
                let paid_by = $('input[name="paid_by"]:checked').val()

                if (paid_by == 'card'){
                    GatewayTrackingCodeRow.hide();
                    OrderNumberRow.hide()
                    AccountNumberRow.show()
                }

                if (paid_by == 'gateway') {
                    AccountNumberRow.hide();
                    OrderNumberRow.hide();
                    GatewayTrackingCodeRow.show();
                }
                if (paid_by == 'site') {
                    AccountNumberRow.hide();
                    GatewayTrackingCodeRow.hide();
                    OrderNumberRow.show();
                }
            });

        })
    </script>
@endsection

