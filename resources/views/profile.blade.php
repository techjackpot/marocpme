@extends('layouts.layout')

@section('styles')

    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">
    <style>

        .container-fluid [class*="col-"] {
            padding-right: 15px !important;
        }
        .form-horizontal .form-group {
            padding: 0 40px;
        }
    </style>
    @endsection

@section('content')

    <div id="content" style="padding-top: 0;">

        <img src="{{asset('img/calque-2532.jpg')}}" alt="" style="width: 100%">
        <span class="nbVisite">{{$nbPros}} Prospect Ajoutés</span>
        <a href="#" style="position: relative;
float: right;
top: -35px;
right: 5%;" id="editForm">
            <img src="{{asset('img/calque-32.png')}}" alt="">
        </a>
        <div class="container-fluid" style="padding: 0 70px;">

            <form id="formProfil" class="form-horizontal" role="form" method="post" action="">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="detailsUser col-md-12" style="overflow: hidden;margin-top: 0;">

                    <div class="hidden-xs col-sm-12 col-md-6 col-lg-6" style="padding-left: 50px;box-shadow: 0px 1px 16px 0 rgba(13, 14, 14, 0.22);
background-color: #f4f4f4;
text-align: center; float: left;
  margin-bottom: -99999px;
  padding-bottom: 99999px;">



                        <img src="{{asset('img/profPic.png')}}" alt="" style="object-fit: contain;
margin: 25% auto;">


                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="alert alert-danger" id="resp" style="display: none"></div>


                        <div class="form-group">
                            <label for="fName">Nom</label>
                                <input type="text" class="form-control" id="fName" name="nomP" value="{{Auth::user()->nom}}">
                                <div class="bar"></div>

                        </div>
                        <div class="form-group">
                            <label for="lName">Prénom</label>


                                <input type="text" class="form-control" id="lName" name="prenomP" value="{{Auth::user()->prenom}}">
                                <div class="bar"></div>


                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>

                                <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}">
                                <div class="bar"></div>

                        </div>
                        <div class="form-group passw">
                            <label for="pwds">Mot de passe</label>


                                <input type="password" class="form-control" id="pwds" name="passUser" value="">
                                <div class="bar"></div>


                        </div>
                        <div class="form-group">
                            <label for="tel">Tél</label>

                                <input type="text" class="form-control" id="tel" name="tel" value="{{Auth::user()->tel}}">
                                <div class="bar"></div>

                        </div>
                        <div class="form-group">

                            <label for="pst">Poste</label>


                                <input type="text" class="form-control" id="pst" name="poste" value="{{Auth::user()->poste}}">
                                <div class="bar"></div>

                        </div>

                    </div>

                </div>
                <div class="col-sm-offset-11 col-sm-1 col-md-offset-11 col-md-1" style="margin-top: 40px;padding-right: 0!important;">
                    <button type="submit" class="loginB buttonAddGue" id="regisUpd" style="float: right;">Enregistrer</button>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{asset('packages/sweetalert/dist/sweetalert.min.js')}}"></script>
    @include('sweet::alert')
    <script src="{{asset('js/hideShowPassword.min.js')}}"></script>
    <script>


        $(document).ready(function () {
            $('#pwds').hidePassword(true);
            $("#regisUpd").hide(0);
            $('.passw').hide(0);
            $("#formProfil input").prop('disabled', true);
            $("#formProfil").addClass('blocked');
            $("#editForm").click(function(e){
                e.preventDefault();
                if($("#formProfil").hasClass('blocked'))
                {
                    $("#regisUpd").show(0);
                    $('.passw').slideDown(500);
                    $('#pwds').val('');
                    $("#formProfil input").prop('disabled', false);
                    $("#fName").focus();
                    $(this).find('img').attr('src', 'img/calque-32_2.png');
                    $("#formProfil").removeClass('blocked');
                }
                else {
                    $("#regisUpd").hide(0);
                    $('.passw').slideUp(500);
                    $('#pwds').val('');
                    $("#formProfil input").prop('disabled', true);
                    $(this).find('img').attr('src', 'img/calque-32.png');
                    $("#formProfil").addClass('blocked');
                }
            });

            $('#formProfil').submit(function(){
                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

                var url = "{{route('editMyProfil',['id'=>\Illuminate\Support\Facades\Auth::user()->id])}}";

                var data = $('#formProfil').serialize();


                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    dataType:'json',
                    success: function(data){
                        console.log(data);
                        swal("Mise à jour!", "votre profil a été modifié avec succés.", "success");
                        $('#response').hide(300);
                        $( "#editForm" ).trigger( "click" );
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






        });


    </script>

    @endsection