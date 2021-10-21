<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Daily Report</title>

        <link href="{{ asset('metronic/theme/classic/assets/app/custom/login/login-v3.default.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/theme/classic/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/custom_login.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/theme/classic/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="#">
                                <img src="{{ asset('metronic/theme/classic/assets/media/logos/logo-5.png') }}">
                            </a>
                        </div>
                        <div class="kt-login__signin">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">{{trans('login.daily_report_system')}}</h3>
                            </div>
                            <form class="kt-form" action="{{ url('/login') }}" method="post">
                                @csrf
                                <div class="kt_form_head">{{trans('login.login_page')}}</div>
                                <div class="kt_form_body">
                                    <div class="kt_login_error_message">@include('errors.errors')</div>
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="ID" id="id" name="userID" required>
                                    </div>
                                    <div class="input-group">
                                        <input class="form-control" type="password" placeholder="Password" id="password" name="password" required>
                                    </div>
                                    <div class="row kt-login__extra">
                                        <div class="col">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="remember" @if($auto_login == 1) checked @endif> {{trans('login.auto_login')}}
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="kt-login__actions">
                                        <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary"><i class="la la-unlock"></i>{{trans('login.login')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('metronic/theme/classic/assets/vendors/general/jquery-validation/dist/jquery.validate.min.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('#password').keypress(function (e) {
                if (e.keyCode === 13) {
                    $('#kt_login_signin_submit').click();
                }
            });

            $('.kt-form').validate({
                errorElement: 'span',
                errorClass: 'font-red',
                focusInvalid: true,
                rules: {
                    userID: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    userID: {
                        required: "{{trans('login.id_error')}}"
                    },
                    password: {
                        required: "{{trans('login.password_error')}}"
                    }
                }
            });
        });
    </script>
    </body>
</html>
