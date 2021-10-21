<button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_worker_add" id="btn_worker_add"></button>
<div class="modal fade" id="kt_modal_worker_add" tabindex="-1" role="dialog" aria-labelledby="worker_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title worker_title">{{trans('login.user_regist')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                        <form autocomplete="off">
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.name')}}</td>
                                <td style="width: 70%">
                                    <input type="number" class="form-control hidden worker_type" style="width: 120px;">
                                    <input type="text" class="form-control worker_name" style="width: 230px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.labor_cost')}}</td>
                                <td style="width: 70%">
                                    <label class="number-label">&nbsp;</label>
                                    <input type="text" class="form-control worker_labor_cost price" style="width: 230px; padding: 0px 13px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_head" style="width: 30%">{{trans('login.start_date')}}</td>
                                <td style="width: 70%">
                                    <input type="text" class="form-control form_date worker_labor_startdate" style="width: 230px; padding: 0px 13px;" readonly>
                                </td>
                            </tr>
                            <tr class="tax_container">
                                <td class="td_head" style="width: 30%">{{trans('login.tax_check')}}</td>
                                <td style="width: 70%">
                                    <input type="checkbox" class="form-control worker_tax" style="width: 25px;">
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                <button type="button" class="btn btn-primary" onclick="create_worker()" id="save_worker">{{trans('login.add')}}</button>
            </div>
        </div>
    </div>
</div>
