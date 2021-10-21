<button type="button" class="btn btn-brand hidden" data-toggle="modal" data-target="#kt_modal_worker_edit" id="btn_worker_edit"></button>
<div class="modal fade" id="kt_modal_worker_edit" tabindex="-1" role="dialog" aria-labelledby="worker_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title worker_title">{{trans('login.user_regist')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                    <tr>
                        <td class="td_head" style="width: 30%">{{trans('login.name')}}</td>
                        <td style="width: 70%">
                            <input type="number" class="form-control hidden worker_type" style="width: 120px;">
                            <input type="text" class="form-control worker_name" style="width: 210px;">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_head" style="width: 30%">{{trans('login.start_date')}}</td>
                        <td style="width: 70%">
                            <input type="text" class="form-control form_date worker_labor_startdate" style="width: 210px; padding: 0px 13px;" readonly>
                        </td>
                    </tr>
                    <tr class="visible_container">
                        <td class="td_head" style="width: 30%">非表示</td>
                        <td style="width: 70%">
                            <input type="checkbox" class="form-control worker_visible" style="width: 25px;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                <button type="button" class="btn btn-primary save_worker" onclick="edit_worker()">{{trans('login.add')}}</button>
            </div>
        </div>
    </div>
</div>
