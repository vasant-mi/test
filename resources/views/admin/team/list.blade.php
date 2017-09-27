@extends('admin.master')

@section('title', __('admin/team.team'))

@section('css')
    <link href="{{URL::to('admin/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">@lang('admin/team.manage_team')</h1>
        </div>
        <div class="range-frm col-md-12">
            <div class="col-lg-6 col-sm-7 col-sm-pr-0">
                {{ Form::open(['url' => '/Admin/team/save','class' => 'form form-inline','method' => 'POST','id' => 'team-form'])}}
                <div class="form-group">
                    {!! Form::text('team_name', "", ['class' => 'form-control', 'id' => 'team_name','placeholder'=>'Enter Team Name']) !!}
                    {!! Form::submit(__('admin/admin.add') .' '.__('admin/team.title'),['class' => 'btn btn-primary saveteam' ])!!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-6 col-sm-5 col-sm-pl-0">
                <div class="pull-right">
                    <button class="btn btn-danger" id="deleteAll" type="button">@lang('admin/admin.delete')</button>
                    <a href="{{url('Admin/team/exportExcelFile')}}" class="btn btn-success" id="exportExcel"
                       type="button">@lang('admin/admin.export_to_excel')</a>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('success'))
        <div id="success_message" class="alert alert-success alert-dismissable">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-smasher">
                <div class="panel-heading">
                    @lang('admin/team.title') @lang('admin/admin.list')
                </div>

                <form class="form-inline search-main">
                    <div class="form-group">
                        <label>@lang('admin/admin.per_page')</label>
                        <select name="per_page" class="form-control" onchange="getPaginationVal(this.value)">
                                @foreach(Config::get('admin.per_page_array') as $p)
                                    <option value="{{$p}}" {{$p == $teams->perPage() ? 'selected="selected"' : ''}}>{{$p}}</option>
                                @endforeach
                            </select>
                    </div>
                    {{-- <div class="form-group col-md-5 text-right">
                         <button class="btn btn-primary" type="submit">@lang('admin/admin.apply')</button>
                         --}}{{--<a class="btn btn-default" href="{{url()->current()}}">@lang('admin/admin.reset')</a>--}}{{--
                     </div>--}}
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover brdr-top-tbl-mi">
                        <thead>
                        <tr>
                            <th class="text-left-smash text-center">
                                <input class="checkAll" name="agree" id="checkAll" type="checkbox"></th>
                            {{--<th>#</th>--}}
                            <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=title&per_page={{$per_page}}">@lang('admin/team.title')</a></th>
                            {{--<th class="text-center">Status</th>--}}
                            <th class="text-right-smash">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($teams as $key => $team)
                            <tr>
                                <td class="text-center">
                                    <input class="categoryCheckBox" name="agree[]" id="{{$team->id}}" type="checkbox"
                                           value="{{$team->id}}">
                                </td>
                                {{--<td>{{$key + ($teams->perPage() * ($teams->currentPage()-1)) + 1}}</td>--}}
                                <td class="text-center">{{$team->title}}</td>
                                {{--<td align="center">--}}
                                {{--<label class="checkbox-inline checkbox-inline-bg">--}}
                                {{--{!! Form::checkbox('', '', $team->status_id == \App\Status::$ACTIVE, ['data-toggle' => 'toggle', 'data-on' => 'Active', 'data-off' => 'Inactive', 'class' => 'toggleteam', 'data-id' => $team->id]) !!}--}}
                                {{--</label>--}}
                                {{--</td>--}}
                                <td align="center">
                                    {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['class' => 'btn btn-primary editteam','data-id' => $team->id,'data-toggle'=>"modal", 'data-target'=>'#editTeam', 'data-title'=> $team->title]) }}

                                    {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger singleDelete','data-id' => $team->id]) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">@lang('admin/admin.nothing_found') @lang('admin/team.title')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    {!! \App\Admin\AdminController::pagination($teams) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTeam" tabindex="-1" role="dialog" aria-labelledby="editTeamLable">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">@lang('admin/admin.edit') @lang('admin/team.title')</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => '/Admin/team/save','class' => 'form','method' => 'POST','id'=>'team-form2'])}}
                    <input type="hidden" class="form-control" name="team_id" id="team_id" value="">
                    <div class="form-group">
                        {{ Form::label('email', Lang::get('admin/admin.title')) }}
                        {{ Form::text('team_name', "", ['class' => 'form-control', 'id' => 'team_title','placeholder'=>'Enter Team Name']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit(Lang::get('admin/admin.update'),['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
    <script>

        function getPaginationVal(val) {
            window.location = window.location.pathname+'?per_page='+val+'&sorting={{$sort}}&field={{$field}}';
        }

        var ACTIVE = parseInt('{{\App\Status::$ACTIVE}}');
        var INACTIVE = parseInt('{{\App\Status::$INACTIVE}}');
        $(document).ready(function () {
            /* Status ACTIVE/INACTIVE Toggle */
            $('.toggleteam').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/team/change-status')}}',
                    data: {
                        status: status,
                        id: $(this).attr('data-id'),
                        _token: '{{csrf_token()}}'
                    },
                    method: 'POST',
                    success: function (response) {
                        l.stop();
                        if (response.status != '200') {
                            showMessage('danger', response.message)
                        } else {
                            if (status == 1) {
                                showMessage('success', ['@lang('admin/team.title') @lang('admin/admin.active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/team.title') @lang('admin/admin.inactive_successfully')']);
                            }
                        }
                    }
                });
            });

            /* Edit Team Model */
            $('#editTeam').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var id = button.data('id');
                var modal = $(this);
//                modal.find('.modal-title').text('Edit - ' + title);
                modal.find('.modal-body #team_title').val(title);
                modal.find('.modal-body #team_id').val(id);
            });

            /* Check/Uncheck all Check box */
            $('.checkAll').click(function () {
                if ($(this).prop('checked')) {
                    $('.categoryCheckBox').prop('checked', true);
                    selected = [];
                    $(".categoryCheckBox:checked").each(function () {
                        selected.push($(this).val());
                    });
                } else {
                    $('.categoryCheckBox').prop('checked', false);
                    selected = [];
                }
            });

            /* Checkbox value change */
            $('.categoryCheckBox').on('change', function () {
                if ($(this).prop('checked')) {
                    if ($('.categoryCheckBox:checked').length == $('.categoryCheckBox').length) {
                        //$('.checkAll').prop('indeterminate', false);
                        $('.checkAll').prop('checked', true);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());
                        });
                    }
                    else {
                        //$('.checkAll').prop('indeterminate', true);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());
                        });
                    }

                }
                else {
                    if ($('.categoryCheckBox:checked').length == 0) {
                        //$('.checkAll').prop('indeterminate', false);
                        $('.checkAll').prop('checked', false);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());
                        });

                    }
                    else {
                        //$('.checkAll').prop('indeterminate', true);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());

                        });

                    }
                }
            });

            /* Multiple delete */
            $('#deleteAll').click(function () {

                var checkValues = $('.categoryCheckBox:checked').length;

                if (checkValues > 0) {
                    swal({
                        title: '@lang('admin/admin.delete')',
                        text: "Are you sure you want to delete all teams?",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        type: 'warning',
                        allowOutsideClick: false,
                        confirmButtonText: 'Yes'
                    }).then(function () {
                        $.ajax({
                            url: '{{url('Admin/team/delete')}}',
                            data: {
                                selected: selected,
                                _token: '{{csrf_token()}}'
                            },
                            method: 'POST',
                            success: function (response) {
                                if (response.status != '200') {
                                    showMessage('danger', response.message)
                                } else {
                                    swal({
                                        title: "Success",
                                        text: '@lang('admin/team.team') @lang('admin/admin.deleted_successfully')',
                                        type: "success"
                                    }).then(function () {
                                        location.href = document.URL;
                                    });
                                }
                            }
                        });
                    });
                } else {
                    swal({
                        title: '@lang('admin/admin.delete')',
                        text: 'Please select at-least one team',
                        type: 'warning'
                    });
                }
            });

            /* Single delete */
            $('.singleDelete').click(function () {
                var id = $(this).data("id");
                swal({
                    title: '@lang('admin/admin.delete')',
                    text: "Are you sure you want to delete this team?",
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    type: 'warning',
                    allowOutsideClick: false,
                    confirmButtonText: 'Yes'
                }).then(function () {
                    $.ajax({
                        url: '{{url('Admin/team/delete')}}',
                        data: {
                            selected: [id],
                            _token: '{{csrf_token()}}'
                        },
                        method: 'POST',
                        success: function (response) {
                            if (response.status != '200') {
                                showMessage('danger', response.message)
                            } else {
                                swal({
                                    title: "Success",
                                    text: '@lang('admin/team.team') @lang('admin/admin.deleted_successfully')',
                                    type: "success"
                                }).then(function () {
                                    location.href = document.URL;
                                });
                            }
                        }
                    });
                });
            });

            /* Form validation */
            $('#team-form').validate({
                rules: {
                    team_name: {
                        required: true
                    }
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.appendTo(element.parent());
                },
                messages: {
                    team_name: {
                        required: "Please enter team name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
            $('#team-form2').validate({
                rules: {
                    team_name: {
                        required: true
                    }
                },
                messages: {
                    team_name: {
                        required: "Please enter team name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection