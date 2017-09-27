<html lang="{{App::getLocale()}}">
    <head>
        <link href="{{URL::to('public/web/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::to('public/web/css/custom.css')}}" rel="stylesheet">
        <style>
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <section class="reset-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <div class="logo-left">
                            <img style="width: 50px;"  src="{{URL::to('public/images/logo.png')}}">
                            <span>@lang('web/master.postcard_text')</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="row">
                {!! Form::open(['id' => 'resetPasswordForm']) !!}
                <div class="reset-password-main">
                    <div class="col-md-12 p-0">
                        <h1>@lang('web/master.password_reset')</h1>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label(__('web/master.enter_a_new_password')) !!}
                            {!! Form::password('password', ['class' => 'copomap-password-form', 'placeholder' => __('web/master.new_password'), 'id' => 'password']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label(__('web/master.confirm_your_new_password')) !!}
                            {!! Form::password('conf_password', ['class' => 'copomap-password-form', 'placeholder' => __('web/master.new_password')]) !!}
                        </div>
                        <div class="form-group">
                            <div class="reset-password-btn">
                                <a href="{{url('/')}}">@lang('web/master.cancel')</a>
                                {!! Form::submit(__('web/master.password_reset'), ['class' => 'btn-success']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </section>

        <script src="{{URL::to('public/web/js/jquery.js')}}"></script>
        <script src="{{URL::to('public/web/js/bootstrap.min.js')}}"></script>
        <script src="{{URL::to('public/web/js/jquery.validate.js')}}"></script>
        <script>
            $(document).ready(function(){
                $.validator.addMethod(
                    "regex",
                    function(value, element, regexp) {
                        return this.optional(element) || regexp.test(value);
                    },
                    "Please check your input."
                );
                $('#resetPasswordForm').validate({
                    rules: {
                        password: {
                            required: true,
                            minlength: 6
                        },
                        conf_password:{
                            required: true,
                            equalTo: '#password'
                        }
                    },
                    messages: {
                        password: {
                            required: '@lang('web/master.password_is_required')',
                            minlength: '@lang('web/master.password_min')'
                        },
                        conf_password:{
                            required: '@lang('web/master.confirm_password_is_required')',
                            equalTo: '@lang('web/master.confirm_password_does_not_math_password')'
                        }
                    }
                });
            });
        </script>
    </body>
</html>

