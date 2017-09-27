@extends('admin.master')

@section('title', __('admin/series.series'))

@section('js')
    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
    <script>
        function getPaginationVal(val) {
            window.location = window.location.pathname+'?per_page='+val+'&sorting={{$sort}}&field={{$field}}';
        }
        var ACTIVE = parseInt('{{\App\Status::$ACTIVE}}');
        var INACTIVE = parseInt('{{\App\Status::$INACTIVE}}');
        $(document).ready(function () {

            $('#series-form').validate({
                rules: {
                   series_name: {
                        required: true
                    }
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.appendTo(element.parent());
                },
                messages: {
                    series_name: {
                        required: "Please enter series name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('#series-form2').validate({
                rules: {
                    series_name: {
                        required: true
                    }
                },
                messages: {
                    series_name: {
                        required: "Please enter series name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('.toggleSeries').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/series/change-status')}}',
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
                                showMessage('success', ['@lang('admin/series.series_active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/series.series_inactive_successfully')']);
                            }
                        }
                    }
                });
            });


            $('#editSeries').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('whatever');
                var id = button.data('id');
                var modal = $(this);
               /* modal.find('.modal-title').text('Edit - ' + title);*/
                modal.find('.modal-body #series_title').val(title);
                modal.find('.modal-body #series_id').val(id);
            })

            $(".deleteThis").click(function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    title:'Delete',
                    text: "Are you sure you want to delete this series?",
                    type: "warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                }).then(function () {
                    $.ajax({
                        type: "POST",
                        url: "{{url('Admin/series/destroy')}}",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status != '200') {
                                showMessage('danger', response.message)
                            } else {
                                swal({
                                    title: "Success",
                                    text: '@lang('admin/series.series_name') @lang('admin/admin.deleted_successfully')',
                                    type: "success"
                                }).then(function () {
                                    location.href = document.URL;
                                });
                            }
                        }
                    });
                });
            });


            $(".deleteAll").click(function (e) {

                var checkValues = $('input[name=seriesBox]:checked').map(function () {
                    return $(this).attr('data-id');
                }).get();

                if (checkValues == '') {
                    swal({
                        title: "Delete",
                        text: "Please select At-least one series",
                        type: "warning"
                    });
                } else {

                    e.preventDefault();
                    swal({
                        text:"Are you sure you want to delete all series?",
                        title: "Delete",
                        type: "warning",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        showCancelButton: true,
                    }).then(function () {
                        $.ajax({
                            type: "POST",
                            url: "{{url('Admin/series/destroyAll')}}",
                            data: {
                                id: checkValues,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response.status != '200') {
                                    showMessage('danger', response.message)
                                } else {
                                    swal({
                                        title: "Success",
                                        text: '@lang('admin/series.series_name') @lang('admin/admin.deleted_successfully')',
                                        type: "success"
                                    }).then(function () {
                                        location.href = document.URL;
                                    });
                                }
                            }
                        });
                    });
                }
            });


            /*jQuery for toggle checkbox and select all */

            $("#select_all").change(function () {
                $(".checkbox").prop('checked', $(this).prop("checked"));
            });
            $('.checkbox').change(function () {
                if (false == $(this).prop("checked")) {
                    $("#select_all").prop('checked', false);
                }
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $("#select_all").prop('checked', true);
                }
            });

        });
    </script>
@endsection

@section('css')
    <link href="{{URL::to('admin/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">@lang('admin/series.manage_series')</h1>
        </div>
        <div class="range-frm col-md-12">
            <div class="col-lg-6 col-sm-7 col-sm-pr-0">
                {{ Form::open(['url' => '/Admin/series/save','class' => 'form form-inline','method' => 'POST' ,'id' => 'series-form'])}}
                <div class="form-group">
                    {!! Form::text('series_name', "", ['class' => 'form-control', 'id' => 'title','placeholder'=>'Enter Series Name']) !!}
                    {!! Form::submit(__('admin/admin.add') .' '.__('admin/series.series_name'),['class' => 'btn btn-primary saveSeries' ])!!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-6 col-sm-5 col-sm-pl-0">
                <div class="pull-right">
                    {{ Form::button(__('admin/admin.delete'), array('class' => 'btn btn-danger deleteAll')) }}
                    <a href="{{url('Admin/series/exportExcelFile')}}" class="btn btn-success" id="exportExcel"
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
                    @lang('admin/series.series_list')
                </div>


                <form class="form-inline search-main">
                    <div class="form-group">
                        <label>@lang('admin/series.per_page')</label>
                        <select name="per_page" class="form-control" onchange="getPaginationVal(this.value)">
                            @foreach(Config::get('admin.per_page_array') as $p)
                                <option value="{{$p}}" {{$p == $seriess->perPage() ? 'selected="selected"' : ''}}>{{$p}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>


                <div class="table-responsive">
                    <table id="records_table" class="table table-striped table-bordered table-hover brdr-top-tbl-mi">
                        <thead>
                        <tr>
                            <th class="text-left-smash text-center">{{ Form::checkbox('seriesBox', 1, null, ['class' => 'field', 'id'=>'select_all']) }}</th>
                            <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=title&per_page={{$per_page}}">@lang('admin/series.title')</a></th>
                            <th class="text-right-smash">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($seriess as $key => $series)
                            <tr>
                                <td align="center">{{ Form::checkbox('seriesBox', 1, null, ['class' => 'field checkbox', 'data-id' => $series->id]) }}</td>
                                <td class="text-center">{{$series->title}}</td>
                                <td align="center">
                                    {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['class' => 'btn btn-primary editSeries','data-id' => $series->id,'data-toggle'=>"modal", 'data-target'=>'#editSeries', 'data-whatever'=> $series->title]) }}
                                    {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger deleteThis','data-id' => $series->id]) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">@lang('admin/series.no_series')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {!! \App\Admin\AdminController::pagination($seriess) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSeries" tabindex="-1" role="dialog" aria-labelledby="editSeriesLable">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Edit Series</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => '/Admin/series/save','class' => 'form','method' => 'POST' ,'id' => 'series-form2'])}}
                    <input type="hidden" class="form-control" name="series_id" id="series_id" value="">
                    <div class="form-group">
                        {{ Form::label('email', Lang::get('admin/series.title')) }}
                        {{ Form::text('series_name', "", ['class' => 'form-control', 'id' => 'series_title','placeholder'=>'Enter Series Name']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit(Lang::get('admin/series.update'),['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection