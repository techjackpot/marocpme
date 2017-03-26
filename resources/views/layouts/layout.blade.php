<?php
$else=false;
if (strpos(Request::url(), 'users') !== false) {
    $mobileB="Utilisateurs";
    $icon=asset('img/userBr.png');
    $activeIcon='img/user_2.png';
}
else if (strpos(Request::url(), 'profile') !== false) {
    $mobileB='Mon Profile';
    $icon=asset('img/calque-29.png');
    $activeIcon='img/calque-20.png';
}
else if (strpos(Request::url(), 'prospects') !== false) {
    $mobileB='Prospects';
    $icon=asset('img/forma-1-copie-2.png');
    $activeIcon='img/forma-1-copie.png';
}
else if (strpos(Request::url(), 'calendar') !== false) {
    $mobileB='Agenda';
    $icon=asset('img/calque-21.png');
    $activeIcon='img/calque-19.png';
}
else{
    $mobileB='Mon Profile';
    $icon=asset('img/calque-29.png');
    $activeIcon='img/calque-20.png';
    $else=true;
}
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Maroc PME</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('packages/bootstrap/dist/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <link href="{{asset('packages/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('packages/clockpicker/dist/bootstrap-clockpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/jquery-ui-1.12.1.custom/jquery-ui.css')}}">

    <link rel="shortcut icon" href="{{ asset('logo_ico.png') }}">

@yield('styles')
</head>
<body>

<div id="header">
</div>

<div id="breadcrumb"> <a href="#"><img src="{{$icon}}" > {{$mobileB}}</a></div>

<div id="user-nav" class="navbar navbar-inverse">
    <a href="{{url('/profile')}}" ><img title="Mon Profile" class="tip-bottom" src="{{asset('img/profile.png')}}" alt=""></a>
    <a href="{{ url('/logout') }}"
       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" ><img title="Déconnecter" class="tip-bottom" src="{{asset('img/logout.png')}}" alt=""></a>
</div>
<div id="search">
    <input type="text" class="search-box" placeholder="Recherche par mots clés"/>
    <button type="submit" class="tip-bottom" title="Search"><img src="{{asset('img/magnifier-tool.png')}}" ></button>
</div>
<div id="sidebar">
    <a class="brandD" href="#"><img src="{{asset('img/calque-18.png')}}" alt=""></a>

    <a href="#" class="visible-phone"><img src="{{$icon}}" alt=""> <?php echo $mobileB; ?></a>


    <ul>

        <li class="{{ strpos(Request::url(), 'profile') !== false||$else==true ? 'active' : '' }}"><a href="{{url('/profile')}}"><img src="{{asset(strpos(Request::url(), 'profile') !== false || $else==true ? $activeIcon : 'img/MyProf.png') }}" alt=""> <span>Mon Profile</span></a> </li>
        @if(Illuminate\Support\Facades\Auth::user()->isAdmin=='heIs')
        <li class="{{ strpos(Request::url(), 'users') !== false ? 'active' : '' }}"> <a href="{{url('/users/list')}}"><img src="{{asset(strpos(Request::url(), 'users') !== false ? $activeIcon : 'img/user.png')}}" alt=""> <span>Utilisateurs</span></a> </li>
        @endif
            <li class="{{ strpos(Request::url(), 'prospects') ? 'active' : '' }}"> <a href="{{url('/prospects')}}"><img src="{{asset(strpos(Request::url(), 'prospects') !== false ? $activeIcon : 'img/visiteurs.png')}}" alt=""> <span>Prospects</span></a> </li>
        <li class="{{strpos(Request::url(), 'calendar') !== false ? 'active' : '' }}"> <a href="{{url('/calendar')}}"><img src="{{asset(strpos(Request::url(), 'calendar') !== false ? $activeIcon : 'img/calque-19_2.png')}}" alt=""> <span>Agenda</span></a> </li>
        <li>
        <a href="{{ url('/logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <img src="{{asset('img/deconn.png')}}" > <span>Déconnexion</span>
        </a>
        </li>


    </ul>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</div>


@yield('content')





<script src="{{asset('packages/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('packages/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('packages/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('packages/clockpicker/dist/bootstrap-clockpicker.min.js')}}"></script>

<script src="{{asset('js/script.js')}}"></script>
@yield('scripts')


</body>
</html>