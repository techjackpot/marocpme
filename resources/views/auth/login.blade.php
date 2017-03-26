<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('logo_ico.png') }}">
    <title>Maroc PME</title>

    <link rel="stylesheet" href="{{asset('packages/bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/customAnimations.css')}}">
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
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Quelques problèmes avec l'authentification<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <form id="loginForm" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}



    <div class="group">
        <img src="{{asset('img/calque-24.png')}}" alt="">
    </div>
    <div class="group {{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" name="email" value="{{ old('email') }} "><span class="highlight"></span><span class="bar"></span>
        <label>Email</label>
        @if ($errors->has('email'))
            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
        @endif

    </div>
    <div class="group {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" name="password"><span class="highlight"></span><span class="bar"></span>
        <label>Mot de passe</label>
        <a id="forgotMyPass" href="#">Mot de passe oublié?</a>

        @if ($errors->has('password'))
            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
        @endif
    </div>

    <button type="submit" class="button loginB">Connexion

    </button>

</form>


    <form id="loginFormForgot" class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">

        {{ csrf_field() }}


        <div class="group">
            <img src="{{asset('img/calque-24.png')}}" alt="">
        </div>
        <div class="group {{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" name="email" value="{{ old('email') }} "><span class="highlight"></span><span class="bar"></span>
            <label>Email</label>
            @if ($errors->has('email'))
                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
            @endif

        </div>
        <button type="submit" class="button loginB">Envoyer

        </button>
        <a href="#" id="forgotMyPassBack" style="width: 200px;
position: relative;
float: right;
right: 30px;"><img src="{{asset('img/left-arrow-1.png')}}" alt=""></a>
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

    $('#forgotMyPass').click(function (e) {

e.preventDefault();
        $("#loginFormForgot").addClass("In");
            $("#loginForm").addClass("Out");
        $("#loginForm").fadeOut("slow", function() {
            $("#loginFormForgot").fadeIn("slow");
        });

    });
    $('#forgotMyPassBack').click(function () {
        $("#loginFormForgot").fadeOut("slow", function() {
            $("#loginForm").fadeIn("slow");
        });

    })



</script>
</body>
</html>

































