<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@lang('admin/login.copomap_reset_password')</title>
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/custom.css')}}" rel="stylesheet">

    <style>
        body {
            background-color: #ffd0d0;
        }
    </style>
    <script src="{{URL::to('admin/vendor/datepicker/jquery.min.js')}}"></script>
    <script src="{{URL::to('admin/vendor/jquery/jquery.validate.js')}}"></script>
    <script>
        function showMessage(type, messages) {
            $('#messages').html('');
            var html = '';
            html += '<div class="alert alert-' + type + '">';
            html += '<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>';
            $.each(messages, function (key, message) {
                html += '<li>' + message + '</li>';
            });
            html += '</div>';
            $('#messages').html(html);
        }

        $(document).ready(function () {
            $('#resetPasswordForm').validate({
                rules: {
                    password: {
                        required: true
                    },
                    conf_password: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    password: {
                        required: '@lang('admin/login.password_is_required')'
                    },
                    conf_password: {
                        required: '@lang('admin/login.conf_password_is_required')',
                        equalTo: '@lang('admin/login.conf_password_and_password_is_not_same')',
                    }
                }
            });
            var sessionMessage = $('#{{\Config::get('admin.message')}}').val();
            $('#{{\Config::get('admin.message')}}').val('');
            if (sessionMessage = JSON.parse(sessionMessage)) {
                var message = Array.isArray(sessionMessage.message) ? sessionMessage.message : [sessionMessage.message];
                showMessage(sessionMessage.type, message)
            }
        })
    </script>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <br/><br/><br/>
            <div class="logo">
                <img src="{{url('admin/smasher.png')}}" class="img-responsive" alt="">
            </div>
            <div class="panel panel-smasher">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('admin/login.reset_password')</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="messages"></div>
                    {!! Form::hidden('', json_encode(Session::get(\Config::get('admin.message'))), ['id' => \Config::get('admin.message')]) !!}
                    {!! Form::open(['url' => url('Admin/reset-password', $id), 'id' => 'resetPasswordForm']) !!}
                    <div class="form-group">
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('admin/login.password'), 'id' => 'password']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::password('conf_password', ['class' => 'form-control', 'placeholder' => __('admin/login.confirm_password')]) !!}
                    </div>
                    {!! Form::submit(__('admin/login.save'), ['class' => 'btn btn-lg btn-success btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>