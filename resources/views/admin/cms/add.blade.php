@extends('admin.master')

@section('title', __('admin/cms.cms'))

@section('js')
    <!-- DataTables JavaScript -->
    <script src="{{URL::to('admin/vendor/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function () {
            @if($cms->id !=5 && $cms->id != 6 && $cms->id != 8  && $cms->id != 7 && $cms->id != 9)
            CKEDITOR.replace('value[2]', {
                contentsLangDirection: 'rtl'
            }).on('change', function () {
                $("#value2").valid();
            });
            CKEDITOR.replace('value[1]').on('change', function () {
                $("#value1").valid();
            });
            @endif

            $('#cms-form').validate({
                rules: {
                    @if($cms->id !=5 && $cms->id != 6 && $cms->id != 8  && $cms->id != 7 && $cms->id != 9)
                    'value[1]': {
                        required: function () {
                            return CKEDITOR.instances.value1.updateElement();
                        }
                    },
                    'value[2]': {
                        required: function () {
                            return CKEDITOR.instances.value2.updateElement();
                        }
                    }
                    @endif
                },
                messages: {
                    'value[1]': '@lang('admin/cms.cms_content_msg')',
                    'value[2]': '@lang('admin/cms.cms_content_msg')'
                },
                ignore: []
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$cms->title}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('admin/cms.edit_cms')
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {!! Form::open(['url' => url('Admin/cms/'.$cms->id), 'id' => 'cms-form']) !!}

                                <div class="form-group">

                              
                                    {!! Form::label(__('admin/cms.url')) !!}
                                    {!! Form::text('value[1]','',['class'=>'form-control']) !!}

                                </div>

                            {!! Form::button(__('admin/cms.save'),['type'=>'submit','class'=>'btn btn-success']) !!}
                            {!! link_to(url('Admin/cms'), __('admin/area.back'), ['class' => 'btn btn-default']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection