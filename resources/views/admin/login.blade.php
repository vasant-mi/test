<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@lang('admin/login.smasher_login')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/custom.css')}}" rel="stylesheet">

</head>
<style>
    body{
        background-color: #ffd0d0;
    }
</style>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="logo">
                <img src="{{url('admin/smasher.png')}}" class="img-responsive" alt="">
            </div>
            <div class="panel panel-smasher">

                <div class="panel-heading">
                    <h3 class="panel-title">@lang('admin/login.sign_in')</h3>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            @if(Session::has(\Config::get('admin.message')))
                                <div class="alert alert-{{Session::get(\Config::get('admin.message').'.type')}}">
                                    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                                    {{ Session::get(\Config::get('admin.message').'.message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    {!! Form::open(['url' => url('Admin/post-login'), 'id' => 'loginForm','novalidate' => 'novalidate']) !!}
                        <div class="form-group">
                            {!! Form::email('email', '', ['placeholder' => __('admin/login.email'), 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('admin/login.password')]) !!}
                        </div>
                        <div class="login-btn-btn">
                            {!! Form::submit(__('admin/login.login'), ['class' => 'btn btn-lg btn-success btn-block s-btn-block']) !!}
                            {!! link_to(url('Admin/forgot-password'), __('admin/login.forgot_password'), ['class' => 'btn btn-lg btn-success btn-block s-btn-block']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{URL::to('admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{URL::to('admin/vendor/jquery/jquery.validate.js')}}"></script>
<script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#loginForm').validate({

            onkeyup: false,
            rules: {
                email: {
                    required: true,
                    email:true,
                },
                password: "required"
            },
            messages: {
                email: {
                    required:'@lang('admin/login.please_enter_email')',
                    email: '@lang('admin/login.please_enter_valid_email')'
                },
                password: '@lang('admin/login.please_enter_password')'
            }
        });
    })
</script>
</html>