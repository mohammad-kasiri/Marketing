@extends('admin.layout.master')
@section('title' , " لیست کدهای ایجاد ")
@section('headline', " لیست کدهای ایجاد ")

@section('subheader')
    <x-dashboard.subheader :links='[]' :title="'کدهای ایجاد'" />
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Notice-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            لیست کدهای ایجاد
                             |
                            <small class="text-danger ">کدهای ایجاد ابتدای لیست الویت بالاتری دارند</small>
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table ">
                            <thead>
                            <tr class="text-muted">
                                <th class="text-center">#</th>
                                <th class="text-center">کد ایجاد</th>
                                <th class="text-center">عنوان کد</th>
                                <th class="text-center">شناسه</th>
                            </tr>
                            </thead>
                            <tbody  id="tablecontents">
                            @foreach($tags as $tag)
                                <tr  class="row1" data-id="{{ $tag->id }}">
                                    <td class="text-center align-middle"> {{$tag->sort}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$tag->tag}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$tag->title}} </td>
                                    <td class="text-center align-middle text-nowrap"> {{$tag->id}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $("#table").DataTable();

            $( "#tablecontents" ).sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');
                $('tr.row1').each(function(index,element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.tag-case-sales.sort') }}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            location.reload();
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        });
    </script>
@endsection
