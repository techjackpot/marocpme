@extends('layouts.layout')


@section('styles')
    <link href="{{asset('packages/datatables.net/css/jquery.dataTables.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">

    @endsection
@section('content')
    <div id="content">


        <div class="container-fluid">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-sm-6 col-sm-offset-6">
            <button class="loginB buttonAddGue" data-toggle="modal" data-target="#newProsp"><span>Ajouter nouveau prospect </span></button>
</div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    @if(isset($users))
            <div class="input-group" >
                <select id="selectUserF" name="selectUserF"  style="height: 50px;width: 100%;">
                    <option value="" disabled selected>Utilisateurs</option>
                    <option value="allUsers" style="background-color: #00b3ee">Select Tous</option>
                    <?php
                    foreach($users as $user){ ?>
                    <option value="{{$user->id}}">{{$user->nom.' '.$user->prenom}}</option>
                    <?php
                    }
                    ?>
                </select>
                <span class="input-group-btn">
 <img style="width: 60px;
left: -5px;
position: relative;
top: -5px;" src="{{asset('img/filter.png')}}" aria-hidden="true">
  </span>
            </div>
                    @endif
</div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group">
                    <select id="objVisite" name="objVisite"  style="height: 50px;width: 100%;">
                        <option value="" disabled selected>Objet de Visite</option>
                        <option value="imtiaz">Imtiaz</option>
                        <option value="moussanada">Moussanada</option>
                        <option value="tahfiz">Tahfiz</option>
                        <option value="startUp">Start Up</option>
                        <optgroup label="Auto Entrepreneur">
                            <option value="porteurP">Porteurs de projets</option>
                            <option value="UPI">UPI</option>
                        </optgroup>
                        <option value="istitmar">Istitmar</option>
                        <option value="systemeInfo">Système d'information</option>
                        <option value="consultance">Consultance</option>
                    </select>
                    <span class="input-group-btn">
    <img style="width: 60px;
left: -5px;
position: relative;
top: -5px;" src="{{asset('img/filter.png')}}" aria-hidden="true">
  </span>
                </div>
                    </div>
            </div>


                    <table id="listUsers" class="nowrap cell-border" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th class="no-sort">Actions</th>
                        </tr>
                        </thead>
                    </table>



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
                                                        <input type="text" class="form-control" name="hourM" id="inpHour">
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
    <script src="{{asset('packages/datatables.net/js/jquery.dataTables.js')}}"></script>
    <script>

        $(document).ready(function () {
            var emptyTable='<h5 style="color:#656565;text-align: center">Vous n\'avais aucun</h5>';
            @if(isset($users))
                    emptyTable+='<h3 style="color:#66aa2e;text-align: center">Prospect Ajouté</h3><br/>';

                            @else
                emptyTable+='<h3 style="color:#66aa2e;text-align: center">Prospect Ajouté, Commencez dès maintenant</h3><br/>';

            @endif
                emptyTable+='<img src="{{asset('img/emptyTable.png')}}">';
            var newProspectList=[];
            var oTable =   $('#listUsers').DataTable({
                processing: true,
                serverSide: true,
                "bFilter": true,
                "bInfo" : false,
                "bLengthChange": false,
                ajax: {
                    url: '{{ route("ProspectsData")  }}',
                    data: function (d) {
                        d.selectUserF = $('#selectUserF').val();
d.objVisite=$('#objVisite').val();
                    }
                },
                "language": {
                    paginate: {
                        next: '<img src="{{asset('img/nextPag.png')}}">',
                        previous: '<img src="{{asset('img/prevPag.png')}}">'
                    },

                    "processing": "En traitement",
                    "emptyTable":emptyTable,
                    "zeroRecords":"aucun prospect trouvé."
                },
                "sDom": '<"top"i>rt<"bottom"lp><"clear">',
                "pagingType": "simple",

                columns: [
                    {data: 'nom',name:'nom'},
                    {data: 'tel',name:'tel'},
                    {data: 'mail',name:'mail'},
                    {data: 'fonction',name:'fonction'},
                    {data: 'actions',name:'actions', orderable: false, searchable: false}
                ]

            });
            $('#selectUserF,#objVisite').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });

            $('.search-box').on('keyup change', function () {
                oTable.search(this.value).draw();
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

$('.nextLi').click(function(){

    $('.nav-tabs> .active').next('li').find('a').trigger('click');
});



        $('a.deleteVisit').click(function (e) {

            e.preventDefault();
            swal({
                        title: "Vous étes sur que vous voulez supprimer ce prospect?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#4285F4",
                        confirmButtonText: "Oui, je suis sur et certain!",
                        cancelButtonText: "j'ai regretté!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            swal("Supprimé!", "Ce prospect est supprimé avec succès.", "success");
                        } else {
                            swal("Retour", "Ce prospect est toujours a sa plaçe  :)", "error");
                        }
                    });

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
            })
        });
    </script>

@endsection