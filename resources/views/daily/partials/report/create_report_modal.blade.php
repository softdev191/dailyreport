<button type="button" class="btn btn-warning btn_add" data-toggle="modal" data-target="#kt_modal_report_add" id="btn_report_add">
    <span class="kt-badge kt-badge--brand" style="color: #1ba453; background: white !important;">+</span> {{trans('login.daily_report_add')}}
</button>
<div class="modal fade" id="kt_modal_report_add" tabindex="-1" role="dialog" aria-labelledby="worker_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title worker_title">{{trans('login.daily_report_add')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                        <tr>
                            <td class="td_head" style="width: 30%">{{trans('login.date')}}</td>
                            <td style="width: 70%">
                                <input type="text" class="form-control form_date report_date" style="width: 210px; padding: 0px 13px;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_head" style="width: 30%">作成者</td>
                            <td>
                                <input type="text" class="form-control author" style="width: 210px; padding: 0px 13px;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                <button type="button" class="btn btn-primary" onclick="create_report()">{{trans('login.add')}}</button>
            </div>
        </div>
    </div>
</div>
