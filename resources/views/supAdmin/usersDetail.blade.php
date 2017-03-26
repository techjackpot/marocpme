@extends('layouts.layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">
    <style>

        .container-fluid [class*="col-"] {
            padding-left: 15px !important;
        }
        .form-horizontal .form-group {
            padding: 0 40px;
        }
    </style>
@endsection

@section('content')

    <div id="content">


        <div class="container-fluid " style="padding: 0 70px;">





            <button class="loginB buttonAddGue" data-toggle="modal" data-target="#newUser"><span>Ajouter nouveau utilisateur </span></button>

            <form id="formUpUser" class="form-horizontal" role="form">
                {{csrf_field()}}
                {{ method_field('PUT') }}
            <div class="detailsUser col-md-12">

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding-left: 50px;">
                    <div class="alert alert-danger" id="resp" style="display: none"></div>


                        <div class="form-group">
                            <label for="inpNom">Nom</label>
                            <input type="text" class="form-control" name="inpNom" id="inpNom" value="{{$user->nom}}" autocomplete=off>
                            <div class="bar"></div>
                        </div>
                        <div class="form-group">
                            <label for="inpPrenom">Prénom</label>
                            <input type="text" class="form-control" name="inpPrenom" id="inpPrenom" value="{{$user->prenom}}" autocomplete=off>
                            <div class="bar"></div>
                        </div>
                        <div class="form-group">
                            <label for="inpTel">Téléphone</label>
                            <input type="text" class="form-control" name="inpTel" id="inpTel" value="{{$user->tel}}" autocomplete=off>
                            <div class="bar"></div>

                        </div>
                        <div class="form-group">
                            <label for="inpMail">Email</label>
                            <input type="text" class="form-control" name="inpMail" id="inpMail" value="{{$user->email}}" autocomplete=off>
                            <div class="bar"></div>
                        </div>
                    <div class="form-group">
                        <label for="inpcom">Company</label>
                        <input type="text" class="form-control" name="empM" id="inpcom" value="MarocPME" autocomplete=off>
                        <div class="bar"></div>
                    </div>


                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align: center;box-shadow: 0px 1px 16px 0 rgba(13, 14, 14, 0.22);
background-color: #f4f4f4;
height: 550px;">

                    <?php if(strpos(Request::url(), 'detail') !== false){ ?>
                        <a href="#" id="editForm" style="position: absolute; top: -15px;right: -15px"><img src="{{asset('img/editProsp.png')}}" alt=""></a>

                                   <?php } ?>


                    <img src="{{asset('img/calque-2420.png')}}" alt="" style="height: 100%;">
                </div>

            </div>
            <div class="col-sm-offset-11 col-sm-1 col-md-offset-11 col-md-1" style="margin-top: 40px;padding-right: 0;">
                <button type="submit" class="loginB buttonAddGue" id="regisUpd" style="float: right;">Enregistrer</button>
            </div>
            </form>
        </div>


        <div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: url('{{asset("img/calque-38.png")}}')">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                        </button>
                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('img/user-1.png')}}" alt="" style="margin-right: 10px;">Ajouter un nouveau utilisateur</h4>

                    </div>
                    <form action="" method="post" role="form" id="newUserForm">
                        <div class="modal-body">
                            <div class="alert alert-danger" id="response" style="display: none"></div>

                            {{csrf_field()}}

                            <div class="form-group {{ $errors->has('nomUser') ? ' has-error' : '' }}">
                                <label for="inpUserNF">Nom</label>
                                <label style="float: right;">*</label>
                                <input type="text" class="form-control" name="nomUser" id="inpUserNF">
                            </div>
                            <div class="form-group {{ $errors->has('prenomUser') ? ' has-error' : '' }}">
                                <label for="inpUserNL">Prénom</label>
                                <label style="float: right;">*</label>
                                <input type="text" class="form-control" name="prenomUser" id="inpUserNL">
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inpUserMail">Email</label>
                                <label style="float: right;">*</label>
                                <input type="text" class="form-control" name="email" id="inpUserMail">
                                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="loginB buttonAddGue" id="addNewUser"><span>Ajouter</span></button>

                        </div>
                    </form>
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

       $("#formUpUser").addClass('blocked');
            $("#regisUpd").hide(0);
            $("#formUpUser input").prop('disabled', true);
            <?php } else{ ?>

            $("#inpNom").focus();

            <?php } ?>

            $("#editForm").click(function(e){
                e.preventDefault();
                if($("#formUpUser").hasClass('blocked'))
                {
                    $("#regisUpd").show(0);
                    $("#formUpUser input").prop('disabled', false);
                    $(this).find('img').attr('src', '{{asset("img/groupe-35-copie.png")}}');
                    $("#inpNom").focus();
                    $("#formUpUser").removeClass('blocked');
                }
            else{

                    $(this).find('img').attr('src', '{{asset("img/editProsp.png")}}');
                    $("#regisUpd").hide(0);
                    $("#formUpUser input").prop('disabled', true);
                    $("#formUpUser").addClass('blocked');
                }


            });
            $('#newUserForm').submit(function(){

                var url = "{{route('newUser')}}";

                var data = $('#newUserForm').serialize();

                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,

                    success: function(data){


                        $('#response').hide();
                        $('#newUserForm')[0].reset();
                        $('#newUser').modal('hide');
                        swal({
                            title: "Nouveau <small>Utilisateur</small>!",
                            text: 'Utilisateur ajouté avec succés veuillez enregistrer le nouveau mot de passe <b>'+data.newPass+'</b> aprés la fermeture',
                            html: true,
                            type:"success"
                        });
                    },
                    error: function(data)
                    {
                        var errors = '';
                        for(datos in data.responseJSON){
                            errors += data.responseJSON[datos] + '<br>';
                        }
                        $('#response').show().html(errors);
                    }
                });

                return false;
            });
            $('#formUpUser').submit(function(){
                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
                var url = "{{route('UserUpdate',['id'=>$user->id])}}";

                var data = $('#formUpUser').serialize();

                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,

                    success: function(data){


                        $('#resp').hide();
                        swal('Utilisateur Modifier','Utilisateur modifié avec succés','success');
                    },
                    error: function(data)
                    {
                        var errors = '';
                        for(datos in data.responseJSON){
                            errors += data.responseJSON[datos] + '<br>';
                        }
                        $('#resp').show().html(errors);
                    }
                });

                return false;
            });
        });
    </script>

@endsection


