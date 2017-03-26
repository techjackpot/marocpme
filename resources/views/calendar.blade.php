@extends('layouts.layout')

@section('styles')

    <link rel="stylesheet" type="text/css" href="{{asset('packages/sweetalert/dist/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('packages/fullcalendar/dist/fullcalendar.css')}}">


    @endsection

@section('content')

    <div id="content">


        <div class="container-fluid">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        @if(isset($users))
                        <div class="input-group" >
                            <select id="selectUserF" name="selectUserF"  style="height: 50px;width: 100%;">
                                <option value="" disabled selected>Utilisateurs</option>
                                <?php
                                foreach($users as $user){ ?>
                                <option value="{{$user->nom}}">{{$user->nom.' '.$user->prenom}}</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-btn">
    <a id="filterUser" href="#"> <img style="width: 60px;
left: -5px;
position: relative;
top: -5px;" src="{{asset('img/filter.png')}}" aria-hidden="true"></a>
  </span>
                        </div>
                        @endif
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button type="button" class="loginB buttonAddGue" data-toggle="modal" data-target="#newMeet"><span>Ajouter un nouveau rendez-vous </span></button>
           </div></div>
            <div class="panel-left">
                <div id="Pmecalendar"></div>


            </div>

        </div>


        <div class="modal fade" id="newMeet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: url({{asset('img/calque-38.png')}})">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                        </button>
                        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('img/calendar.png')}}" alt="" style="margin-right: 10px;">Ajouter un nouveau rendez-vous</h4>

                    </div>
                    <form id="newAppointment" action="" method="post" role="form">
                    <div class="modal-body">
                        <div class="alert alert-danger" id="response" style="display: none"></div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />



                            <div class="form-group">
                                <label for="inpPros">Prospect</label>
                                <input type="text" class="form-control" name="mailProspe" id="inpPros" placeholder="Saisissez le mail de votre prospect">
                            </div>
                            <div class="form-group">
                                <label for="inpDate">Date</label>
                                <input type="text" class="form-control datePicker" name="dateM" id="inpDate">
                                <span> <img src="{{asset('img/calendar-copie.png')}}" alt=""></span>

                            </div>
                            <div class="form-group">
                                <label for="inpHour">Heure</label>
                                <input type="text" class="form-control clockpicker" name="hourM" id="inpHour">
                                <span> <img src="{{asset('img/clock-circular-outline.png')}}" alt=""></span>

                            </div>
                            <div class="form-group">
                                <label for="inpEmp">Emplacement</label>
                                <input type="text" class="form-control" name="empM" id="inpEmp">
                            </div>
                            <div class="form-group">
                                <label for="inpN">Note</label>
                                <textarea name="noteM" id="inpN" cols="30" rows="10"></textarea>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="loginB buttonAddGue" id="addNewCal"><span>Ajouter</span></button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="DetailRV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: url({{asset('img/calque-38.png')}})">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                    </button>
                    <h4 class="modal-title" id="myModalLabel1"></h4>

                </div>
                <div class="modal-body">



                    <div class="form-group">
                        <label>Prospect</label>
                        <h4 class="mailProspect">JohnDoe@Doe.foo</h4>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <h4 class="dateBody">27 Janvier 2017</h4>

                    </div>
                    <div class="form-group">

                        <label>Heure</label>
                        <h4 class="hourBody">10:30</h4>

                    </div>
                    <div class="form-group">

                        <label>Emplacement</label>
                        <h4 class="emplacement">Marrakesh</h4>

                    </div>
                    <div class="form-group">

                        <label>Note</label>
                        <blockquote>
                            <textarea class="note" name="noteM" id="inpN" cols="30" rows="10"></textarea>
                        </blockquote>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('packages/moment/moment.js')}}"></script>
    <script src="{{asset('packages/fullcalendar/dist/fullcalendar.js')}}"></script>
    <script src="{{asset('packages/fullcalendar/dist/locale/fr.js')}}"></script>
    <script src="{{asset('js/calendar.js')}}"></script>
    <script src="{{asset('packages/sweetalert/dist/sweetalert.min.js')}}"></script>


    <script>

        $(document).ready(function () {

            $('#newAppointment').submit(function(){

                var url = "{{route('NewAppointment')}}";

                var data = $('#newAppointment').serialize();


                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    dataType:'json',
                    beforeSend: function()
                    {
                        $('#response').hide();
                    },
                    success: function(data){
                        swal("Nouveau rendez-vous",'Votre rendez-vous est ajouté avec succés', "success");
                        $('#newMeet').modal('hide');
                        var event={id:data.id , title: data.title, start:data.date+' '+data.hour,emplacement:data.emplacement,prospect:data.mail,note:data.note};

                        $('#Pmecalendar').fullCalendar( 'renderEvent', event, true);
                        $('#newAppointment')[0].reset();
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











            $('#Pmecalendar').fullCalendar({
                header: {
                    right:null,
                    left: 'title prev,next',
                    lang: 'fr'

                },
                footer:{
                    right: 'prev,next'
                },
                editable: false,
                droppable: false,
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '{{route('appointments')}}',
                        dataType: 'json',
                        success: function(doc) {
                            console.log(doc);
                            var events = [];
                            $(doc).each(function() {

                                events.push({
                                    title:$(this).attr('title'),
                                    start: $(this).attr('start'),
                                    emplacement:$(this).attr('emplacement'),
                                    note:$(this).attr('note'),
                                    prospect:$(this).attr('prospect')
                                });
                            });
                            callback(events);
                        }
                    });
                },
                axisFormat: 'HH:mm',
                timeFormat: 'HH:mm',
                minTime: 0,
                maxTime: 24,
                eventClick: function(calEvent, jsEvent, view) {

                    var date = new Date(calEvent.start);
                    var month = [];
                    month[0] = "Janvier";
                    month[1] = "Février";
                    month[2] = "Mars";
                    month[3] = "Avril";
                    month[4] = "Mai";
                    month[5] = "Juin";
                    month[6] = "Juillet";
                    month[7] = "août";
                    month[8] = "Septembre";
                    month[9] = "Octobre";
                    month[10] = "Novembre";
                    month[11] = "Decembre";
                    var dd=date.getUTCDate()+' '+month[date.getMonth()]+' '+date.getFullYear();
                    $("#DetailRV .modal-title").text('');
                    $("#DetailRV .modal-title").append('<img src="img/calendar.png" alt="" style="margin-right: 10px;">'+'Rendez-vous'+' '+dd);
                    $("#DetailRV .dateBody").text(dd);
                    $("#DetailRV .hourBody").text(moment(calEvent.start).format('HH:mm'));
                    $("#DetailRV .emplacement").text(calEvent.emplacement);
                    $("#DetailRV .note").text(calEvent.note);
                    $("#DetailRV .mailProspect").text(calEvent.prospect);

                    $('#DetailRV').modal('show');

                }

            });

            $("#filter").change(function () {
                $("#Pmecalendar").fullCalendar("removeEvents", filter);
            });

            function filter(event) {
                return $("#filter > option:selected").attr("id") === event.id;
            }


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