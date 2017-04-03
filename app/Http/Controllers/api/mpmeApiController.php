<?php
/**
 * Created by.
 * User: anass.nadir@gmail.com
 * Date: 3/09/17
 * Time: 10:05 AM
 */
namespace App\Http\Controllers\api;

use App\calendar;
use App\prospects;
use App\appointment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Facades\DB;

class mpmeApiController extends BaseController
{

    protected function throwValidationException(\Illuminate\Http\Request $request, $validator) {
        throw new ValidationHttpException($validator->errors());}

    public function __construct()
    {
        $this->middleware('api.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AllUsers()
    {
        $users=User::all();
        return response($users,200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all Users',
        ]);
    }

    public function getOneUser($id){

        $user=User::find($id);


        if($user) {
            return response($user, 200)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Get User ' . $user->id,

            ]);

        }
        else{
            return response(['error'=>'utilisateur non trouvé'], 400)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'User not found ' . $id,

            ]);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        $this->validate($request, array(
            'nom' => 'required',
            'prenom' => 'required',
            'email'  => 'required|email|unique:users'
        ));
        $newPass=str_random(6);
        $user = new User;
        $calendar=new calendar;

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password=bcrypt($newPass);


        $user->save();

        $calendar->user_id=$user->id;
        $calendar->save();
        return response([$user,'newPass'=>$newPass], 201)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Store new User',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        $user=User::find($id);

        if($user) {

            $this->validate($request, array(
                'inpNom' => 'required',
                'inpPrenom' => 'required',
                'inpMail' => 'required',
            ));

            if ($request->inpMail != $user->email) {
                $this->validate($request, array(
                    'inpMail' => 'email|unique:users,email',
                ));
                $user->email = $request->inpMail;
            }
            if($request->has('passUser')&&$request->passUser!=''){
                $this->validate($request, array(
                    'passUser'  => 'required|min:6',
                ));
                $user->password = bcrypt($request->passUser);

            }

            $user->nom = $request->inpNom;
            $user->prenom = $request->inpPrenom;
            $user->tel = $request->inpTel;
            $user->poste = $request->inpPoste;
            $user->save();

            return response($user, 201)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Action-Type' => 'Update User'
                ]);
        }
        else{
            return response(['error'=>'utilisateur non trouvé'], 400)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'User not found ' . $id,

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUser($id)
    {

        $thisuser = User::findOrFail($id);

        $thisuser->active='notAnymore';
        $thisuser->update();

        return response(['status'=>'Blocked','id'=>$thisuser->id,'name'=>$thisuser->nomPrenom], 200)
            ->header('Content-Type', 'text/html');

    }

    public function AllCalendars()
    {
        $calendars=calendar::all();
        $new_calendars = array();
        foreach($calendars as $calendar) {
            $user = DB::table('users')
                ->where('id', '=', $calendar->user_id)
                ->first();
            $calendar->name = $user->nom . ' ' . $user->prenom;
            $new_calendars[] = $calendar;
        }
        return response(array('calendars'=>$new_calendars),200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all calendars',
            'Action-Location'=>'Marrakech',
        ]);
    }

    public function getAppointments() {
        $appointments = appointment::all();
        $new_appointments = array();
        foreach($appointments as $appointment) {
            //$calendar = DB::table('calendars')->where('id','=',$appointment->calendar_id)->first();
            $prospect = DB::table('prospects')->where('id','=',$appointment->prospect_id)->first();
            $appointment->user_id = $prospect->user_id;
            $appointment->name = $prospect->nom . ' ' . $prospect->prenom;
            $new_appointments[] = $appointment;
        }
        return response(array('appointments'=>$new_appointments),200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all appointments'
        ]);
    }
    public function getAppointment($id) {
        $appointment = appointment::find($id);
        if($appointment) {
            $calendar = DB::table('calendars')->where('id','=',$appointment->calendar_id)->first();
            $prospect = DB::table('prospects')->where('id','=',$appointment->prospect_id)->first();
            $appointment->user_id = $calendar->user_id;
            //$user = User::find($calendar->user_id);
            $appointment->name = $prospect->nom . ' ' . $prospect->prenom; //$user->nom . ' ' . $user->prenom; 
            return response($appointment, 200)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Get appointment ' . $appointment->id,
            ]);
        }
        else{
            return response(['error'=>'appointment non trouvé'], 400)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'appointment not found ' . $id,

            ]);

        }
    }
    public function editAppointment(Request $request, $id) {
        $appointment=appointment::find($id);

        if($appointment) {

            $this->validate($request, array(
                'prospect_name' => 'required',
                'emplacement' => 'required',
                'note' => 'required',
                'date' => 'required',
                'hour' => 'required',
            ));

            $appointment->emplacement = $request->emplacement;
            $appointment->note = $request->note;
            $appointment->date = $request->date;
            $appointment->hour = $request->hour;
            $appointment->save();

            $prospect = prospects::find($appointment->prospect_id);
            $results = array();
            preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $request->prospect_name, $results);
            $prospect->nom = $results[2];
            $prospect->prenom = $results[3];
            $prospect->save();

            return response($appointment, 201)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Action-Type' => 'Update appointment'
                ]);
        }
        else{
            return response(['error'=>'appointment non trouvé'], 400)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Appointment not found ' . $id,

            ]);
        }
    }
    public function destroyAppointment($id) {
        $appointment = appointment::findOrFail($id);
        if($appointment && $appointment->delete()) {
            return response(['status' => "deleted", 'id' => $appointment->id],200)->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        }
    }
    public function addAppointment(Request $request, $pros_id) {
        $appointment = new appointment();
        $idCalendar = calendar::where('user_id', '=',Auth::user()->id)->first();
        $appointment->calendar_id = $idCalendar->id;
        $appointment->prospect_id = $pros_id;
        $appointment->date = $request->dateM;
        $appointment->hour = $request->hourM;
        $appointment->emplacement = $request->empM;
        $appointment->note = $request->noteM;
        $appointment->save();

        return response()->json($appointment);
    }


    //prospects

    public function getProspects()
    {
        $prospects=prospects::all();
        $new_prospects = array();

        foreach($prospects as $prospect) {
            $appointment = DB::table('appointments')
                ->where('prospect_id', '=', $prospect->id)
                ->orderBy('id','desc')
                ->first();

            if($appointment) {
                $prospect->date = $appointment->date;
                $prospect->hour = $appointment->hour;
                $prospect->emplacement = $appointment->emplacement;
                $prospect->note = $appointment->note;
            }
            $new_prospects[] = $prospect;
        }

        return response(array('prospects'=>$new_prospects),200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all prospects',
        ]);

    }

    public function getProspect($id)
    {
        $prospect=prospects::find($id);

        if($prospect) {
            $appointment = DB::table('appointments')
                ->where('prospect_id', '=', $id)
                ->orderBy('id','desc')
                ->first();

            $prospect->date = $appointment->date;
            $prospect->hour = $appointment->hour;
            $prospect->emplacement = $appointment->emplacement;
            $prospect->note = $appointment->note;

            return response($prospect, 200)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Get prospect ' . $prospect->id,
            ]);
        }
        else{
            return response(['error'=>'prospect non trouvé'], 400)->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'prospect not found ' . $id,

            ]);

        }

    }

    public function updateProspect($id,Request $request)
    {

    }



}

