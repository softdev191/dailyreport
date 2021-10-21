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
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row" style="margin: 10px 0 20px;">
                                <div class="col-lg-8" style="padding: 0">
                                    <button type="button" class="btn btn-primary" onclick="history.go(-1)">{{trans('login.daily_locate_back')}}</button>
                                </div>
                                <div class="col-lg-4" style="text-align: right; padding: 0">
                                    <button type="button" class="btn btn-brand" onclick="save()">{{trans('login.save')}}</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered table-no-footer table-long">
                                        <thead>
                                        <tr>
                                            <th>{{trans('login.locate_address')}}</th>
                                            <th>{{trans('login.locate_name')}}</th>
                                            <th>{{trans('login.order_name')}}</th>
                                            <th>{{trans('login.order_cost')}}</th>
                                            <th>累積人数</th>
                                            <th>{{trans('login.prime_cost')}}</th>
                                            <th>{{trans('login.reporter')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="width: 14%">{{$spot->address}}</td>
                                            <td style="width: 14%">{{$spot->name}}</td>
                                            <td style="width: 14%">{{$spot->contractor}}</td>
                                            <td style="width: 14%">{{number_format(round($spot->contract_price * (100 + $spot->tax) / 100))}}{{trans('login.won')}}</td>
                                            <td style="width: 14%" id="member_cnt"></td>
                                            <td style="width: 14%" id="order_cost"></td>
                                            <td style="width: 14%">{{$author}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped- table-bordered table_custom table-long">
                                        <thead>
                                        <tr class="header_info">
                                            <th>{{trans('login.labor_cost')}}</th>
                                            <th>{{trans('login.building_car')}}</th>
                                            <th>{{trans('login.cost')}}</th>
                                            <th>{{trans('login.building_tool')}}</th>
                                            <th>{{trans('login.cost')}}</th>
                                            <th>{{trans('login.disposal')}}</th>
                                            <th>{{trans('login.cost')}}</th>
                                            <th>{{trans('login.etc')}}</th>
                                            <th>{{trans('login.cost')}}</th>
                                            <th></th>
                                        </tr>
                                        <tr class="overall_cost">
                                            <th id="worker_total_cost"></th>
                                            <th>{{trans('login.overall_cost')}}</th>
                                            <th id="car_total_cost"></th>
                                            <th>{{trans('login.overall_cost')}}</th>
                                            <th id="equipment_total_cost"></th>
                                            <th>{{trans('login.overall_cost')}}</th>
                                            <th id="disposal_total_cost"></th>
                                            <th>{{trans('login.overall_cost')}}</th>
                                            <th id="etc_total_cost"></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="item_body">
                                        @foreach($report_details as $detail)
                                            @include('daily.partials.report.detail_row')
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($spot->status == 0 || Auth::user()->role == 1)
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <button type="button" class="btn btn-primary" style="margin-top: 20px !important;" onclick="addCol()">{{trans('login.item_add')}}</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6" style="text-align: right">
                                        <button type="button" class="btn btn-danger" style="margin-top: 20px !important;" onclick="delete_report()">{{trans('login.daily_report_delete')}}</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="number" class="hidden" id="role">
    <input type="text" class="hidden" id="role_name">
    <input type="number" class="hidden" id="spot_id" value="{{$id}}">
    <table class="table hidden">
        <tbody id="hidden_html">
            @include('daily.partials.report.detail_row_template')
        </tbody>
    </table>

    <script>
        var member_cnt = 0;
        var order_cost = 0;
        var worker_total_cost = 0;
        var car_total_cost = 0;
        var equipment_total_cost = 0;
        var disposal_total_cost = 0;
        var operating_total_cost = 0;
        var etc_total_cost = 0;
        var check_role_timer;
        function addCol() {
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
            console.log(roleName);
            if (role == 0) {
                showNotification("警告", roleName + "{{trans('login.editing')}}", "warning");
                return;
            }
            var html = $('#hidden_html').html();
            $('#item_body').append(html);
            init_setting();
        }

        async function delete_report() {
            await $.ajax({
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

            showConfirmDlg("{{trans('login.query_report_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/delete_report') }}",
                    data: {
                        id: "{{$id}}",
                        date: "{{$date}}",
                    },
                    success: function (v) {
                        history.go(-1);
                    },
                    error: function(data, status, err) {
                    }
                });
            });
        }

        function init_setting() {
            $('.company_select').on('change', function () {
                $(this).parent().children('.hidden_value').val(0);
                var type = $(this).parent().children('.type_select').attr('data-value');
                if (type == 0) {
                    $(this).parent().parent().children('.car_value').html('');
                } else {
                    $(this).parent().parent().children('.equipment_value').html('');
                }

                if ($(this).val() == '') {
                    $(this).parent().children('.type_select').html('');
                    $(this).parent().children('.equipment_select').html('');
                    $(this).parent().children('.car_select').html('');
                    if (type == 0) {
                        compute_car();
                    } else {
                        compute_equipment();
                    }
                }
                var obj = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/get_type_equip_list') }}",
                    data: {
                        company_id: $(this).val(),
                    },
                    dataType: 'json',
                    success: function (v) {
                        var types = v.type;
                        var equipments = v.equipment;
                        var cars = v.car;
                        var type_html = '';
                        var eqiup_html = '';
                        var car_html = '';
                        var i = 0;
                        if (types.length > 0) {
                            type_html = '<option value="0"></option>';
                            for (i = 0; i < types.length; i++) {
                                type_html += '<option value="' + types[i].id + '">' + types[i].name + '</option>';
                            }
                        }
                        if (equipments.length > 0) {
                            eqiup_html = '<option value="0"></option>';
                            for (i = 0; i < equipments.length; i++) {
                                eqiup_html += '<option value="' + equipments[i].id + '">' + equipments[i].name + '</option>';
                            }
                        }
                        if (cars.length > 0) {
                            car_html = '<option value="0"></option>';
                            for (i = 0; i < cars.length; i++) {
                                car_html += '<option value="' + cars[i].id + '">' + cars[i].name + '</option>';
                            }
                        }
                        $(obj).parent().children('.type_select').html(type_html);
                        $(obj).parent().children('.equipment_select').html(eqiup_html);
                        $(obj).parent().children('.car_select').html(car_html);
                        if (type == 0) {
                            compute_car();
                        } else {
                            compute_equipment();
                        }
                    },
                    error: function(data, status, err) {
                    }
                });
            });

            $('.worker_select').on('change', function () {
                if ($(this).val() == 0) {
                    $(this).parent().children('.hidden_value').val(0);
                    compute_worker();
                } else {
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/get_worker_price') }}",
                        data: {
                            id: $(this).val(),
                            date: "{{$date}}",
                        },
                        success: function (v) {
                            var worker_type = $(obj).parent().children('.worker_type_select').val();
                            $(obj).parent().children('.hidden_value').val(Math.round(v / worker_type));
                            compute_worker();
                        },
                        error: function(data, status, err) {
                        }
                    });
                }
            });

            $('.worker_type_select').on('change', function () {
                var worker_type = $(this).val();
                var worker_price = $(this).parent().children('.hidden_value').val();
                if (worker_type == 1) {
                    $(this).parent().children('.hidden_value').val(Math.round(worker_price * 2));
                } else {
                    $(this).parent().children('.hidden_value').val(Math.round(worker_price / 2));
                }
                compute_worker();
            });

            $('.type_select').on('change', function () {
                var type = $(this).attr('data-value');
                var type_id = $(this).val();
                var equip_id = type == 0 ? $(this).parent().children('.car_select').val() : $(this).parent().children('.equipment_select').val();
                if (type_id == 0 || equip_id == 0) {
                    $(this).parent().children('.hidden_value').val(0);
                    if (type == 0) {
                        $(this).parent().parent().children('.car_value').html('');
                        compute_car();
                    } else {
                        $(this).parent().parent().children('.equipment_value').html('');
                        compute_equipment();
                    }
                } else {
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/get_equip_price') }}",
                        data: {
                            type_id: type_id,
                            equip_id: equip_id,
                            date: "{{$date}}",
                        },
                        success: function (v) {
                            var price = v;
                            $(obj).parent().children('.hidden_value').val(v);
                            if (type == 0) {
                                $(obj).parent().parent().children('.car_value').html(numberWithCommas(v));
                                compute_car();
                            } else {
                                $(obj).parent().parent().children('.equipment_value').html(numberWithCommas(v));
                                compute_equipment();
                            }
                        },
                        error: function(data, status, err) {
                        }
                    });
                }
            });

            $('.car_select').on('change', function () {
                var type_id = $(this).parent().children('.type_select').val();
                var equip_id = $(this).val();
                if (type_id == 0 || equip_id == 0) {
                    $(this).parent().children('.hidden_value').val(0);
                    $(this).parent().parent().children('.car_value').html('');
                    compute_car();
                } else {
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/get_equip_price') }}",
                        data: {
                            type_id: type_id,
                            equip_id: equip_id,
                            date: "{{$date}}",
                        },
                        success: function (v) {
                            var price = v;
                            $(obj).parent().children('.hidden_value').val(v);
                            $(obj).parent().parent().children('.car_value').html(numberWithCommas(v));
                            compute_car();
                        },
                        error: function(data, status, err) {
                        }
                    });
                }
            });

            $('.equipment_select').on('change', function () {
                var type_id = $(this).parent().children('.type_select').val();
                var equip_id = $(this).val();
                if (type_id == 0 || equip_id == 0) {
                    $(this).parent().children('.hidden_value').val(0);
                    $(this).parent().parent().children('.equipment_value').html('');
                    compute_equipment();
                } else {
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/get_equip_price') }}",
                        data: {
                            type_id: type_id,
                            equip_id: equip_id,
                            date: "{{$date}}",
                        },
                        success: function (v) {
                            var price = v;
                            $(obj).parent().children('.hidden_value').val(v);
                            $(obj).parent().parent().children('.equipment_value').html(numberWithCommas(v));
                            compute_equipment();
                        },
                        error: function(data, status, err) {
                        }
                    });
                }
            });

            $('.disposal_value').on('change', function () {
                compute_disposal();
            });

            $('.operating_value').on('change', function () {
                compute_operating();
            });

            $('.etc_value').on('change', function () {
                compute_etc();
            });
        }

        function compute_worker() {
            var objs = $('.worker_select');
            member_cnt = 0;
            worker_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                var worker_id = $(objs[i]).val();
                if (worker_id > 0) {
                    member_cnt++;
                    worker_total_cost += parseInt($(objs[i]).parent().children('.hidden_value').val());
                }
            }
            if (member_cnt == 0) {
                $('#member_cnt').html('');
            } else {
                $('#member_cnt').html(member_cnt + "{{trans('login.member')}}");
            }
            if (worker_total_cost > 0) {
                $('#worker_total_cost').html(numberWithCommas(worker_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#worker_total_cost').html('')
            }
            compute_total();
        }

        function compute_car() {
            var objs = $('.hidden_car_value');
            car_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                car_total_cost += parseInt($(objs[i]).val());
            }
            if (car_total_cost > 0) {
                $('#car_total_cost').html(numberWithCommas(car_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#car_total_cost').html('')
            }
            compute_total();
        }

        function compute_equipment() {
            var objs = $('.hidden_equipment_value');
            equipment_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                equipment_total_cost += parseInt($(objs[i]).val());
            }
            if (equipment_total_cost > 0) {
                $('#equipment_total_cost').html(numberWithCommas(equipment_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#equipment_total_cost').html('')
            }
            compute_total();
        }

        function compute_disposal() {
            var objs = $('.disposal_value');
            disposal_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                var disposal_cost = convertNumber($(objs[i]).val());
                disposal_total_cost += disposal_cost;
            }
            if (disposal_total_cost != 0) {
                $('#disposal_total_cost').html(numberWithCommas(disposal_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#disposal_total_cost').html('')
            }
            compute_total();
        }

        function compute_operating() {
            var objs = $('.operating_value');
            operating_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                var operating_cost = isNaN($(objs[i]).val()) || $(objs[i]).val() == '' ? 0 : parseInt($(objs[i]).val());
                operating_total_cost += operating_cost;
            }
            if (operating_total_cost > 0) {
                $('#operating_total_cost').html(numberWithCommas(operating_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#operating_total_cost').html('')
            }
            compute_total();
        }

        function compute_etc() {
            var objs = $('.etc_value');
            etc_total_cost = 0;
            for (var i = 0; i < objs.length; i++) {
                var etc_cost = convertNumber($(objs[i]).val());
                etc_total_cost += etc_cost;
            }
            if (etc_total_cost != 0) {
                $('#etc_total_cost').html(numberWithCommas(etc_total_cost) + "{{trans('login.won')}}")
            } else {
                $('#etc_total_cost').html('')
            }
            compute_total();
        }

        function compute_total() {
            order_cost = worker_total_cost + car_total_cost + equipment_total_cost + disposal_total_cost + operating_total_cost + etc_total_cost;
            if (order_cost != 0) {
                $('#order_cost').html(numberWithCommas(order_cost) + "{{trans('login.won')}}")
            } else {
                $('#order_cost').html('')
            }
        }

        function save() {
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
            var objs = $('#item_body').children('.item_content');
            var data = [];
            for (var i = 0; i < objs.length; i++) {
                var item = {};
                item.id = $(objs[i]).attr('data-value');
                item.worker_id = $(objs[i]).find('.worker_select').val();
                item.percentage = $(objs[i]).find('.worker_type_select').val();
                item.car_company_id = $(objs[i]).find('.company_select_vehicle').val();
                item.car_type_id = $(objs[i]).find('.type_select_vehicle').val();
                item.car_eqiup_id = $(objs[i]).find('.car_select').val();
                item.tool_company_id = $(objs[i]).find('.company_select_equip').val();
                item.tool_type_id = $(objs[i]).find('.type_select_equip').val();
                item.tool_eqiup_id = $(objs[i]).find('.equipment_select').val();
                item.disposal_name = $(objs[i]).find('.disposal_name').val();
                var disposal_value = $(objs[i]).find('.disposal_value').val();
                item.disposal_value = getNumber(disposal_value) == 0 ? disposal_value : disposal_value.replace(/,/g, '');
                item.operating_name = '';
                item.operating_value = 0;
                var etc_value = $(objs[i]).find('.etc_value').val();
                item.etc_name = $(objs[i]).find('.etc_name').val();
                item.etc_value = getNumber(etc_value) == 0 ? etc_value : etc_value.replace(/,/g, '');
                data.push(item);
            }
            if (data.length == 0) {
                history.go(-1);
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ url('/save_report_detail') }}",
                data: {
                    id: "{{$id}}",
                    date: "{{$date}}",
                    report_detail: JSON.stringify(data),
                },
                success: function (v) {
                    history.go(-1);
                },
                error: function(data, status, err) {
                }
            });
        }

        $(document).ready(function () {
            check_role_timer = setInterval(check_role, 15 * 60 * 1000);
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
                        $('input.form-control').prop('readonly', true);
                        $('select.form-control').prop('disabled', true);
                    }
                    init_setting();

                    var report_cnt = parseInt("{{$report_cnt}}");
                    if (report_cnt == 0) {
                        addCol();
                        compute_etc()
                    } else {
                        compute_worker();
                        compute_car();
                        compute_equipment();
                        compute_disposal();
                        compute_operating();
                        compute_etc()
                    }
                },
                error: function(data, status, err) {
                }
            });
        });

        function check_role() {
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
                        $('input.form-control').prop('readonly', true);
                        $('select.form-control').prop('disabled', true);
                    } else {
                        $('input.form-control').prop('readonly', false);
                        $('select.form-control').prop('disabled', false);
                    }
                },
                error: function(data, status, err) {
                }
            });
        }

        function delete_report_row(that) {
            showConfirmDlg("{{trans('login.query_delete')}}", "{{trans('login.cancel')}}", "{{trans('login.delete')}}", function (val) {
                var parent = $(that).closest('.item_content');
                parent.remove();
            })
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
