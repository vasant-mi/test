@extends('admin.master')

@section('title', 'Language')

@section('js')
		<!-- DataTables JavaScript -->
<script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
<script>
	$(document).ready(function () {
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        });

        $('#series-form').validate({
            rules: {
				title: {
                    required: true
					//lettersonly: true
                }
            },
            messages: {
				title: {
                    required: "Please enter series name."
                   // lettersonly: "Please enter character only."
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

@endsection

@section('css')
		<!-- DataTables Responsive CSS -->
		<link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">

@endsection

@section('content')
    @php $mode = $seriessData ? "Edit" : "Add"; @endphp


	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{{ $mode }} @lang('admin/series.title')</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
                    {{ $mode }} @lang('admin/series.title')
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							{!! Form::open(['url' => url('Admin/series/save'), 'id' => 'series-form' , 'method' => 'post']) !!}
								<input type="hidden" class="form-control" name="series_id" value="">

							<div class="form-group">
								{!! Form::label('Series Name') !!}
								{!! Form::text('title', $seriessData ? $seriessData->title : "", ['class' => 'form-control seriesInput', 'id' => 'title','placeholder'=>'Enter Series Name']) !!}
							</div>

							<div class="form-group">
								{!! Form::submit(__('admin/series.submit'), ['class' => 'btn btn-success']) !!}
								{!! link_to(url('Admin/series'), __('admin/series.back'), ['class' => 'btn btn-default']) !!}
							</div>

							{!! Form::close() !!}
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
@endsection