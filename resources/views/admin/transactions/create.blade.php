@extends('admin.layout.master')
@section('title' , " افزودن پورسانت جدید ")
@section('headline', "افزودن پورسانت جدید")

@section('subheader')
    @php
        $buttons = [
            ['title' => 'لیست پورسانت ها' , 'icon' => '<i class="fas fa-undo icon-nm"></i>' , 'route' => route('admin.transaction.index') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'افزودن پورسانت جدید'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            @if(\Illuminate\Support\Facades\Session::has('message'))
                <div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
                    <div class="alert-text">{{\Illuminate\Support\Facades\Session::get('message')}}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="نزدیک">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
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
                    <form action="{{route('admin.transaction.create')}}">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <x-dashboard.form.select.row label="کاربر" name="user" searchable="1" >
                                    <option></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" {{request()->input('user') == $user->id ? 'selected' : ''}}>
                                            {{$user->full_name}}
                                        </option>
                                    @endforeach
                                </x-dashboard.form.select.row>
                            </div>
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
                                <div class="font-weight-bold text-inverse-light font-size-sm"> {{number_format( ($total_amount  / 100) * $agent->percentage)}} تومان </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a onclick="copyToClipboard('{{$agent->sheba_number}}')" class="card card-custom bg-light bg-hover-state-light card-stretch card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-danger svg-icon-3x ml-n1">
                                    <x-dashboard.icons.svg.equalizer/>
                                </span>
                                <div class="text-inverse-light font-weight-bolder font-size-h5 mb-2 mt-5"> شماره شبای بازاریاب </div>
                                <div class="font-weight-bold text-inverse-light font-size-sm" > {{$agent->sheba_number}}  </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
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
                                            <th class="text-center">کاربر</th>
                                            <th class="text-center">مبلغ</th>
                                            <th class="text-center">چهار رقم آخر شماره کارت</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">تاریخ واریز</th>
                                            <th class="text-center">توضیحات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoices as $key=>$invoice)
                                            <tr>
                                                <td class="text-center align-middle"> {{$key +1}} </td>
                                                <td class="text-center align-middle text-nowrap"> {{ $invoice->user->full_name }} </td>
                                                <td class="text-center align-middle text-nowrap"> {{ $invoice->price()}} تومان </td>
                                                <td class="text-center align-middle text-nowrap"> {{ $invoice->account_number}}  </td>
                                                <td class="text-center align-middle text-nowrap"> {{ $invoice->status()}} </td>
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
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        ایجاد  پورسانت
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.transaction.store' , ['user' => $agent->id])}}" method="post">@csrf
                                    <x-dashboard.form.row-input label="فروش خالص" name="total" type="text" value="{{$total_amount}}"  separate="1" />
                                    <x-dashboard.form.row-input label="سهم بازاریاب" name="percentage" type="text" value="{{($total_amount  / 100) * $agent->percentage}}" separate="1" />
                                    <x-dashboard.form.row-input label="از تاریخ" name="from_date" type="text" value="{{request()->input('from_date')}}" />
                                    <x-dashboard.form.row-input label="تا تاریخ" name="to_date" type="text" value="{{request()->input('to_date')}}"/>
                                    <x-dashboard.form.row-input label="شماره پیگیری" name="tracing_number" type="text" />
                                    <x-dashboard.form.row-input label="توضیحات" name="description" type="text" />
                                    <button class="btn btn-primary float-right" type="submit">ذخیره  پورسانت  </button>
                                </form>
                            </div>
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


