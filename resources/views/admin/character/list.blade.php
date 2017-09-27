@extends('admin.master')

@section('title', __('admin/character.character'))

@section('js')

    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>


    <script>

        function backToMain() {
            window.location = window.location.pathname;
        }

        function getPaginationVal(val) {
            window.location = window.location.pathname+'?per_page='+val+'&sorting={{$sort}}&field={{$field}}';
        }

        var ACTIVE = parseInt('{{\App\Status::$ACTIVE}}');
        var INACTIVE = parseInt('{{\App\Status::$INACTIVE}}');
        $(document).ready(function () {

            $('.toggleCharacter').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/character/change-status')}}',
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
                                showMessage('success', ['@lang('admin/character.character_active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/character.character_inactive_successfully')']);
                            }
                        }
                    }
                });
            });


            $('#editCharacter').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('whatever');
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-title').text('Edit - ' + title);
                modal.find('.modal-body #character_title').val(title);
                modal.find('.modal-body #character_id').val(id);
            })

            $(".deleteThis").click(function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    title: "Delete",
                    text: "Are you sure you want to delete this character?",
                    type: "warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true
                }).then(function () {
                    $.ajax({
                        type: "POST",
                        url: "{{url('Admin/character/destroy')}}",
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {

                            if (response.status != '200') {
                                showMessage('danger', response.message)
                            } else {
                                showMessage('danger', ['Center deleted successfully']);
                                setTimeout(function () {
                                    window.location.href = '{{ url('Admin/character') }}';
                                }, 500);
                            }

                        }
                    });
                });
            });


            $(".deleteAll").click(function (e) {

                var checkValues = $('input[name=characterBox]:checked').map(function () {
                    return $(this).attr('data-id');
                }).get();

                if (checkValues == '') {
                    swal({
                        text:"Please select At-least one character",
                        title: "Delete",
                        type: "warning"
                    });
                } else {

                    e.preventDefault();
                    swal({
                        title: "Delete",
                        text: "Are you sure you want to delete all characters?",
                        type: "warning",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        showCancelButton: true
                    }).then(function () {
                        $.ajax({
                            type: "POST",
                            url: "{{url('Admin/character/destroyAll')}}",
                            data: {
                                id: checkValues,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {

                                if (response.status != '200') {
                                    showMessage('danger', response.message)
                                } else {
                                    showMessage('danger', ['Center deleted successfully']);
                                    setTimeout(function () {
                                        window.location.href = '{{ url('Admin/character') }}';
                                    }, 500);
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

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">@lang('admin/character.character_manage')</h1>
        </div>
        <div class="col-lg-12">
            <div class="pull-right character-btn">
                <button type="button" class='btn btn-primary'
                        onclick="window.location='{{ url("Admin/character/add") }}'">Add
                </button>
                {{ Form::button('Delete', array('class' => 'btn btn-danger deleteAll')) }}
                <a href="{{url('Admin/character/exportExcelFile')}}" class="btn btn-success" id="exportExcel"
                   type="button">@lang('admin/admin.export_to_excel')</a>
            </div>
        </div>
    </div>

    <br>
    @php $image  = base_path() . '/admin/' @endphp

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
                @lang('admin/character.character_list')
            </div>


            <form class="form-inline search-main">
                <div class="form-group sea-left">
                    <label>@lang('admin/character.per_page')</label>
                    <select name="per_page" class="form-control" onchange="getPaginationVal(this.value)">
                        @foreach(Config::get('admin.per_page_array') as $p)
                            <option value="{{$p}}" {{$p == $characters->perPage() ? 'selected="selected"' : ''}}>{{$p}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="sorting" value="{{$sort}}" >
                    <input type="hidden" name="field" value="{{$field}}" >
                </div>
                <div class="form-group sea-right pull-right">
                    <form class="form-inline" method="get">
                        <input type="text" name="search_field" value="{{ app('request')->input('search_field') ? app('request')->input('search_field') : '' }}" class="form-control" id="exampleInputName2" placeholder="Search here">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="submit" class="btn btn-default">Reset</button>
                    </form>
                </div>
            </form>


            <div class="table-responsive">
                <table id="records_table" class="table table-striped table-bordered table-hover brdr-top-tbl-mi">
                    <thead>
                    <tr>
                        <th class="text-center">{{ Form::checkbox('characterBox', 1, null, ['class' => 'field', 'id'=>'select_all']) }}</th>
                        <th class="text-center">Icon</th>
                        <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=name&per_page={{$per_page}}">Character Name</a></th>
                        <th class="text-center">Rarity</th>
                        <th class="text-center">Team</th>
                        <th class="text-center">Series</th>
                        <th class="text-center">Range</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Found In</th>
                        {{--<th class="text-center">Status</th>--}}
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    {{ $characters }}
                    @forelse($characters as $key => $character)
                        <tr>
                            <td align="center">{{ Form::checkbox('characterBox', 1, null, ['class' => 'field checkbox', 'data-id' => $character->id]) }}</td>
                            <td class="text-center"><img src="{{ \App\Character::imageURL($character->image) }}" height="100" width="100">
                            </td>
                            <td class="text-center">{{$character->name}}</td>
                            <td class="text-center">{{$character-> rarity_name}}</td>
                            <td class="text-center">{{$character->team_name}}</td>
                            <td class="text-center">{{$character->series_name}}</td>
                            <td class="text-center">{{$character->range_name}}</td>
                            <td class="text-center">{{$character->code}}</td>
                            <td class="text-center">${{$character->value}}</td>
                            <td class="text-center">{{$character->title_name}}</td>
                            {{--<td align="center">--}}
                                {{--<label class="checkbox-inline checkbox-inline-bg">--}}
                                    {{--{!! Form::checkbox('', '', $character->status_id == \App\Status::$ACTIVE, ['data-toggle' => 'toggle', 'data-on' => 'Active', 'data-off' => 'Inactive', 'class' => 'toggleCharacter', 'data-id' => $character->id]) !!}--}}
                                {{--</label>--}}
                            {{--</td>--}}
                            <td align="center">
                                <button type="button" class='btn btn-primary'
                                        onclick="window.location='{{ url("Admin/character/add/$character->id") }}'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                                {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger deleteThis','data-id' => $character->id]) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" align="center">@lang('admin/character.no_character')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {!! \App\Admin\AdminController::pagination($characters) !!}
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="editCharacter" tabindex="-1" role="dialog" aria-labelledby="editCharacterLable">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">@lang('admin/character.edit_character')</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['url' => '/Admin/character/save','class' => 'form','method' => 'POST'])}}
                    <input type="hidden" class="form-control" name="character_id" id="character_id" value="">
                    <div class="form-group">
                        {{ Form::label('email', Lang::get('admin/character.title')) }}
                        {{ Form::text('character_name', "", ['class' => 'form-control', 'id' => 'character_title','placeholder'=>'Enter Character Name']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit(Lang::get('admin/character.update'),['class' => 'btn btn-primary'])!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection