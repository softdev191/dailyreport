<label class="btn_locate_add" data-toggle="modal" data-target="#kt_modal_1" id="btn_locate_add"></label>
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('login.daily_locate_edit')}}</h5>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                        <form autocomplete="off">
                            <tr>
                                <td class="td_head" style="width: 30%;">工事名</td>
                                <td>
                                    <input type="text" class="form-control" id="locate_name" style="width: 230px; padding: 0px 13px;" value="{{$spot->name}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%;">{{trans('login.locate_address')}}</td>
                                <td>
                                    <input type="text" class="form-control" id="locate_address" style="width: 230px;" value="{{$spot->address}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%;">{{trans('login.order_cost_short')}}</td>
                                <td>
                                    <input type="text" class="form-control price" id="order_cost" style="width: 230px; padding: 0px 13px;display:none" value="{{$spot->contract_price}}">
                                    <label class="number-label">{{number_format($spot->contract_price)}}</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%;">{{trans('login.order')}}</td>
                                <td>
                                    <input type="text" class="form-control" id="order_name" style="width: 230px;" value="{{$spot->contractor}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">着工日</td>
                                <td style="display: flex; border: none;">
                                    <input type="text" class="form-control form_date" id="order_startdate" style="width: 230px; padding: 0px 13px;"
                                        readonly value={{ $spot->started_at }}>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="display: block; text-align: center">
                <button type="button" class="btn btn-success" onclick="change_location()">{{trans('login.change')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.close1')}}</button>
            </div>
        </div>
    </div>
</div>
