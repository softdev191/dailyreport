function showConfirmDlg(message, label_cancel, lable_confirm, callback, close_flag, cancel_callback) {
    if(close_flag == undefined) {
        close_flag = true;
    }
    swal({
            customClass: 'confirm_dlg',
            title: '',
            text: message,
            type: '',
            showCancelButton: true,
            allowOutsideClick: true,
            confirmButtonClass: "btn-danger width-100",
            confirmButtonText: lable_confirm,
            closeOnConfirm: close_flag,
            cancelButtonClass: "btn-brand width-50",
            cancelButtonText: label_cancel
        },

        function(isConfirm){
            if(isConfirm) {
                if(callback != undefined) {
                    callback();
                }
            } else {
                if(cancel_callback != undefined) {
                    cancel_callback()
                }
            }
        });
}

function showNotification(no_title,message,type){

    var shortCutFunction = type;
    var msg = message;
    var title = no_title || '';

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    var $toast = toastr[shortCutFunction](msg, title);
}

function showLoadingProgress() {
    App.blockUI({
        animate: true,
        target: '#total_body',
        boxed: false
    });
}

function hideLoadingProgress(){
    App.unblockUI('#total_body');
}

function numberWithCommas(x) {
    return x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

(function($){
    $.fn.datepicker.dates['jp'] = {
        days: ["日曜", "月曜", "火曜", "水曜", "木曜", "金曜", "土曜"],
        daysShort: ["日", "月", "火", "水", "木", "金", "土"],
        daysMin: ["日", "月", "火", "水", "木", "金", "土"],
        months: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        monthsShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        today: "今日",
        titleFormat: "yyyy年mm月",
        clear: "クリア"
    };
}(jQuery));