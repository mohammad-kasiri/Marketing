@extends('admin.layout.master')
@section('title' , " لیست  پورسانت ها ")
@section('headline', "لیست  پورسانت ها")

@section('subheader')
    @php
        $buttons = [
            ['title' => 'افزودن پورسانت جدید' , 'icon' => '<i class="fas fa-plus icon-nm"></i>' , 'route' => route('admin.transaction.create') ],
        ];
    @endphp
    <x-dashboard.subheader :links='$buttons ?? []' :title="'لیست  پورسانت   ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">
                                    لیست  پورسانت   ها
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
                                        <th class="text-center">مبلغ خالص</th>
                                        <th class="text-center">درصد بازاریاب</th>
                                        <th class="text-center">از تاریخ</th>
                                        <th class="text-center">تا تاریخ</th>
                                        <th class="text-center">شماره پیگیری</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">توضیحات</th>
                                        <th class="text-center">ویرایش</th>
                                        <th class="text-center">کنترل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $key => $transaction)
                                        <tr>
                                            <td class="text-center align-middle"> {{\App\Functions\PaginationCounter::item($transactions , $key)}} </td>
                                            <td class="text-enter align-middle text-nowrap"> {{ $transaction->agent->full_name }} </td>
                                            <td class="text-center align-middle text-nowrap"> {{ $transaction->total()}} تومان  </td>
                                            <td class="text-center align-middle text-nowrap"> {{ $transaction->percentage()}}  </td>
                                            <td class="text-center align-middle text-nowrap"> {{ $transaction->from_date()}}   </td>
                                            <td class="text-center align-middle text-nowrap"> {{ $transaction->to_date()}}     </td>
                                            <td class="text-center align-middle text-nowrap"> {{ $transaction->tracing_number }}     </td>
                                            <td class="text-center align-middle text-nowrap
                                                @if($transaction->status == 'created')
                                                    text-warning
                                                @elseif($transaction->status == 'paid')
                                                    text-success
                                              @endif
                                            "> {{ $transaction->status =='created' ? 'ایجاد شده' : 'پرداخت شده' }}     </td>
                                            <td class="text-center align-middle text-nowrap">
                                                <button class="btn btn-outline-danger"
                                                        data-container="body"
                                                        data-delay="500"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="{{$transaction->description}}">توضیحات</button>
                                            </td>
                                            <td class="text-center align-middle text-nowrap">
                                                <a href="{{route('admin.transaction.edit' , ['transaction' => $transaction->id])}}"
                                                   class="btn btn-icon btn-circle btn-sm btn-outline-info"
                                                   data-container="body"
                                                   data-delay="500"
                                                   data-toggle="popover"
                                                   data-placement="top"
                                                   data-content="مشاهده">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                            </td>
                                            <td class="text-center align-middle text-nowrap">
                                                <form action="{{route('admin.transaction.update.status' , ['transaction' => $transaction->id])}}" id="update{{$transaction->id}}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="btn btn-icon btn-circle btn-sm btn-outline-success"
                                                        data-container="body"
                                                        data-delay="500"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="پرداخت شده"
                                                        type="submit"
                                                        form="update{{$transaction->id}}"
                                                        name="status"
                                                        value="paid">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{route('admin.transaction.update.status' , ['transaction' => $transaction->id])}}" id="update{{$transaction->id}}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="btn btn-icon btn-circle btn-sm btn-outline-warning"
                                                        data-container="body"
                                                        data-delay="500"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="ایجاد شده"
                                                        type="submit"
                                                        form="update{{$transaction->id}}"
                                                        name="status"
                                                        value="created">
                                                        <i class="fas fa-exclamation"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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


