@extends('agent.layout.master')
@section('title' , "انتخاب پرونده - افزودن رسید جدید" )
@section('headline', "انتخاب پرونده - افزودن رسید جدید")

@section('subheader')
    @php
        $buttons = [
            [
                'title' => 'بازگشت به لیست رسید   ها' ,
                'icon'   =>  '<i class="fas fa-undo icon-nm"></i>' ,
                'route' => route('agent.invoice.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons??[]' :title="'انتخاب پرونده - افزودن رسید جدید'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">
                         انتخاب پرونده ی فروش
                         {{$customer->fullname}}
                    </h3>
                </div>
                <div class="card-link">
                    <a href="{{route('agent.invoice.create.without-sales-case', ['customer' => $customer->id])}}" class="btn btn-primary">
                        بدون پرونده
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">محصولات</th>
                            <th scope="col">کد ایجاد</th>
                            <th scope="col">وضعیت</th>
                            <th scope="col">فروشنده</th>
                            <th scope="col">انتخاب</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customer->salesCases as $key => $salesCase)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>
                                    @foreach($salesCase->products as $product)
                                        {{$product->title}}
                                        @if($salesCase->products->count() > 1)
                                            &nbsp;|&nbsp;
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$salesCase->tag?->title}}</td>
                                <td>{{$salesCase->status->name}}</td>
                                <td>{{$salesCase->agent->fullname ?? "بدون فروشنده"}}</td>
                                <td>
                                    @if($salesCase->status->is_last_step ||
                                        ( ! is_null($salesCase->agent) && $salesCase->agent->id != auth()->id() ) ||
                                        $salesCase->invoice_id != null
                                    )
                                        <a class="btn btn-secondary disabled">
                                            انتخاب
                                        </a>
                                    @else
                                        <a  href="{{route('agent.invoice.create.with-sales-case', ['salesCase' => $salesCase->id])}}"
                                            class="btn btn-success">
                                            انتخاب
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection


