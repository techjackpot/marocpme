@extends('layouts.layout')

@section('styles')
    <link href="{{asset('packages/datatables.net/css/jquery.dataTables.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">

@endsection

@section('content')

    <div id="content">


        <div class="container-fluid">




            <button class="loginB buttonAddGue" data-toggle="modal" data-target="#newUser"><span>Ajouter nouveau utilisateur </span></button>



            <table id="listUsers" class="nowrap cell-border" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Localisation</th>
                    <th class="no-sort">Actions</th>
                </tr>
                </thead>
            </table>

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
    <script src="{{asset('packages/datatables.net/js/jquery.dataTables.js')}}"></script>

    <script>

        $(document).ready(function () {

           var usersData=$('#listUsers').DataTable({
               "bFilter": true,
               "bInfo" : false,

                "bLengthChange": false,
                processing: true,
                serverSide: true,
                "language": {

                    paginate: {
                        next: '<img src="{{asset('img/nextPag.png')}}">',
                        previous: '<img src="{{asset('img/prevPag.png')}}">'
                    },
                    "processing": "En traitement",
                    "emptyTable": "Vous n'avez pas encore ajouté des utilisateurs.",
                    "zeroRecords":"aucun utilisateur trouvé."
                },
               "sDom": '<"top"i>rt<"bottom"lp><"clear">',
                "pagingType": "simple",
                ajax: '{!! route("UsersData") !!}',
                columns: [
                    {data: 'nomPrenom',name:'nomPrenom'},
                    {data: 'email',name:'email'},
                    {data: 'localisation',name:'localisation'},
                    {data: 'actions',name:'actions', orderable: false, searchable: false}
                ]

            });


            $('.search-box').on('keyup change', function () {
                usersData.search(this.value).draw();
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
                        $('#listUsers').DataTable().draw(false);
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

        });

            $('#listUsers').on('click', '.deleteVisit[data-delete]', function (e){
                var url =$(this).data('delete');
            e.preventDefault();

                if($(this).hasClass('blocked')) {
                    swal({

                                title: "Vous étes sur que vous voulez débloquer  ce utilisateur?",

                                type: "info",
                                showCancelButton: true,
                                confirmButtonColor: "#4285F4",
                                confirmButtonText: "Ouii, Le ramener au boulot",
                                cancelButtonText: "Pas encore!",
                                closeOnConfirm: false,
                                closeOnCancel: false


                            },


                            function (isConfirm) {
                                if (isConfirm) {

                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        datatype: 'json',
                                        success: function (data) {
                                            swal("Débloquer !", "Ce utilisateur est activé avec succès.", "success");
                                            $('#listUsers').DataTable().draw(false);
                                        },
                                        error: function () {
                                            swal("erreur!", url, "warning");
                                        }


                                    });


                                } else {
                                    swal("Retour", "Ce utilisateur est toujours a sa plaçe  :)", "error");
                                }
                            });
                }
                else{
                    swal({

                                title: "Vous étes sur que vous voulez bloquer ce utilisateur?",

                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#4285F4",
                                confirmButtonText: "Oui, je suis sur et certain!",
                                cancelButtonText: "j'ai regretté!",
                                closeOnConfirm: false,
                                closeOnCancel: false


                            },


                            function (isConfirm) {
                                if (isConfirm) {

                                    $.ajax({
                                        url: url,
                                        type: 'GET',
                                        datatype: 'json',
                                        success: function (data) {
                                            swal("Blocker!", "Ce utilisateur a été bloquer avec succès.", "success");
                                            $('#listUsers').DataTable().draw(false);
                                        },
                                        error: function () {
                                            swal("erreur!", url, "warning");
                                        }


                                    });


                                } else {
                                    swal("Retour", "Ce utilisateur est toujours a sa plaçe  :)", "error");
                                }
                            });

                }
        });
    </script>
    @endsection


