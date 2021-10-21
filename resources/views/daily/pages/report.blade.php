<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.27
 * Time: AM 8:52
 */
?>
@extends('daily.layout.app')

@section('main_content')
    <style>
        @media (max-width: 640px) {
            .header-right {
                width: 60px;
            }
            .btn_locate_print {
                padding-right: 5px;
            }
        }
    </style>
    <div class="body">
        @include('daily.partials.header_bar')
        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label header-right">
                                <h3 class="kt-portlet__head-title">
                                    {{trans('login.daily_report')}}
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <label class="btn_locate_print" onclick="print()">{{trans('login.daily_report_print')}}</label>
                                <label class="btn_locate_add" onclick="edit_location()"> <i class="la la-edit"></i>{{trans('login.daily_locate_modify')}}</label>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered table-no-footer">
                                        <thead>
                                        <tr>
                                            <th>{{trans('login.locate_address')}}</th>
                                            <th>{{trans('login.locate_name')}}</th>
                                            <th>{{trans('login.order_name')}}</th>
                                            <th>{{trans('login.order_cost')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="width: 25%" class="td_address">{{$spot->address}}</td>
                                            <td style="width: 25%" class="td_name">{{$spot->name}}</td>
                                            <td style="width: 25%" class="td_order_name">{{$spot->contractor}}</td>
                                            <td style="width: 25%" class="td_order_cost">{{number_format($spot->contract_price)}}{{trans('login.won')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- <a onclick="go_report_detail('{{date('Y-m-d')}}')" class="btn btn-warning btn_add" style="cursor: pointer;">
                                        <span class="kt-badge kt-badge--brand" style="color: #1ba453; background: white !important;">+</span> {{trans('login.daily_report_add')}}
                                    </a> --}}
                                    @include('daily.partials.report.create_report_modal')
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_1">
                                        <thead>
                                        <tr>
                                            <th>{{trans('login.date')}}</th>
                                            <th>作成者</th>
                                            <th></th>
                                            {{-- <th>{{trans('login.employee')}}/{{trans('login.cost')}}</th>
                                            <th>{{trans('login.oursider')}}/{{trans('login.cost')}}</th>
                                            <th>{{trans('login.building_tool_cost1')}}</th>
                                            <th>{{trans('login.today_cost')}}</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12" style="text-align: right">
                                    @if(!$finished)
                                    @include('daily.partials.report.finish_spot_modal')
                                    @else
                                    <button type="button" class="btn btn-warning btn_complete" onclick="rollback_complete()">完工前に戻す</button>
                                    @endif
                                    <button type="button" class="btn btn-danger" style="margin-top: 20px" onclick="delete_location()">{{ __('login.delete') }}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @include('daily.partials.report.change_spot_modal')

            <form class="kt-form hidden" action="{{ url('/report_detail') }}" method="post">
                @csrf
                <input class="form-control location_id" type="number" name="location_id">
                <input class="form-control" type="text" id="location_date" name="location_date">
                <button type="submit" id="btn_location_detail"></button>
            </form>

            <input type="number" class="hidden" id="manager" value="{{Auth::user()->role}}">
            <input type="number" class="hidden" id="spot_id" value="{{$id}}">
            <input type="number" class="hidden" id="role">
            <input type="text" class="hidden" id="role_name">
            <input type="number" class="hidden" id="status" value="{{$spot->status}}">
        </div>
    </div>
    <script>
        var tbl1;
        var check_role_timer;
        var delete_label = "{{trans('login.delete')}}";
        $(function(){
            tbl1 = $('#kt_table_1').DataTable({
                "bSort": false,
                "pageLength": 10,
                "bFilter": false,
                "bInfo": false,
                "bLengthChange": false,
                "processing": false,
                "serverSide": true,

                "ajax": {
                    "url": "{{ url('/get_report_list') }}",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "type": "POST",
                    "data": function(data) {
                        data.location_id = $('#spot_id').val();
                    },
                    "dataSrc": function (res) {
                        return res.data;
                    }
                },
                createdRow: function(row, data, index) {
                    $('td', row).eq(0).html('<a class="go_location" onclick="go_report_detail(' + data[2] + ')">' + data[0] + '</a>');
                    $('td', row).eq(2).html('<button type="button" class="btn btn-danger" onclick="delete_report(' + data[2] + ')">' + delete_label + '</button>');
                },
            });
            $('.form_date').datepicker({
                format: 'yyyy/mm/dd',
                language: 'jp',
                orientation: 'bottom',
                todayHighlight: true,
            });
        });

        $(document).ready(function () {
            tbl1.init();
            check_role();
            check_role_timer = setInterval(check_role, 15 * 60 * 1000);
        });

        async function check_role() {
            await $.ajax({
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/get_location_status') }}",
                data: {
                    location_id: "{{$id}}",
                },
                success: function (v) {
                    $('#role').val(v[0]);
                    $('#role_name').val(v[1]);
                },
                error: function(data, status, err) {
                }
            });
        }

        function go_report_detail(date) {
            var manager = $('#manager').val();
            var status = $('#status').val();
            if (manager == 0 && status == 1) {
                showNotification("warning", "{{trans('login.completed_location')}}", "warning");
                return;
            }

            $('.location_id').val($('#spot_id').val());
            $('#location_date').val(date);
            $('#btn_location_detail').trigger('click');
        }

        function create_report() {
            check_role();
            var role = $('#role').val();
            var roleName = $('#role_name').val();
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            var report_date = $('#kt_modal_report_add .report_date').val();
            if (report_date == '') {
                $('#kt_modal_report_add .report_date').focus();
            }
            var report_user = $('#kt_modal_report_add .author').val();
            $.ajax({
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/create_report') }}",
                data: {
                    id: "{{$id}}",
                    date: report_date,
                    author: report_user,
                },
                success: function (v) {
                    $('#kt_modal_report_add .btn-secondary').trigger('click');
                    tbl1.draw();
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_report(report_date) {
            check_role();
            var role = $('#role').val();
            var roleName = $('#role_name').val();
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            showConfirmDlg("{{trans('login.query_report_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_report') }}",
                    data: {
                        id: "{{$id}}",
                        date: report_date,
                    },
                    success: function (v) {
                        tbl1.draw();
                    },
                    error: function(data, status, err) {
                    }
                });
            });
        }

        function edit_location() {
            var manager = $('#manager').val();
            var status = $('#status').val();
            if (manager == 0 && status == 1) {
                showNotification("warning", "{{trans('login.completed_location')}}", "warning");
                return;
            }
            $.ajax({
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/get_location_status') }}",
                data: {
                    location_id: "{{$id}}",
                },
                success: function (v) {
                    $('#role').val(v[0]);
                    $('#role_name').val(v[1]);
                    if (v[0] == 0) {
                        showNotification("警告", v[1] + "{{trans('login.editing')}}", "warning");
                        return;
                    }
                    $('#btn_locate_add').trigger('click');
                },
                error: function(data, status, err) {
                }
            });
        }

        function complete_location() {
            var date = $('#kt_modal_report_finish .finish_date').val();
            if (date == '') {
                $('#kt_modal_report_finish .finish_date').focus();
            }
            $.ajax({
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                type: "POST",
                url: "{{ url('/get_location_status') }}",
                data: {
                    location_id: "{{$id}}",
                },
                success: function (v) {
                    $('#role').val(v[0]);
                    $('#role_name').val(v[1]);
                },
                error: function(data, status, err) {
                }
            });
            var role = $('#role').val();
            var roleName = $('#role_name').val();
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/complete_location') }}",
                data: {
                    id: $('#spot_id').val(),
                    date: date,
                },
                success: function (v) {
                    location.reload();
                },
                error: function(data, status, err) {
                }
            });
        }

        function rollback_complete() {
            check_role();
            var role = $('#role').val();
            var roleName = $('#role_name').val();
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/rollback_complete') }}",
                data: {
                    id: $('#spot_id').val()
                },
                success: function (v) {
                    location.reload();
                },
                error: function(data, status, err) {
                }
            });
        }

        async function delete_location() {
            await check_role();
            var role = $('#role').val();
            var roleName = $('#role_name').val();
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            showConfirmDlg("{{trans('login.query_locate_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_location') }}",
                    data: {
                        id: $('#spot_id').val()
                    },
                    success: function (v) {
                        location.href="{{ url('/') }}";
                    },
                    error: function(data, status, err) {
                    }
                });
            });
        }

        function change_location() {
            var location_name = $('#locate_name').val();
            var order_name = $('#order_name').val();
            var order_cost = $('#order_cost').val().replace(/,/g, '');
            var locate_address = $('#locate_address').val();
            var locate_startdate = $('#order_startdate').val();
            if (locate_address == '') {
                $('#locate_address').focus();
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ url('/change_location') }}",
                data: {
                    id: $('#spot_id').val(),
                    location_name: location_name,
                    order_name: order_name,
                    order_cost: order_cost,
                    locate_address: locate_address,
                    locate_startdate: locate_startdate,
                },
                success: function (v) {
                    $('.td_address').html(locate_address);
                    $('.td_name').html(location_name);
                    $('.td_order_name').html(order_name);
                    $('.td_order_cost').html(v + "{{trans('login.won')}}");
                    $('.btn-secondary').trigger('click');
                },
                error: function(data, status, err) {
                }
            });
        }

        function print() {
            location.href= "{{ url('/report_print?location_id=') }}" + $('#spot_id').val();
            setTimeout(function () {
                check_role();
            }, 500);
        }

        $(document).ready(function() {
            $(window).bind('beforeunload', function() {
                var role = $('#role').val();
                if (role == 1) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "POST",
                        url: "{{ url('/change_location_editor') }}",
                        data: {
                            id: $('#spot_id').val(),
                        },
                        success: function (v) {
                        },
                        error: function(data, status, err) {
                        }
                    });
                }
            });
        });
    </script>
@endsection
