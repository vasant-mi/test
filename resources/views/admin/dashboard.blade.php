@extends('admin.master')

@section('title', 'Dashboard')

@section('js')
    <!-- Morris Charts JavaScript -->
    <script src="{{URL::to('admin/vendor/raphael/raphael.min.js')}}"></script>
    <script src="{{URL::to('admin/vendor/morrisjs/morris.min.js')}}"></script>
    <script src="{{URL::to('admin/data/morris-data.js')}}"></script>
@endsection

@section('css')
    <!-- Morris Charts CSS -->
    <link href="{{URL::to('admin/vendor/morrisjs/morris.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">@lang('admin/admin.dashboard')</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<div class="dashboard-box">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalCharacter }}</div>
                            <div>Total Characters</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/character">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-random fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalRange }}</div>
                            <div>Total Range</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/range">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalUsers }}</div>
                            <div>Total Users</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/users">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-compass fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalRarity }}</div>
                            <div>Total Rarity</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/rarity">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalTeam }}</div>
                            <div>Total Teams</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/team">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-server fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalSeries }}</div>
                            <div>Total Series</div>
                        </div>
                    </div>
                </div>
                {{--<a href="Admin/series">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">124</div>
                            <div>Monthly Visitor</div>
                        </div>
                    </div>
                </div>
                {{--<a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">13</div>
                            <div>Weekly Visitor</div>
                        </div>
                    </div>
                </div>
                {{--<a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>--}}
            </div>
        </div>
    </div>
</div>
@endsection