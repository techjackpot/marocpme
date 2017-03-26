<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Maroc PME</title>

    <link rel="stylesheet" href="{{asset('packages/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/customAnimations.css')}}">
    <link rel="shortcut icon" href="{{ asset('logo_ico.png') }}">
    <style>

        body{
            background: url("{{asset('img/groupe-4.jpg')}}") repeat  100% 100%;
            background-size: cover;
            background-attachment: fixed;

        }
        @media screen and (max-width: 768px){
            body{
                overflow:auto;
            }
        }
    </style>
</head>
<body>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form id="resetPassword" class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">



    <div class="group">
        <img src="{{asset('img/calque-24.png')}}" alt="">
    </div>
    <div class="group {{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" name="email" value="{{ $email or old('email') }}"><span class="highlight"></span><span class="bar"></span>
        <label>Email</label>
        @if ($errors->has('email'))
            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
        @endif

    </div>
    <div class="group {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" name="password" ><span class="highlight"></span><span class="bar"></span>
        <label>Mot de passe</label>

        @if ($errors->has('password'))
            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
        @endif
    </div>

    <div class="group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">


            <input id="password-confirm" type="password" name="password_confirmation" ><span class="highlight"></span><span class="bar"></span>

        <label>Confirmer Mot de passe</label>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
            @endif

    </div>
    <button type="submit" class="button loginB">Réinitialiser mon mot de passe

    </button>

</form>




<script src="{{asset('packages/jquery/dist/jquery.js')}}"></script>
<script>
    $(window, document, undefined).ready(function() {

        $('.group input').val('');
        $('.group input').on('blur change',function() {
            var $this = $(this);
            if ($this.val())
                $this.addClass('used');
            else
                $this.removeClass('used');
        });

    });

</script>
</body>
</html>