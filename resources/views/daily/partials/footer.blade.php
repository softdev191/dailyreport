<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.27
 * Time: AM 8:40
 */
?>
<script>
    var KTAppOptions = {};
</script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/custom/components/vendors/jquery-validation/init.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('metronic/theme/classic/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/app/custom/general/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/theme/classic/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/common.js') }}" type="text/javascript"></script>

<script>
    $.fn.datepicker.defaults.autoclose = true;
    var KTBootstrapSelect = function () {
        var demos = function () {
            $('.kt-selectpicker').selectpicker({
                noneSelectedText: ''
            });
        };
        return {
            init: function() {
                demos();
            }
        };
    }();
    jQuery(document).ready(function() {
        KTBootstrapSelect.init();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    function updateTextView(_obj){
        var num = getNumber(_obj.val());
        var caret = _obj.prop("selectionStart");
        var orgVal = _obj.val();
        if(num==0){
            // _obj.val('');
        }else{
            var newVal = num.toLocaleString();
            var orgDots = orgVal.substring(0, caret).split(',').length - 1;
            var newDots = newVal.substring(0, caret).split(',').length - 1;
            _obj.val(num.toLocaleString());
            if (caret > 0) {
                _obj.prop("selectionStart", caret + newDots - orgDots);
                _obj.prop("selectionEnd", caret + newDots - orgDots);
            }
        }
    }
    function getNumber(_str){
        var arr = _str.split('');
        var out = new Array();
        for(var cnt=0;cnt<arr.length;cnt++){
            if(isNaN(arr[cnt])==false){
            out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
    $(document).ready(function(){
        // updateTextView($('input.price'));
    });
    // $(document).on('keyup', 'input.price', function(){
    //     updateTextView($(this));
    // });
    function convertNumber(_str) {
        if (_str == '-' || isNaN(_str)) return 0;
        return Number(_str);
    }
    function showPriceInput(obj) {
        var priceInput = $(obj).parent().children('.price')
        $(priceInput).show();
        $(priceInput).focus();
        $(obj).hide();
    }
    function showPriceLabel(obj) {
        var priceLabel = $(obj).parent().children('.number-label')
        var value = convertNumber($(obj).val());
        if (value != 0) {
            $(priceLabel).html(value.toLocaleString())
        } else {
            if ($(obj).val() == '') {
                $(priceLabel).html('&nbsp;')
            } else {
                $(priceLabel).html($(obj).val())
            }
        }
        $(priceLabel).show();
        $(obj).hide();
    }
    $(document).on('click', 'label.number-label', function(){
        showPriceInput(this);
    })
    $(document).on('focusout', 'input.price', function(){
        showPriceLabel(this);
    })
    $(document).on('keyup', 'input.price', function(e){
        if(e.keyCode == 13) {
            showPriceLabel(this);
        }
    })

    function onTop() {
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
                    location.href = "{{ url('/home') }}";
                },
                error: function(data, status, err) {
                }
            });
        } else {
            location.href = "{{ url('/home') }}";
        }
    }
</script>

@yield('page-script')
