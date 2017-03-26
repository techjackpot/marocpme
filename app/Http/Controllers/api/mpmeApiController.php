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
use App\User;
use Illuminate\Http\Request;
use Dingo\Api\Exception\ValidationHttpException;

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
        return response($calendars,200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all calendars',
            'Action-Location'=>'Marrakech',
        ]);
    }


    //prospects

    public function getProspects()
    {
        $prospects=prospects::all();
        return response($prospects,200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Get all prospects',
        ]);

    }

    public function getProspect($id)
    {
        $prospect=prospects::find($id);


        if($prospect) {
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

