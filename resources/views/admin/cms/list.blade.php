@extends('admin.master')

@section('title', __('admin/cms.cms'))

@section('js')
    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
    <script>
        var ACTIVE = parseInt('{{\App\Status::$ACTIVE}}');
        var INACTIVE = parseInt('{{\App\Status::$INACTIVE}}');
        $(document).ready(function () {
            $('.toggleCms').change(function () {
                var l = Ladda.create(this);
                var status = ($(this).is(':checked') ? ACTIVE : INACTIVE);
                l.start();
                $.ajax({
                    url: '{{url('Admin/cms/change-status')}}',
                    data: {
                        status: status,
                        id: $(this).attr('data-id'),
                        _token: '{{csrf_token()}}'
                    },
                    method: 'POST',
                    success: function (response) {
                        l.stop();
                        if(response.status != '200'){
                            showMessage('danger', response.message)
                        } else {
                            if(status == 1) {
                                showMessage('success', ['@lang('admin/cms.cms_active_successfully')']);
                            } else {
                                showMessage('success', ['@lang('admin/cms.cms_inactive_successfully')']);
                            }
                        }
                    }
                });
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
        <div class="col-lg-12">
            <h1 class="page-header">@lang('admin/cms.cms')</h1>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('admin/cms.cms_list')
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover brdr-top-tbl-mi">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('admin/cms.title')</th>
                        <th>@lang('admin/cms.description')</th>
                        <th>@lang('admin/cms.status')</th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cmss as $key => $cms)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$cms->title}}</td>
                            <td>{{$cms->cms_desc}}</td>
                            <td align="center">
                                <label class="checkbox-inline checkbox-inline-bg">
                                    {!! Form::checkbox('', '', $cms->status_id == \App\Status::$ACTIVE, ['data-toggle' => 'toggle', 'data-on' => 'Active', 'data-off' => 'Inactive', 'class' => 'toggleCms', 'data-id' => $cms->id]) !!}
                                </label>
                            </td>
                            <td align="center">
                                {!! link_to(url('Admin/cms',$cms->id), __('admin/cms.edit'), ['class' => 'btn btn-primary']) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" align="center">@lang('admin/cms.no_cms')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection