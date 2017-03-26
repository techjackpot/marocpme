@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">
    <style>
        .container-fluid [class*="col-"] {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
@endsection
@section('content')
    <div id="content">


        <div class="container-fluid" style="padding: 0 70px;">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-sm-6 col-sm-offset-6">
                    <button class="loginB buttonAddGue" data-toggle="modal" data-target="#newProsp"><span>Ajouter nouveau prospect </span></button>
                </div>
            </div>

            <form action="" method="post" role="form" id="formProspect">
                {{csrf_field()}}
                {{ method_field('PUT') }}
            <div class="row" >
                <div class="col-xs-12 col sm-12 col-md-12 col-lg-12" style="margin-top: 40px;">
                    <div class="alert alert-danger" id="resp" style="display: none"></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                        <div class="Pcard">
                            <div class="Phead">
                                <h3>Informations personnelles</h3>
                            </div>
<div class="Pbody">

        <div class="form-group">
            <label for="nomP">Nom</label>
            <input type="text" class="form-control" name="nomP" id="nomP" value="{{$prospect->nom}}">
            <div class="bar"></div>
        </div>
        <div class="form-group">
            <label for="prenomP">Prénom</label>
            <input type="text" class="form-control" name="prenomP" id="prenomP" value="{{$prospect->prenom}}">
            <div class="bar"></div>
        </div>
        <div class="form-group">
            <label for="fonctionP">Fonction</label>
            <input type="text" class="form-control" name="fonctionP" id="fonctionP" value="{{$prospect->fonction}}">
            <div class="bar"></div>
        </div>
        <div class="form-group">
            <label for="mailP">Mail</label>
            <input type="email" class="form-control" name="mailP" id="mailP" value="{{$prospect->mail}}">
            <div class="bar"></div>
        </div>
        <div class="form-group">
            <label for="telP">Tel</label>
            <input type="text" class="form-control" name="telP" id="telP" value="{{$prospect->tel}}">
            <div class="bar"></div>
        </div>

    <label class="sexProspt">
        <img src="{{$prospect->sex=='M'?asset('img/H.png'):asset('img/F.png')}}" alt="">

        {{$prospect->sex=='M'?'Homme':'Femme'}}
    </label>
        <div class="row sexSection">
            <div class="col-sm-6">

                <div class="radio">
                    <label for="h">
                        <img src="{{asset('img/H.png')}}" alt="">
                    </label>
                    <label>

                        <input type="radio" value="M" name="sexP" id="h" {{$prospect->sex=='M'?'checked':''}}>
                        Homme
                        <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="radio">
                    <label for="f">
                        <img src="{{asset('img/F.png')}}" alt="">
                    </label>
                    <label>
                        <input type="radio" value="F" name="sexP" id="f" {{$prospect->sex=='F'?'checked':''}}>
                        Femme
                        <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                    </label>
                </div>
            </div>
        </div>
</div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                        <div class="Pcard">
<div class="Phead">
<h3>Informations société</h3>
</div>
                            <?php if(strpos(Request::url(), 'detail') !== false){ ?>
                            <a href="#" id="editForm" style="position: absolute; top: -15px;right: -15px"><img src="{{asset('img/editProsp.png')}}" alt=""></a>
                            <?php } ?>

                            <div class="Pbody">

                                    <div class="form-group">
                                        <label for="RSP">Raison social</label>
                                        <input type="text" class="form-control" name="RSP" id="RSP" value="{{$prospect->RS}}">
                                        <div class="bar"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dateCP">Date de création</label>
                                        <input type="text" class="form-control datePicker" name="dateCP" id="dateCP" value="{{$prospect->dateCreation}}">
                                        <div class="bar"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="activP">Activité</label>
                                        <input type="text" class="form-control" name="activP" id="activP" value="{{$prospect->activite}}">
                                        <div class="bar"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="secteurP">Secteur</label>
                                        <input type="text" class="form-control" name="secteurP" id="secteurP" value="{{$prospect->secteur}}">
                                        <div class="bar"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="villeP">Ville</label>
                                        <input type="text" class="form-control" name="villeP" id="villeP" value="{{$prospect->ville}}">
                                        <div class="bar"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="faxP">Fax</label>
                                        <input type="text" class="form-control" name="faxP" id="faxP" value="{{$prospect->fax}}">
                                        <div class="bar"></div>
                                    </div>

                                    <div class="form-group chiffre">
                                        <label for="chiffAff">Chiffre d’affaire</label>
                                        <input type="text" class="form-control" name="chiffAff" id="chiffAff" value="{{$prospect->chiffreAff=='zT' ?'De 0 à 10 MDH':'De 10 à 200 MDH'}}">
                                        <div class="bar"></div>


                                    </div>
                                <div class="row upChiffre">
                                    <div class="col-sm-6">

                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="zt" name="ztT" {{$prospect->chiffreAff=='zT'?'checked':null}}>
                                                De 0 à 10 MDH
                                                <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="tTH" name="ztT" {{$prospect->chiffreAff=='tTH'?'checked':null}}>
                                                De 10 à 200MDH
                                                <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>




                </div>
            </div>

<div class="row">
    <div class="col-xs-12 col sm-12 col-md-12 col-lg-12">
        <div class="Pcard">
            <div class="Phead">
                <h3>Objets de la rencontre</h3>
            </div>
            <div class="Pbody">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$prospect->imtiaz}}" name="imtiaz" {{$prospect->imtiaz=="1"?'checked':null}} >
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Imtiaz
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="moussanada" value="{{$prospect->imtiaz}}" {{$prospect->moussanada=="1"?'checked':null}}>
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Moussanada
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tahfiz" value="{{$prospect->tahfiz}}" {{$prospect->tahfiz=="1"?'checked':null}}>
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Tahfiz
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="istitmar" value="{{$prospect->istitmar}}" {{$prospect->istitmar=="1"?'checked':null}}>
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Istitmar
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$prospect->systemeInfo}}" {{$prospect->systemeInfo=="1"?'checked':null}} name="systInfo">
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Système d'information
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$prospect->startUp}}" {{$prospect->startUp=="1"?'checked':null}} name="startUp">
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Start Up
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$prospect->consultance}}" {{$prospect->consultance=="1"?'checked':null}} name="consultance">
                                    <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                    Consultance
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <h5 style="color: #126388;font-size: 18px;margin-bottom: 40px ;display: inline-block;">Detail rendez-vous</h5>
                    <div class="form-group">
                        <label for="inpPros">Prospect</label>
                        <input type="text" class="form-control" name="ProspeM" id="inpPros" value="aaa@sada.com">
                        <div class="bar"></div>
                    </div>
                    <div class="form-group">
                        <label for="appDate">Date</label>
                        <input type="text" class="form-control datePicker" name="" id="appDate" value="22-21-2222">
                        <div class="bar"></div>
                    </div>
                    <div class="form-group">
                        <label for="inpHour">Heure</label>
                        <input type="text" class="form-control inpHour" name="" id="appHour" value="12:30">
                        <div class="bar"></div>

                    </div>
                    <div class="form-group">
                        <label for="appEmp">Emplacement</label>
                        <input type="text" class="form-control" name="" id="appEmp" value="Marrakesh">
                        <div class="bar"></div>
                    </div>
                    <div class="form-group">
                        <label for="inpN">Note</label>
                        <textarea name="noteM" id="inpN" cols="30" rows="10" style="height:150px;"></textarea>
                        <div class="bar"></div>
                    </div>



            </div>
        </div>
        <div class="col-sm-offset-11 col-sm-1 col-md-offset-11 col-md-1">
            <button type="submit" class="loginB buttonAddGue" id="regisUpd" style="float: right;">Enregistrer</button>
        </div>

    </div>

</div>


            </form>





        </div>

        <div class="modal fade" id="newProsp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: url('{{asset("img/calque-38.png")}}')">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                        </button>
                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('img/id-card-copie.png')}}" alt="" style="margin-right: 10px;">Ajouter un nouveau prospect</h4>

                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#infoPerso" aria-controls="infoPerso" role="tab" data-toggle="tab">Informations personnelles</a></li>
                                            <li role="presentation"><a href="#infoSoci" aria-controls="infoSoci" role="tab" data-toggle="tab">Informations société</a></li>
                                            <li role="presentation"><a href="#objRenc" aria-controls="objRenc" role="tab" data-toggle="tab">Objets de la rencontre</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="alert alert-danger" id="response" style="display: none"></div>

                                            <div role="tabpanel" class="tab-pane active" id="infoPerso">
                                                <form id="InfoPerso" action="" method="post" role="form">
                                                    <div class="form-group">
                                                        <label for="ProsNom">Nom</label>
                                                        <label style="float: right;">*</label>
                                                        <input type="text" class="form-control" name="ProsNom" id="ProsNom">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsPrenom">Prénom</label>
                                                        <label style="float: right;">*</label>
                                                        <input type="text" class="form-control" name="ProsPrenom" id="ProsPrenom">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsFonction">Fonction</label>
                                                        <input type="text" class="form-control" name="ProsFonction" id="ProsFonction">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsMail">Mail</label>
                                                        <label style="float: right;">*</label>
                                                        <input type="email" class="form-control" name="ProsMail" id="ProsMail">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsTel">Tel</label>
                                                        <input type="text" class="form-control" name="ProsTel" id="ProsTel">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">

                                                            <div class="radio">
                                                                <label for="h">
                                                                    <img src="{{asset('img/H.png')}}" alt="">
                                                                </label>
                                                                <label>

                                                                    <input type="radio" value="M" name="Prossex" id="h">
                                                                    Homme
                                                                    <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="radio">
                                                                <label for="f">
                                                                    <img src="{{asset('img/F.png')}}" alt="">
                                                                </label>
                                                                <label>
                                                                    <input type="radio" value="F" name="Prossex" id="f">
                                                                    Femme
                                                                    <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <button type="button" class="loginB buttonAddGue nextLi"><span>Suivant</span></button>
                                                </form>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="infoSoci">
                                                <form id="infoSocial" action="" method="post" role="form">

                                                    <div class="form-group">
                                                        <label for="ProsRS">Raison social</label>
                                                        <label style="float: right;">*</label>
                                                        <input type="text" class="form-control" name="ProsRS" id="ProsRS">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsDateC">Date de création</label>
                                                        <input type="text" class="form-control datePicker" name="ProsDateC" id="ProsDateC">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsActivite">Activité</label>
                                                        <input type="text" class="form-control" name="ProsActivite" id="ProsActivite">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsSecteur">Secteur</label>
                                                        <input type="text" class="form-control" name="ProsSecteur" id="ProsSecteur">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsVille">Ville</label>
                                                        <input type="text" class="form-control" name="ProsVille" id="ProsVille">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ProsFax">Fax</label>
                                                        <input type="text" class="form-control" name="ProsFax" id="ProsFax">
                                                    </div>

                                                    <div class="row" style="margin-left: 0">
                                                        <label class="control-label col-sm-3" style="float: left;" >Chiffre d'affaires</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">

                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" value="zt" name="ztT">
                                                                    De 0 à 10 MDH
                                                                    <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" value="tTH" name="ztT">
                                                                    De 10 à 200MDH
                                                                    <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="loginB buttonAddGue nextLi"><span>Suivant</span></button>
                                                </form>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="objRenc">
                                                <form id="ObjMeet" action="" method="post" role="form">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="imtiaz">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Imtiaz
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="moussanada" value="1">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Moussanada
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="tahfiz" value="1">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Tahfiz
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="istitmar" value="1">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Istitmar
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="systInfo">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Système d'information
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="startUp">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Start Up
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="1" name="consultance">
                                                                        <span class="cr"><img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Consultance
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12" style="background-color: #f3f3f3;padding: 10px;margin: 40px 0;">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="autoEntr" value="1" id="AutoEntre">
                                                                        <span class="cr">
                                                                          <img src="{{asset('img/forme-767.png')}}" class="cr-icon"></span>
                                                                        Auto-entrepreneur
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 AE">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="o1" value="porteurP" disabled>
                                                                        <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>
                                                                        Porteurs de projets
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 AE">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="o1" value="UPI" disabled>
                                                                        <span class="cr"><img src="{{asset('img/ellipse-1524.png')}}" class="cr-icon"></span>
                                                                        UPI (Unité de production informelle)
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <h3 style="color:#126388">Prendre un rendez-vous</h3>

                                                    <div class="form-group">
                                                        <label for="inpDate">Date</label>
                                                        <input type="text" class="form-control datePicker" name="dateM" id="inpDate">
                                                        <span> <img src="{{asset('img/calendar-copie.png')}}" alt=""></span>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inpHour">Heure</label>
                                                        <input type="text" class="form-control inpHour" name="hourM" id="inpHour">
                                                        <span> <img src="" alt=""></span>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inpEmp">Emplacement</label>
                                                        <input type="text" class="form-control" name="empM" id="inpEmp">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inpN">Note</label>
                                                        <textarea name="noteM" id="inpN" cols="30" rows="10"></textarea>
                                                    </div>



                                                    <button type="submit" class="loginB buttonAddGue" id="addNewUser"><span>Ajouter</span></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                    </div>

                </div>
            </div>
        </div>




    </div>

@endsection

@section('scripts')
    <script src="{{asset('packages/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script>

            $(document).ready(function () {


                <?php if(strpos(Request::url(), 'detail') !== false){ ?>

              $(".Pcard").addClass('blocked');
              $("#regisUpd").hide(0);
                $(".sexSection").hide(0);
                $(".upChiffre").hide(0);
                $("#formProspect input,#formProspect textarea").prop('disabled', true);
                <?php } else{ ?>
                $('#nomP').focus();
                $(".sexProspt").hide();
                $(".chiffre input,.chiffre .bar").hide(0);
                  <?php } ?>

                               $("#editForm").click(function(e){
                    e.preventDefault();

                      if($(".Pcard").hasClass('blocked'))
                      {

                        $("#regisUpd").show(0);
                          $(".upChiffre").show(0);
                          $(".chiffre input,.chiffre .bar").hide(0);
                        $(".sexProspt").hide();
                        $(".sexSection").show(0);
                        $("#formProspect input,#formProspect textarea").prop('disabled', false);
                        $(this).find('img').attr('src', '{{asset("img/groupe-35-copie.png")}}');
                          $(".Pcard").removeClass('blocked');
                    }
                      else{

                          $(this).find('img').attr('src', '{{asset("img/editProsp.png")}}');
                          $("#regisUpd").hide(0);
                          $("#formProspect input,#formProspect textarea").prop('disabled', true);
                          $(".sexProspt").show();
                          $(".sexSection").hide(0);
                          $(".Pcard").addClass('blocked');
                      }


                });

                $('#InfoPerso')[0].reset();
                $('#infoSocial')[0].reset();
                $('#ObjMeet')[0].reset();
                $('#ObjMeet').submit(function(){
                    var url = "{{route('checkObjM')}}";

                    var data = $('#InfoPerso,#infoSocial,#ObjMeet').serialize();


                    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        dataType:'json',
                        success: function(data){
                            console.log(data);
                            swal("New Prospect!", "Prospect ajouté avec succés.", "success");
                            $('#response').hide();
                            $('#InfoPerso')[0].reset();
                            $('#infoSocial')[0].reset();
                            $('#ObjMeet')[0].reset();
                            $('.nav-tabs').find('li:first-child').find('a').trigger('click');
                        },
                        error: function(data)
                        {
                            var errors = '';
                            for(vv in data.responseJSON){
                                errors += data.responseJSON[vv] + '<br>';
                            }
                            $('#response').show().html(errors);
                        }
                    });

                    return false;
                });


                $('#formProspect').submit(function(){

                    var url = "{{route('updateProspect',['id'=>$prospect->id])}}";
                    var data = $('#formProspect').serialize();


                    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        dataType:'json',
                        success: function(data){
                            console.log(data);
                            swal("Prospect Modifier!", "Prospect modifié avec succés.", "success");
                            $('#resp').hide();
                        },
                        error: function(data)
                        {
                            var errors = '';
                            for(vv in data.responseJSON){
                                errors += data.responseJSON[vv] + '<br>';
                            }
                            $('#resp').show().html(errors);
                        }
                    });

                    return false;
                });




                $(".AE input").prop('disabled', true);
                $(".AE input").prop('checked', false);
                $("#AutoEntre").prop('checked', false);

                $('#AutoEntre').change(function() {

                    if($(this).is(":checked")) {
                        $(".AE input").prop('disabled', false);
                        $(".AE input").prop('checked', true);
                    }
                    else {
                        $(".AE input").prop('disabled', true);
                        $(".AE input").prop('checked', false);
                    }
                });
                $('.nextLi').click(function(){

                    $('.nav-tabs> .active').next('li').find('a').trigger('click');
                });


<?php if(strpos(Request::url(), 'edit') !== false){ ?>

                $('#editForm').trigger('click');
                <?php }?>


  $('#inpPros').autocomplete({

                    source:'{!!URL::route('autocomplete')!!}',
                    minlength:3,
                    autoFocus:true,
                    appendTo: ".form-group",
                    select:function(e,ui)
                    {
                        $('#inpPros').val(ui.item.value);
                    }
                });





        });




    </script>

@endsection