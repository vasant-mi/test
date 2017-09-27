@extends('admin.master')

@section('title', 'Change-Password')

@section('css')

@endsection

@section('content')
    <div class="row">
        @if (session('status') == 400)
            <div id="successMessage" class="alert alert-danger margine-10">
                <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                <li>{{ session('message') }}</li>
            </div>
            @elseif(session('status') == 200)
            <div id="successMessage" class="alert alert-success margine-10">
                <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                <li>{{ session('message') }}</li>
            </div>
        @endif
        <div class="col-lg-12">
            <h1 class="page-header">@lang('admin/admin.change_password')</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {{ Form::open(['url' => '/Admin/change-password/save','class' => 'form','method' => 'POST','id' => 'change-password-form'])}}
            <div class="panel panel-smasher">
                <div class="panel-heading">@lang('admin/admin.change_password')</div>
                <div class="padding-10">
                    <div class="form-group">
                        {!! Form::label(__('admin/admin.old_password')) !!}
                        {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old_password','placeholder'=>__('admin/admin.old_password')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label(__('admin/admin.new_password')) !!}
                        {!! Form::password('new_password', ['class' => 'form-control', 'id' => 'new_password','placeholder'=>__('admin/admin.new_password')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label(__('admin/admin.confirm_password')) !!}
                        {!! Form::password('confirm_password', ['class' => 'form-control', 'id' => 'confirm_password','placeholder'=>__('admin/admin.confirm_password')]) !!}
                    </div>
                    <div align="right">
                        {!! Form::submit(__('admin/admin.update'),['class' => 'btn btn-smasher' ])!!}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#change-password-form').validate({
                rules: {
                    old_password: {
                        required: true,
                        minlength:6
                    },
                    new_password: {
                        required: true,
                        minlength:6
                    },
                    confirm_password: {
                        required: true,
                        minlength:6,
                        equalTo:'#new_password'
                    }

                },
                messages: {
                    old_password: {
                        required: "Please enter old password.",
                        minlength: "Please enter password min 6 character."
                    },
                    new_password: {
                        required: "Please enter new password.",
                        minlength: "Please enter password min 6 character."
                    },
                    confirm_password: {
                        required: "Please enter confirm password.",
                        minlength: "Please enter password min 6 character.",
                        equalTo:"New password and confirm password doesn't match."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
            setTimeout(function() {
                $('#successMessage').fadeOut('fast');
            }, 3000);
        });
    </script>
@endsection