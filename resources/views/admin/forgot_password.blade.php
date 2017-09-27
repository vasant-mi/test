<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@lang('admin/login.forgot_password')</title>
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/custom.css')}}" rel="stylesheet">

    <script src="{{URL::to('admin/vendor/datepicker/jquery.min.js')}}"></script>
    <script src="{{URL::to('admin/vendor/jquery/jquery.validate.js')}}"></script>
    <script>
        function showMessage(type, messages) {
            $('#messages').html('');
            var html = '';
            html += '<div class="alert alert-'+type+'">';
            html += '<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>';
            $.each(messages, function (key, message) {
                html += '<li>'+message+'</li>';
            });
            html += '</div>';
            $('#messages').html(html);
        }
        $(document).ready(function () {
            $('#forgotPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: '@lang('admin/login.please_enter_email')',
                        email: '@lang('admin/login.email_is_not_valid')'
                    }
                }
            });
            var sessionMessage = $('#{{\Config::get('admin.message')}}').val();
            $('#{{\Config::get('admin.message')}}').val('');
            if(sessionMessage = JSON.parse(sessionMessage)){
                var message = Array.isArray(sessionMessage.message) ? sessionMessage.message : [sessionMessage.message];
                showMessage(sessionMessage.type, message)
                setTimeout(function() {
                    $('#messages').fadeOut('fast');
                }, 3000);
            }
        })
    </script>
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
                    <h3 class="panel-title">@lang('admin/login.forgot_password')</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="messages"></div>
                    {!! Form::hidden('', json_encode(Session::get(\Config::get('admin.message'))), ['id' => \Config::get('admin.message')]) !!}
                    {!! Form::open(['url' => url('Admin/forgot-password'), 'id' => 'forgotPasswordForm']) !!}
                        <div class="form-group">
                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('admin/login.email'), 'autofocus']) !!}
                        </div>
                    <div class="login-btn-btn">
                        {!! Form::submit(__('admin/login.send'), ['class' => 'btn btn-lg btn-success btn-block s-btn-block']) !!}
                        {!! link_to(url('Admin/login'), __('admin/login.login'), ['class' => 'btn btn-lg btn-success btn-block s-btn-block']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>