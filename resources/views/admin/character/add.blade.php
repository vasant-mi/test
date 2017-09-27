@extends('admin.master')

@section('title', 'Language')


@section('content')
    @php $mode = $characterData ? "Edit" : "Add"; @endphp

   {{-- @if($characterData)
        @php($range_id = $characterData->range_id )
        @php($team_id = $characterData->team_id )
        @php($rarity_id = $characterData->rarity_id)
        @php($series_id = $characterData->series_id )
        @php($found_id = $characterData->found_in )
    @else
        @php($range_id = '')
        @php($team_id = '')
        @php($rarity_id = '' )
        @php($series_id = '')
        @php($found_id = '')
    @endif
--}}


    @php($range_id = $characterData != ''? $characterData->range_id:'' )
    @php($team_id = $characterData != ''? $characterData->team_id:'' )
    @php($rarity_id = $characterData !=''? $characterData->rarity_id:'')
    @php($series_id = $characterData !=''? $characterData->series_id:'' )
    @php($found_id = $characterData !='' ? $characterData->found_in:'' )

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $mode }} Character</h1>
        </div>
    </div>
    <div class="row" style="padding: 0px 0px 20px 0px;">
        <div class="col-lg-12">
            <a href="{{URL::to('Admin/character')}}">Character</a> >> <span>{{ $mode }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-horizontal">

                        {!! Form::open(['url' => url('Admin/character/save'), 'id' => 'character-form' , 'method' => 'post','enctype' => 'multipart/form-data']) !!}


                        <input type="hidden" class="form-control " name="character_id"
                               value="{{ $characterData ? $characterData->id : '' }}">

                        <div class="form-group">
                            {!! Form::label('Character Name', NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('name', $characterData ? $characterData->name : "", ['class' => 'form-control', 'id' => 'character_name','placeholder'=>'Enter Character Name']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Character Image',NULL,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <input type="file" name="image" id="addImage" value="{{ $characterData ? $characterData->image : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('',NULL,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <div class="image-wrapper"></div>
                                @if($characterData != '')
                                <img class="last_image" src="{{$characterData ? \App\Character::imageURL($characterData->image) : ""}}" height="100" width="100">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Character Code',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {!! Form::number('code', $characterData ? $characterData->code : "", ['class' => 'form-control', 'id' => 'code','placeholder'=>'Enter Character Code']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Range',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <select  name="range_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($range as $rg)
                                        <option value="{{ $rg->id }}" {{$range_id == $rg->id ? 'selected' : '' }}>{{ $rg->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Series',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <select  name="series_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($series as $s)
                                        <option value="{{ $s->id }}" {{ $series_id == $s->id ? 'selected' : '' }} >{{ $s->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Team',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <select  name="team_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($team as $t)
                                        <option value="{{ $t->id }}" {{ $team_id == $t->id ? 'selected' : '' }}>{{ $t->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Rarity',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <select  name="rarity_id" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($rarity as $r)
                                        <option value="{{ $r->id }}" {{ $rarity_id == $r->id ? 'selected' : '' }} >{{ $r->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Finish', NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('finish', $characterData ? $characterData->finish : "", ['class' => 'form-control', 'id' => 'finish','placeholder'=>'Enter Finish']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Character Bio', NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {{ Form::textarea('character_bio', $characterData ? $characterData->character_bio : "", ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Value', NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {{ Form::text('value', $characterData ? $characterData->value : "", ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Found In',NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                <select id="mySelect" name="found_in[]" class="form-control multiselect-ui" multiple="multiple">
                                    @foreach ($found as $f)
                                        <option value="{{ $f->id }}" {{  in_array($f->id , $foundSelected)  ? 'selected' : '' }} >{{ $f->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Only available in', NULL ,['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-6">
                                {{ Form::textarea('available_only', $characterData ? $characterData->available_only : "", ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2">
                                {!! Form::submit(__('admin/character.submit'), ['class' => 'btn btn-success s-btn-success']) !!}
                                {!! link_to(url('Admin/character'), __('admin/character.back'), ['class' => 'btn btn-default']) !!}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
@endsection
@section('js')
    <!-- DataTables JavaScript -->
    <script src="{{URL::to('admin/vendor/bootstrap/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{URL::to('admin/dist/js/select2.js')}}"></script>
    <script src="{{URL::to('admin/dist/js/jquery.validate.min.js')}}"></script>
    <script>
        /*$(document).ready(function() {
            $('#mySelect').multiselect({
                noneSelectedText: 'Select Something (required)',
                selectedList: 3,
                classes: 'my-select'
            });

            $('#myForm').validate({
                rules: {
                    mySelect: "required needsSelection",
                },
                ignore: ':hidden:not("#mySelect")', // Tells the validator to check the hidden select
                errorClass: 'invalid'
            });
        });*/
        $(document).ready(function () {
            var mode = '{{$mode}}'
            $(document).ready(function() {
                $('#mySelect').multiselect();
            });

            $('#mySelect').change(function () {
                $('#mySelect').valid();
            })

            $('#character-form').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                },
                rules: {
                    name: {
                        required: true
                    },
                    image: {
                        required: (mode == 'Add') ? true : false
                    },
                    code:{
                        required: true
                    },
                    team_id:{
                        required :true
                    },
                    series_id:{
                        required :true
                    },
                    range_id:{
                        required :true
                    },
                    rarity_id:{
                        required :true
                    },
                    finish:{
                        required :true
                    },
                    character_bio:{
                        required :true
                    },
                    value:{
                        required :true
                    },
                    "found_in[]": "required",
                    mySelect: "required needsSelection",
                },
                ignore: ':hidden:not("#mySelect")', // Tells the validator to check the hidden select
                messages: {
                    name: {
                        required: "Please enter character name."
                        // lettersonly: "Please enter character only."
                    },
                    code:{
                        required: "Please enter character code."
                    },
                    image:{
                        required: "Please select image."
                    },
                    team_id:{
                        required:"Please select team."
                    },
                    series_id:{
                        required:"Please select series."
                    },
                    range_id:{
                        required:"Please select range."
                    },
                    rarity_id:{
                        required:"Please select rarity."
                    },
                    finish:{
                        required:"Please enter finish."
                    },
                    character_bio:{
                        required:"Please enter character bio."
                    },
                    value:{
                        required:"Please enter value."
                    },
                    "found_in[]":{
                        required:"Please select found in package."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });



            $('#addImage').on('change', function (evt) {

                $(".last_image").css("display",'none');
                var selectedImage = evt.currentTarget.files[0];
                var imageWrapper = document.querySelector('.image-wrapper');
                var theImage = document.createElement('img');
                imageWrapper.innerHTML = '';

                var regex = /(.jpg|.jpeg|.gif|.png|.bmp)$/;
                if (regex.test(selectedImage.name.toLowerCase())) {
                    if (typeof(FileReader) != 'undefined') {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            theImage.id = 'new-selected-image';
                            theImage.src = e.target.result;
                            imageWrapper.appendChild(theImage);
                        }
                        //
                        reader.readAsDataURL(selectedImage);
                    } else {
                        //-- Let the user knwo they cannot peform this as browser out of date
                        console.log('browser support issue');
                    }
                } else {
                    //-- no image so let the user knwo we need one...
                    $(this).prop('value', null);
                    console.log('please select and image file');
                    $(".image-wrapper").html('File formate is not valid');

                }

            });

        });
    </script>
@endsection

@section('css')
    <!-- DataTables Responsive CSS -->
    <link href="{{URL::to('admin/vendor/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet"  href="{{URL::to('admin/dist/css/select2.css')}}">

    <style>
        .wrapper {
            padding: 25px;
        }

        .image-wrapper {
            padding: 5px;
            height: auto;
            width: 200px;
            font-weight: 700;
            color: red;
        }

        .image-wrapper img {
            max-width: 200px;
        }
    </style>
@endsection

{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>--}}
