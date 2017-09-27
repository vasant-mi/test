@extends('admin.master')

@section('title', __('admin/rarity.title'))

@section('css')
    <link href="{{URL::to('admin/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">@lang('admin/rarity.manage_rarity')</h1>
        </div>
        <div class="col-md-12 range-frm">
            <div class="col-lg-6 col-sm-7 col-sm-pr-0">
                {{ Form::open(['url' => '/Admin/rarity/save','class' => 'form form-inline','method' => 'POST','id' => 'rarity-form'])}}
                <div class="form-group">
                    {!! Form::text('rarity_name', "", ['class' => 'form-control', 'id' => 'rarity_name','placeholder'=>'Enter Rarity Name']) !!}
                    {!! Form::submit(__('admin/admin.add').' '.__('admin/rarity.title'),['class' => 'btn btn-primary saverarity' ])!!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-6 col-sm-5 col-sm-pl-0">
                <div class="pull-right">
                    <button class="btn btn-danger" id="deleteAll" type="button">@lang('admin/admin.delete')</button>
                    <a href="{{url('Admin/rarity/exportExcelFile')}}" class="btn btn-success" id="exportExcel"
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
                @lang('admin/rarity.title') @lang('admin/admin.list')
            </div>

            <form class="form-inline search-main">
                <div class="form-group">
                    <label>@lang('admin/admin.per_page')</label>
                    <select name="per_page" class="form-control" onchange="getPaginationVal(this.value)">
                        @foreach(Config::get('admin.per_page_array') as $p)
                            <option value="{{$p}}" {{$p == $raritys->perPage() ? 'selected="selected"' : ''}}>{{$p}}</option>
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
                        <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=title&per_page={{$per_page}}">@lang('admin/rarity.title')</a></th>
                        <th class="text-right-smash">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($raritys as $key => $rarity)
                        <tr>

                            <td class="text-center">
                                <input class="categoryCheckBox" name="agree[]" id="{{$rarity->id}}" type="checkbox"
                                       value="{{$rarity->id}}">
                            </td>
                            <td class="text-center">{{$rarity->title}}</td>
                            <td align="center">
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['class' => 'btn btn-primary editrarity','data-id' => $rarity->id,'data-toggle'=>"modal", 'data-target'=>'#editRarity', 'data-title'=> $rarity->title]) }}

                                {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger singleDelete','data-id' => $rarity->id]) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" align="center">@lang('admin/admin.nothing_found') @lang('admin/rarity.title')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                {!! \App\Admin\AdminController::pagination($raritys) !!}
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="editRarity" tabindex="-1" role="dialog" aria-labelledby="editRarityLable">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">@lang('admin/admin.edit') @lang('admin/rarity.title')</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => '/Admin/rarity/save','class' => 'form','method' => 'POST' ,'id'=>'rarity-form2'])}}
                    <input type="hidden" class="form-control" name="rarity_id" id="rarity_id" value="">
                    <div class="form-group">
                        {{ Form::label('email', Lang::get('admin/admin.title')) }}
                        {{ Form::text('rarity_name', "", ['class' => 'form-control', 'id' => 'rarity_title','placeholder'=>'Enter Rarity Name']) }}
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
            $('.togglerarity').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/rarity/change-status')}}',
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
                                showMessage('success', ['@lang('admin/rarity.title') @lang('admin/admin.active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/rarity.title') @lang('admin/admin.inactive_successfully')']);
                            }
                        }
                    }
                });
            });


            /* Edit Rarity Model */
            $('#editRarity').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var id = button.data('id');
                var modal = $(this);
//                modal.find('.modal-title').text('Edit - ' + title);
                modal.find('.modal-body #rarity_title').val(title);
                modal.find('.modal-body #rarity_id').val(id);
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
                       // $('.checkAll').prop('indeterminate', true);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());
                        });
                    }

                }
                else {
                    if ($('.categoryCheckBox:checked').length == 0) {
                       // $('.checkAll').prop('indeterminate', false);
                        $('.checkAll').prop('checked', false);
                        selected = [];
                        $(".categoryCheckBox:checked").each(function () {
                            selected.push($(this).val());
                        });

                    }
                    else {
                       // $('.checkAll').prop('indeterminate', true);
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
                        text: "Are you sure you want to delete all rarities?",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        type: 'warning',
                        allowOutsideClick: false,
                        confirmButtonText: 'Yes'
                    }).then(function () {
                        $.ajax({
                            url: '{{url('Admin/rarity/delete')}}',
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
                                        text: '@lang('admin/rarity.title') @lang('admin/admin.deleted_successfully')',
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
                        text: '@lang('admin/admin.select_at_list_one') @lang('admin/rarity.rarity')',
                        type: 'warning'
                    });
                }

            });

            /* Single delete */
            $('.singleDelete').click(function () {
                var id = $(this).data("id");
                swal({
                    title: '@lang('admin/admin.delete')',
                    text: '@lang('admin/admin.are_you_sure') @lang('admin/rarity.rarity')?',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    type: 'warning',
                    allowOutsideClick: false,
                    confirmButtonText: 'Yes'
                }).then(function () {
                    $.ajax({
                        url: '{{url('Admin/rarity/delete')}}',
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
                                    text: '@lang('admin/rarity.title') @lang('admin/admin.deleted_successfully')',
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
            $('#rarity-form').validate({
                rules: {
                    rarity_name: {
                        required: true
                    }
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.appendTo(element.parent());
                },
                messages: {
                    rarity_name: {
                        required: "Please enter rarity name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('#rarity-form2').validate({
                rules: {
                    rarity_name: {
                        required: true
                    }
                },
                messages: {
                    rarity_name: {
                        required: "Please enter rarity name."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

        });
    </script>
@endsection