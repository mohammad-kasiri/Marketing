@extends('agent.layout.master')
@section('title' , " گزارش گیری بازه ای ")
@section('headline', "گزارش گیری بازه ای")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'گزارش گیری بازه ای'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Notice-->
            <div class="card card-custom mb-4">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            فیلتر پیشرفته
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('agent.report.index')}}">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.row-input label="از تاریخ"  name="from_date" datepicker="true" value="{{request()->input('from_date')}}"/>
                            </div>
                            <div class="col-md-8">
                                <x-dashboard.form.row-input label="تا تاریخ"  name="to_date" datepicker="true" value="{{request()->input('to_date')}}"/>
                            </div>
                            <div class="col-md-8">
                                <button class="btn btn-primary float-right"> اعمال فیلتر </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($invoices))
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                                <div class="card-body">
                                    <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5"> از تاریخ {{\Morilog\Jalali\Jalalian::forge(\App\Functions\DateFormatter::format(request()->input('from_date') , '00:00'))->format('%A, %d %B %Y') }} </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                                <div class="card-body">
                                    <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5"> تا تاریخ {{\Morilog\Jalali\Jalalian::forge(\App\Functions\DateFormatter::format(request()->input('to_date') , '00:00'))->format('%A, %d %B %Y') }} </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <a class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-primary svg-icon-3x ml-n1">
                                    <x-dashboard.icons.svg.equalizer/>
                                </span>
                                <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5"> فروش خالص </div>
                                <div class="font-weight-bold text-inverse-light font-size-sm"> {{number_format($total_amount)}} تومان </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-success svg-icon-3x ml-n1">
                                    <x-dashboard.icons.svg.equalizer/>
                                </span>
                                <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5">پورسانت  </div>
                                <div class="font-weight-bold text-inverse-light font-size-sm"> {{number_format( ($total_amount  / 100) * auth()->user()->percentage)}} تومان </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a onclick="copyToClipboard('{{auth()->user()->sheba_number}}')" class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-danger svg-icon-3x ml-n1">
                                    <x-dashboard.icons.svg.equalizer/>
                                </span>
                                <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5"> شماره شبا </div>
                                <div class="font-weight-bold text-inverse-light font-size-sm" > {{auth()->user()->sheba_number}}  </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                لیست رسید  ها
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table ">
                                <thead>
                                <tr class="text-muted">
                                    <th class="text-center">#</th>
                                    <th class="text-center">مبلغ</th>
                                    <th class="text-center">چهار رقم آخر شماره کارت</th>
                                    <th class="text-center">تاریخ واریز</th>
                                    <th class="text-center">توضیحات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $key=>$invoice)
                                    <tr>
                                        <td class="text-center align-middle"> {{$key +1}} </td>
                                        <td class="text-center align-middle text-nowrap"> {{ $invoice->price()}} تومان </td>
                                        <td class="text-center align-middle text-nowrap"> {{ $invoice->account_number}}  </td>
                                        <td class="text-center align-middle text-nowrap"> {{ $invoice->paid_at()}} </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button class="btn btn-outline-danger"
                                                    data-container="body"
                                                    data-delay="500"
                                                    data-toggle="popover"
                                                    data-placement="top"
                                                    data-content="{{$invoice->description}}">توضیحات</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!--end::Container-->
    </div>
    <script>
        function copyToClipboard(number)
        {
            navigator.clipboard.writeText(number);
            Swal.fire(
                'حله !',
                'شماره شبای کاربر کپی شد.',
                'success'
            )
        }
    </script>
@endsection


