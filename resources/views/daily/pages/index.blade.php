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
    <div class="body">
        @include('daily.partials.header_bar')
        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    {{trans('login.daily_locate_view')}}
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <label class="btn_locate_add" data-toggle="modal" data-target="#kt_modal_1"> <span class="kt-badge kt-badge--brand">+</span>{{trans('login.daily_locate_add')}}</label>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="col-lg-12 kt-portlet__body_search">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12">{{trans('login.locate_name')}}</label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" id="find_locate_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">{{trans('login.locate_address')}}</label>
                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" id="find_locate_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12">{{trans('login.start_time')}}</label>
                                            <div class="col-lg-4 col-md-9 col-sm-12">
                                                <input type="text" class="form-control form_date" id="date_start1" readonly>
                                            </div>
                                            <div class="col-lg-1 col-md-9 col-sm-12" style="text-align: center; margin-top: 8px;">
                                                ~
                                            </div>
                                            <div class="col-lg-4 col-md-9 col-sm-12">
                                                <input type="text" class="form-control form_date" id="date_end1" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12">{{trans('login.end_time')}}</label>
                                            <div class="col-lg-4 col-md-9 col-sm-12">
                                                <input type="text" class="form-control form_date" id="date_start2" readonly>
                                            </div>
                                            <div class="col-lg-1 col-md-9 col-sm-12" style="text-align: center; margin-top: 8px;">
                                                ~
                                            </div>
                                            <div class="col-lg-4 col-md-9 col-sm-12">
                                                <input type="text" class="form-control form_date" id="date_end2" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-7 ml-lg-auto">
                                        <button type="reset" class="btn btn-brand" onclick="findLocation()">{{trans('login.find')}}</button>
                                        <button type="reset" class="btn btn-secondary" onclick="reset()">{{trans('login.close')}}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered" id="kt_table_1">
                                        <thead>
                                        <tr>
                                            <th>使用中</th>
                                            <th>{{trans('login.locate_address')}}</th>
                                            <th>{{trans('login.locate_name')}}</th>
                                            <th>{{trans('login.cumulative_count')}}</th>
                                            <th>{{trans('login.labor_cost_all')}}</th>
                                            <th>{{trans('login.cumulative_cost')}}</th>
                                            <th>{{trans('login.gain')}}</th>
                                            <th>{{trans('login.gain_rate')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head portlet__head_not">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    未入力現場一覧
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body portlet__body_not">
                            <table class="table table-striped- table-bordered" id="kt_table_2">
                                <thead>
                                <tr>
                                    <th>{{trans('login.locate_address')}}</th>
                                    <th>{{trans('login.locate_name')}}</th>
                                    <th>{{trans('login.date')}}</th>
                                    <th>{{trans('login.order_name')}}</th>
                                    <th>作成者</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{trans('login.locate_regist')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped- table-bordered">
                                <tbody>
                                    <form autocomplete="off">
                                        <tr>
                                            <td class="td_head" style="width: 30%">{{trans('login.locate_address')}}</td>
                                            <td>
                                                <input type="text" class="form-control" id="locate_address" style="width: 230px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td_head" style="width: 30%">{{trans('login.locate_name')}}</td>
                                            <td>
                                                <input type="text" class="form-control" id="locate_name" style="width: 230px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td_head" style="width: 30%">{{trans('login.order')}}</td>
                                            <td>
                                                <input type="text" class="form-control" id="order_name" style="width: 230px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td_head" style="width: 30%">{{trans('login.order_cost_short')}}</td>
                                            <td style="display: flex; border: none; ">
                                                <input type="text" class="form-control price" id="order_cost" style="width: 230px; padding: 0px 13px; display: none">
                                                <label class="number-label"></label>
                                                <span style="margin: 3px;">{{trans('login.won')}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td_head" style="width: 30%">着工日</td>
                                            <td style="display: flex; border: none;border-top: 1px solid #C0C0C0">
                                                <input type="text" class="form-control form_date" id="order_startdate" style="width: 230px; padding: 0px 13px;" readonly>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                            <button type="button" class="btn btn-primary" onclick="save_location()">{{trans('login.add')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="kt-form hidden" action="{{ url('/report') }}" method="post">
                @csrf
                <input class="form-control location_id" type="number" name="location_id">
                <button type="submit" id="btn_location"></button>
            </form>

            <form class="kt-form hidden" action="{{ url('/report_detail') }}" method="post">
                @csrf
                <input class="form-control location_id" type="number" name="location_id">
                <input class="form-control" type="text" id="location_date" name="location_date">
                <button type="submit" id="btn_location_detail"></button>
            </form>
        </div>
    </div>
    <script>
        var tbl2 = function() {
            var initTable2 = function() {
                $('#kt_table_2').DataTable({
                    "bSort": false,
                    "pageLength": 5,
                    "bFilter": false,
                    "bInfo": false,
                    "bLengthChange": false,
                    "processing": false,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('/get_miss_list') }}",
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "type": "POST",
                        "data": function(data) {
                            data.name = $('#find_locate_name').val();
                            data.address = $('#find_locate_address').val();
                            data.date_start1 = $('#date_start1').val();
                            data.date_end1 = $('#date_end1').val();
                            data.date_start2 = $('#date_start2').val();
                            data.date_end2 = $('#date_end2').val();
                        },
                        "dataSrc": function (res) {
                            return res.data;
                        }
                    },
                    createdRow: function(row, data, index) {
                        $('td', row).eq(0).html(`<a class="go_location" onclick="go_report_detail('${data[5]}','${data[6]}')">` + data[0] + '</a>');
                    },
                });
            };
            return {
                init: function() {
                    initTable2();
                },
            };
        }();
        var tbl1;
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
                    "url": "{{ url('/get_spot_list') }}",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "type": "POST",
                    "data": function(data) {
                        data.name = $('#find_locate_name').val();
                        data.address = $('#find_locate_address').val();
                        data.date_start1 = $('#date_start1').val();
                        data.date_end1 = $('#date_end1').val();
                        data.date_start2 = $('#date_start2').val();
                        data.date_end2 = $('#date_end2').val();
                    },
                    "dataSrc": function (res) {
                        return res.data;
                    }
                },
                createdRow: function(row, data, index) {
                    $('td', row).eq(1).html('<a class="go_location" onclick="go_location(' + data[8] + ')">' + data[1] + '</a>');
                },
            });
        });

        $(document).ready(function () {
            tbl2.init();
            tbl1.init();

            $('.form_date').datepicker({
                format: 'yyyy/mm/dd',
                language: 'jp'
            });

            $('#date_start1').on('change', function () {
                if ($('#date_end1').val() == '' || $('#date_end1').val() < $('#date_start1').val()) {
                    $('#date_end1').val($('#date_start1').val());
                }
            });

            $('#date_start2').on('change', function () {
                if ($('#date_end2').val() == '' || $('#date_end2').val() < $('#date_start2').val()) {
                    $('#date_end2').val($('#date_start2').val());
                }
            });

            $('#date_end1').on('change', function () {
                if ($('#date_start1').val() == '' || $('#date_end1').val() < $('#date_start1').val()) {
                    $('#date_start1').val($('#date_end1').val());
                }
            });

            $('#date_end2').on('change', function () {
                if ($('#date_start2').val() == '' || $('#date_end2').val() < $('#date_start2').val()) {
                    $('#date_start2').val($('#date_end2').val());
                }
            });
        });

        function go_location(id) {
            $('.location_id').val(id);
            $('#btn_location').trigger('click');
        }

        function go_report_detail(id, date) {
            $('.location_id').val(id);
            $('#location_date').val(date);
            $('#btn_location_detail').trigger('click');
        }

        function findLocation() {
            tbl1.draw();
        }

        function reset() {
            $('.form-control').val('');
            findLocation();
        }

        function save_location() {
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
                url: "{{ url('/add_location') }}",
                data: {
                    location_name: location_name,
                    order_name: order_name,
                    order_cost: order_cost,
                    locate_address: locate_address,
                    locate_startdate: locate_startdate,
                },
                success: function (v) {
                    if (v == 0) {
                        showNotification("warning", "{{trans('login.code_double')}}", "warning");
                    } else {
                        $('#kt_modal_1 input').val('');
                        $('#kt_modal_1 textarea').val('');
                        $('#kt_modal_1 .number-label').html('&nbsp;');
                        $('.btn-secondary').trigger('click');
                        findLocation();
                    }
                },
                error: function(data, status, err) {
                }
            });
        }

    </script>
@endsection
