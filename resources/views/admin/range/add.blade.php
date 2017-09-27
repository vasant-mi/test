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

        $('#range-form').validate({
            rules: {
				range_name: {
                    required: true
					//lettersonly: true
                }
            },
            messages: {
				range_name: {
                    required: "Please enter range name."
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
    @php $mode = $rangesData ? "Edit" : "Add"; @endphp


	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{{ $mode }} Range</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
                    {{ $mode }} Range
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							{!! Form::open(['url' => url('Admin/range/save'), 'id' => 'range-form' , 'method' => 'post']) !!}
								<input type="hidden" class="form-control" name="range_id" value="">

							<div class="form-group">
								{!! Form::label('Range Name') !!}
								{!! Form::text('range_name', $rangesData ? $rangesData->range_name : "", ['class' => 'form-control rangeInput', 'id' => 'range_name','placeholder'=>'Enter Range Name']) !!}
							</div>

							<div class="form-group">
								{!! Form::submit(__('admin/range.submit'), ['class' => 'btn btn-success']) !!}
								{!! link_to(url('Admin/range'), __('admin/range.back'), ['class' => 'btn btn-default']) !!}
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