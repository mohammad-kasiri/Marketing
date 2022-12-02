@extends('agent.layout.master')
@section('title' , "لیست کارها" )
@section('headline', "لیست کارها")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'لیست کار ها'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Notice-->
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
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست کار ها
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">توضیحات</th>
                                <th class="text-center">تاریخ یادآوری</th>
                                <th class="text-center">تاریخ انجام</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $key=>$task)
                                <tr>
                                    <td class="text-center align-middle"> {{$key+1}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$task->title}}  </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button class="btn btn-outline-danger"
                                                data-container="body"
                                                data-delay="500"
                                                data-toggle="popover"
                                                data-placement="top"
                                                data-content="{{$task->note}}">توضیحات</button>
                                    </td>
                                    <td class="text-center align-middle text-nowrap"> {{$task->remined_at()}}  </td>

                                    <td class="text-center align-middle text-nowrap">
                                        @if(is_null($task->done_at))
                                            <span class="text-warning">
                                                انجام نشده
                                            </span>
                                        @else
                                            <span class="text-success">
                                               {{$task->done_at()}}
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center align-middle text-nowrap">
                                            <a href="{{route('agent.task.mark-as-done' , ['task' => $task->id])}}"   class="btn btn-icon btn-circle btn-sm btn-outline-success">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="{{route('agent.sales-case.show' , ['salesCase' => $task->sales_case_id])}}"   class="btn btn-icon btn-circle btn-sm btn-outline-info">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                            <a href="{{route('agent.task.edit' , ['task' => $task->id])}}"   class="btn btn-icon btn-circle btn-sm btn-outline-primary">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{route('agent.task.destroy' , ['task' => $task->id])}}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="btn btn-icon btn-circle btn-sm btn-outline-danger"
                                                    data-container="body"
                                                    data-delay="500"
                                                    data-toggle="popover"
                                                    data-placement="top"
                                                    data-content="حذف">
                                                    <i class="far fa-trash-alt"></i>
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
        <!--end::Container-->

    </div>
@endsection


