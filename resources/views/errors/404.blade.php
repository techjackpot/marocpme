<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vous étes perdu</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo_ico.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body{
            background-color: #fff;
            font-family: 'Rubik', sans-serif;
        }
p span{
    font-size: 16.5px;
    line-height: 1.09;
    font-weight: bold;
}
        p {

            font-size: 14px;
            font-weight: normal;
            line-height: 1.5;
            letter-spacing: normal;
            color: #6a6a6a;

        }
        .button {
            position: relative;
            width: 133.5px;
            display: block;
            margin: 20px auto;
            padding: 12px 24px;
            vertical-align: middle;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            line-height: 20px;
            -webkit-font-smoothing: antialiased;
            text-align: center;
            letter-spacing: 1px;
            cursor: pointer;
            background-image: linear-gradient(93deg, #97c940, #429321);
            border-radius: 31px;
            transition: all 1s ease-in-out;
        }

        .content{

            padding: 100px 25%;
            text-align: center;
        }

.content h2{
    margin-bottom: 11px;
    line-height: 1.2;
    color: #1c68a2;
}

        .content img{
            width: 100%;
            height: 100%;
        }


    </style>
</head>
<body>

<div class="content">
    <h2>On vous l’avait bien dit ... Il n’y a rien ici!</h2>
    <p><span>Ooooooops...</span> il semble que la page que vous recherchez n’existe pas.</p>
    <a href="{{ route('profil')}} " type="button" class="button">
Retour
    </a>
    <img src="{{asset('img/404img.png')}}" alt="404">


</div>
</body>