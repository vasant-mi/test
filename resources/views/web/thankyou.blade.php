<html lang="{{App::getLocale()}}">
<link href="{{URL::to('Postcardweb/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{URL::to('Postcardweb/css/custom.css')}}" rel="stylesheet">

<section class="reset-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <div class="logo-left">
                    {{--<img src="http://magentodevelopments.com/Designer/copomap-email/images/app-icon.png">--}}
                    <span>@lang('web/master.smasher_text')</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="row">
        <div class="reset-password-main">
            <div class="col-md-12 p-0">
                @if($type != 'success')
                <div class="success-main">
                    <img src="public/web/images/failure-icon.svg">
                    <h1>{{$title}}</h1>
                    <p>{{$message}}</p>
                </div>
                @else
                <div class="success-main">
                    <img src="public/web/images/success-icon.svg">
                    <h1>{{$title}}</h1>
                    <p>{{$message}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script src="{{URL::to('Postcardweb/js/jquery.js')}}"></script>
<script src="{{URL::to('Postcardweb/js/bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            window.location.href = '{{url('share/login')}}';
        }, 3000)
    });
</script>
</html>