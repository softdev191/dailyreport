<button type="button" class="btn btn-warning btn_complete" data-toggle="modal" data-target="#kt_modal_report_finish" id="btn_report_finish">
    {{trans('login.daily_locate_complete')}}
</button>
<div class="modal fade" id="kt_modal_report_finish" tabindex="-1" role="dialog" aria-labelledby="worker_title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title worker_title">{{trans('login.daily_locate_complete')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped- table-bordered">
                    <tbody>
                        <tr>
                            <td class="td_head" style="width: 30%">{{trans('login.end_time')}}</td>
                            <td style="width: 70%">
                                <input type="text" class="form-control form_date finish_date" style="width: 210px; padding: 0px 13px;" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('login.cancel')}}</button>
                <button type="button" class="btn btn-primary" onclick="complete_location()">完工する</button>
            </div>
        </div>
    </div>
</div>
