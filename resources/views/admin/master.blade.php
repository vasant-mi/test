<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Karmdip Joshi">

    <title>@lang('admin/project.title') - @yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{URL::to('admin/vendor/ladda/ladda-themeless.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{URL::to('admin/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{URL::to('admin/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/custom.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/dist/css/toastr.min.css')}}" rel="stylesheet">

    @yield('css')

    <!-- Custom Fonts -->
    <link href="{{URL::to('admin/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top navbar-bg nav-custom" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{URL::to('Admin')}}">
                <img src="{{url('admin/smasher.png')}}" class="img-responsive" alt="">
            </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{url('Admin/change-password')}}"><i class="fa fa-cog fa-fw"></i> Change Password</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{URL::to('Admin/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="menu-icon">
            <a href="#"><img src="{{url('admin/menu-icon.svg')}}" class="img-responsive" alt=""></a>
        </div>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse collapse-hide">
                @php
                    function activeMenu($menu){
                        return \App\Admin\AdminController::$request->is('*/'.$menu.'*') ? 'active' : '';
                    }
                @endphp
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{URL::to('Admin')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/range')}}" class="{{activeMenu('range')}}"><i class="fa fa-random"></i> Manage Range</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/series')}}" class="{{activeMenu('series')}}"><i class="fa fa-server fa-fw"></i> Manage Series</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/team')}}" class="{{activeMenu('team')}}"><i class="fa fa-group fa-fw"></i> Manage Team</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/rarity')}}" class="{{activeMenu('rarity')}}"><i class="fa fa-compass fa-fw"></i> Manage Rarity</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/character')}}" class="{{activeMenu('character')}}"><i class="fa fa-comments fa-fw"></i> Manage Character</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/users')}}" class="{{activeMenu('users')}}"><i class="fa fa-group fa-fw"></i> Manage User</a>
                    </li>
                    {{--<li>
                        <a href="{{URL::to('Admin/change-password')}}"><i class="fa fa-cog fa-fw"></i> Change Password</a>
                    </li>
                    <li>
                        <a href="{{URL::to('Admin/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{URL::to('admin/vendor/jquery/jquery.min.js')}}"></script>



<!-- Bootstrap Core JavaScript -->
<script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{URL::to('admin/vendor/metisMenu/metisMenu.min.js')}}"></script>
<script src="{{URL::to('admin/vendor/ladda/spin.min.js')}}"></script>
<script src="{{URL::to('admin/vendor/ladda/ladda.min.js')}}"></script>
{{--<script src="{{URL::to('admin/dist/js/toastr.min.js')}}"></script>--}}

@yield('js')
<script>
    function showMessage(type, messages) {
        $('#messages').html('');
        var html = '';
        html += '<div class="alert alert-'+type+'">';
        html += '<button data-dismiss="alert" class="close" type="button"><span>×</span>' +
            '<span class="sr-only">Close</span></button>';
        $.each(messages, function (key, message) {
            html += '<li>'+message+'</li>';
        });
        html += '</div>';
        $('#messages').html(html);
    }

    /* menu responsive javascript */

    $('.menu-icon a').click(function () {

        if ( $('.collapse-hide').hasClass('collapse-show') ) {
            $('.collapse-hide').removeClass('collapse-show');
        } else {
            $('.collapse-hide').removeClass('collapse-show');
            $('.collapse-hide').addClass('collapse-show');
        }

    });

</script>
<!-- Custom Theme JavaScript -->
<script src="{{URL::to('admin/js/sb-admin-2.js')}}"></script>
<script src="{{URL::to('admin/dist/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::to('admin/dist/js/sweetalert2.min.js')}}"></script>
<script src="{{URL::to('admin/dist/js/jquery.validate.min.js')}}"></script>

</body>

</html>
