@extends('admin.master')

@section('title', __('admin/users.users'))



@section('css')
    <link href="{{URL::to('admin/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">@lang('admin/users.user_manage')</h1>
        </div>
        <div class="col-lg-12">
            <div class="pull-right">
                {{ Form::button('Delete', array('class' => 'btn btn-danger deleteAll')) }}
                <a href="{{url('Admin/users/exportExcelFile')}}" class="btn btn-success" id="exportExcel"
                   type="button">@lang('admin/admin.export_to_excel')</a>
            </div>
        </div>
    </div>
<br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-smasher">
                <div class="panel-heading">
                    @lang('admin/users.users_list')
                </div>


                <form class="form-inline search-main">
                    <div class="form-group sea-left">
                        <label>@lang('admin/users.per_page')</label>
                        <select name="per_page" class="form-control" onchange="getPaginationVal(this.value)">
                            @foreach(Config::get('admin.per_page_array') as $p)
                                <option value="{{$p}}" {{$p == $users->perPage() ? 'selected="selected"' : ''}}>{{$p}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="sorting" value="{{$sort}}" >
                        <input type="hidden" name="field" value="{{$field}}" >
                    </div>
                    <div class="form-group sea-right pull-right">
                        <form class="form-inline" method="get" >
                            <input type="text" name="search_field" class="form-control" value="{{ app('request')->input('search_field') ? app('request')->input('search_field') : '' }}" id="exampleInputName2" placeholder="Search here">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" onclick="backToMain()" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                    {{--<div class="form-group col-md-5 text-right">--}}
                    {{--<button class="btn btn-primary" type="submit">@lang('admin/range.apply')</button>--}}
                    {{--<button class="btn btn-primary" id="exportExcel" type="button">Export to Excel</button>--}}
                    {{--<a class="btn btn-default" href="{{url()->current()}}">@lang('admin/range.reset')</a>--}}
                    {{--</div>--}}
                </form>


                <div class="table-responsive">
                    <table id="records_table" class="table table-striped table-bordered table-hover brdr-top-tbl-mi">
                        <thead>
                        <tr>
                            <th class="text-center">{{ Form::checkbox('usersBox', 1, null, ['class' => 'field', 'id'=>'select_all']) }}</th>
                            <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=username&per_page={{$per_page}}">Username</a></th>
                            <th class="text-center"><a href="?sorting={{($sort == "desc" ? "asc" : "desc")}}&field=email&per_page={{$per_page}}">Email</a></th>
                            <th class="text-center">Parent's Email</th>
                            <th class="text-center">DOB</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">#Own</th>
                            <th class="text-center">#Want</th>
                            <th class="text-center">Own SPV</th>
                            <th class="text-center">Want SPV</th>
                            <th class="text-center">Country</th>
                            <th class="text-center">Newsletter</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($users as $key => $user)
                            <tr>
                                <td align="center">{{ Form::checkbox('usersBox', 1, null, ['class' => 'field checkbox','data-id' => $user->id]) }}</td>
                                <td class="text-center">{{$user->username}}</td>
                                <td class="text-center">{{$user-> email}}</td>
                                <td class="text-center">{{$user->parent_email}}</td>
                                <td class="text-center">{{ date('d M Y', strtotime($user->date_of_birth)) }} </td>
                                <td class="text-center">{{\App\User::userAge($user->date_of_birth)}}</td>
                                <td class="text-center">{{$user->countOfCharacter('own')}}</td>
                                <td class="text-center">{{$user->countOfCharacter('want')}}</td>
                                <td class="text-center">${{$user->sumOfCharacter('own')}}</td>
                                <td class="text-center">${{$user->sumOfCharacter('want')}}</td>
                                <td class="text-center">{{$user->country_name}}</td>
                                {{-- <td align="center">
                                     <label class="checkbox-inline checkbox-inline-bg">
                                         {!! Form::checkbox('', '', $user->status_id == \App\Status::$ACTIVE, ['data-toggle' => 'toggle', 'data-on' => 'Verified', 'data-off' => 'Unverified', 'class' => 'toggleCharacter', 'data-id' => $user->id]) !!}
                                     </label>
                                 </td>--}}
                                <td class="text-center">{{$user->newsletter}}</td>
                                <td class="text-center">{{$user->status_id == '1' ? 'Verified': 'Unverified'}}</td>
                                <td align="center">
                                    {{--<button type="button" class='btn btn-primary'--}}
                                    {{--onclick="window.location='{{ url("Admin/users/add/$user->id") }}'">Edit--}}
                                    {{--</button>--}}
                                    {{ Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger deleteThis','data-id' => $user->id]) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" align="center">@lang('admin/users.no_users')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{--<div class="panel-footer">--}}
                {{--{!! \App\Admin\AdminController::pagination($users) !!}--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

@endsection
@section('js')

    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>

    <script>

        var ACTIVE = parseInt('{{\App\Status::$ACTIVE}}');
        var INACTIVE = parseInt('{{\App\Status::$INACTIVE}}');

        function getPaginationVal(val) {
            window.location = window.location.pathname+'?per_page='+val;
        }

        function backToMain() {
            window.location = window.location.pathname;
        }

        $(document).ready(function () {

            $('.toggleCharacter').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/users/change-status')}}',
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
                                showMessage('success', ['@lang('admin/users.users_active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/users.users_inactive_successfully')']);
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
                modal.find('.modal-body #users_title').val(title);
                modal.find('.modal-body #users_id').val(id);
            })

            $(".deleteThis").click(function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    title:"Delete",
                    text: "Are you sure you want to delete this user?",
                    type: "warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true
                }).then(function () {
                    $.ajax({
                        type: "POST",
                        url: "{{url('Admin/users/destroy')}}",
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
                                    window.location.href = '{{ url('Admin/users/list') }}';
                                }, 500);
                            }

                        }
                    });
                });
            });


            $(".deleteAll").click(function (e) {

                var checkValues = $('input[name=usersBox]:checked').map(function () {
                    return $(this).attr('data-id');
                }).get();

                if (checkValues == '') {
                    swal({
                        title: "Delete",
                        text: "Please select at-least one user",
                        type: "warning"
                    });
                } else {

                    e.preventDefault();
                    swal({
                        title: "Delete",
                        text: "Are you sure you want to delete all users?",
                        type: "warning",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        showCancelButton: true
                    }).then(function () {
                        $.ajax({
                            type: "POST",
                            url: "{{url('Admin/users/destroyAll')}}",
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
                                        window.location.href = '{{ url('Admin/users/list') }}';
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