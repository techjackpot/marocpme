<?php
/**
 * Created by.
 * User: anass.nadir@gmail.com
 * Date: 3/04/17
 * Time: 10:05 AM
 */
namespace App\Http\Controllers;

use App\prospects;
use App\User;
use App\appointment;
use App\calendar;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     * @resource Kittens
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $pass= Auth()->user()->password;
$prospects=DB::table('prospects')->where('user_id',Auth::user()->id)->count();
        return view('profile',['nbPros'=>$prospects]);
    }

    public function calendar()
    {

        if(Auth::user()->isAdmin=='heIs'){

            $users=User::where('isAdmin','nop')->get();
            return view('calendar',['users'=>$users]);

        }
        else
        return view('calendar');

    }
    public function getMyCalendar(){


            $events = array();

        $appointments = DB::table('appointments')
            ->join('calendars', 'calendars.id', '=', 'appointments.calendar_id')
            ->join('prospects', 'prospects.id', '=', 'appointments.prospect_id')
            ->where('calendars.user_id',Auth::user()->id)
            ->select('appointments.*','prospects.mail','prospects.nom','prospects.prenom')
            ->get();

        $e = array();
        foreach($appointments as $appointment) {

            $e['id'] = $appointment->id;
            $e['title'] =$appointment->prenom.' '.$appointment->nom;
            $e['start'] = $appointment->date.' '.$appointment->hour;
            $e['emplacement'] = $appointment->emplacement;
            $e['note'] = $appointment->note;
            $e['prospect'] = $appointment->mail;
            array_push($events, $e);
        }
        return Response()->json($events);


    }
    public function storeAppointment(Request $request)
    {

        $this->validate($request, array(

           'mailProspe'=>'required|email',
            'dateM'=>'required|date_format:"Y-m-d"',
            'hourM' => 'required|date_format:"H:m"',
        ));
        $prospect = prospects::where('mail', '=', $request->mailProspe)->first();
        if ($prospect === null) {

            return Response()->json(['ce prospect n\'existe pas'], 422);
        }
        else{
$idCalendar=calendar::where('user_id', '=',Auth::user()->id)->first();
$ap=new appointment();
            $ap->prospect_id=$prospect->id;
            $ap->calendar_id=$idCalendar->id;


            $ap->date=$request->dateM;
            $ap->hour=$request->hourM;
            $ap->emplacement=$request->empM;
            $ap->note=$request->noteM;

$ap->save();
$propName=$prospect->nom.' '.$prospect->prenom;


        return response()->json(array('id'=>$ap->id,'title'=>$propName,'date'=>$request->dateM,
            'hour'=>$request->hourM,'emplacement'=>$request->empM,'note'=>$request->noteM,'mail'=>$prospect->mail));
    }

    }

    public function prospect()
    {
        if(Auth::user()->isAdmin=='heIs'){

            $users=User::where('isAdmin','nop')->get();
            return view('prospects',['users'=>$users]);

        }
else
    return view('prospects');


    }
    public function users()
    {
        if(Auth::user()->isAdmin=='heIs')
        return view('supAdmin.users');
        else
            return abort(403, 'Unauthorized action.');
    }

    public function prospectDetails()
    {
        return view('prospects.details');
    }

    public function usersDetail(){

        return view('supAdmin.usersDetail');


    }

    public function editProfil($id,Request $request)
    {

        $user = User::findOrFail($id);


        $this->validate($request, array(
            'nomP' => 'required',
            'prenomP' => 'required',
            'email'  => 'required'
        ));

        if($request->email!=$user->email){
            $this->validate($request, array(
                'email'  => 'email|unique:users',
            ));

        }
        if($request->has('passUser')){
            $this->validate($request, array(
                'passUser'  => 'required|min:6',
            ));


        }
        if($request->has('passUser')&&$request->passUser!=''){

            $user->password = bcrypt($request->passUser);

        }
        $user->nom=$request->nomP;
        $user->prenom=$request->prenomP;
        $user->tel=$request->tel;
        $user->poste=$request->poste;
        $user->email=$request->email;

        $user->save();

        return response($user, 200)
            ->header('Content-Type', 'application/json');
    }

    public function storeUser(Request $request){

        $this->validate($request, array(
            'nomUser' => 'required',
            'prenomUser' => 'required',
            'email'  => 'required|email|unique:users'
        ));
        $newPass=str_random(6);
        $user = new User;
$calendar=new calendar;

        $user->nom = $request->nomUser;
        $user->prenom = $request->prenomUser;
        $user->email = $request->email;
        $user->password=bcrypt($newPass);


        $user->save();

        $calendar->user_id=$user->id;
        $calendar->save();
        return response([$user,'newPass'=>$newPass], 201)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Action-Type' => 'Store new User',
                'Action-User' => Auth::user()->nom,
            ]);

    }

    public function getUsersData()
    {
        if(Auth::user()->isAdmin=='heIs'){
        $users = User::select(['id','nom','prenom', 'email','active','localisation'])->where('isAdmin','nop')->get();
        return Datatables::of($users)
            ->addColumn('actions', function ($user) {
                $actions=' <a class="viewVisit" href="detail/'.$user->id.'"> <img src="'.asset("img/001-eye-copie.png").'" onmouseover="hover(this,\''.asset("img/001-eye.png").'\');" onmouseout="unhover(this,\''.asset("img/001-eye-copie.png").'\');"></a>';
                $actions.='<a class="editVisit" href="' .route("UserEdit",["id"=>$user->id]) . '"> <img src="'.asset("img/002-edit-copie.png").'" onmouseover="hover(this,\''.asset("img/002-edit.png").'\');" onmouseout="unhover(this,\''.asset("img/002-edit-copie.png").'\');"></a>';
              if($user->active=="forNow")
                $actions.= '<a class="deleteVisit" href="#" data-delete="'.route('deleteThisUser',$user->id).'"> <img src="'.asset("img/003-delete-copie.png").'" onmouseover="hover(this,\''.asset("img/003-delete.png").'\');" onmouseout="unhover(this,\''.asset("img/003-delete-copie.png").'\');"></a>';
                else if($user->active=="notAnymore")
                    $actions.= '<a class="deleteVisit blocked" href="#" data-delete="'.route('deleteThisUser',$user->id).'"> <img src="'.asset("img/003-delete.png").'" onmouseover="hover(this,\''.asset("img/003-delete-copie.png").'\');" onmouseout="unhover(this,\''.asset("img/003-delete.png").'\');"></a>';


                return $actions;


            })
            ->editColumn('nomPrenom',function($user){

                return $user->nom.' '.$user->prenom;

            })

            ->make(true);
        }
        else
            return abort(403, 'Unauthorized action.');

    }

    public function getProspectsData(Request $request)
    {
        $sql = "select id,nom,prenom,mail,fonction,tel,user_id from prospects";

        if ($request->ajax()) {
            if(Auth::user()->isAdmin=='heIs') {
            /*    $prospects = prospects::select(['id', 'nom','prenom', 'mail', 'fonction', 'tel','user_id'])
                    ->orderBy('created_at', 'desc')
                ->get();*/

                $prospects =  DB::table(DB::raw("($sql) as prospects"))->get();
            }
            else{
                $prospects = prospects::select(['id','nom','prenom', 'mail', 'fonction', 'tel'])
                    ->where('user_id', Auth::user()->id)
                    ->orderBy('id','asc')
                    ->get();
            }


//            $datatables =  app('datatables')->of()
                 return Datatables::of($prospects)
            ->addColumn('actions', function ($prospect) {
                $actions = ' <a class="viewVisit" href="' . route("ProspectDetails", ["id" => $prospect->id]) . '"> <img src="' . asset("img/001-eye-copie.png") . '" onmouseover="hover(this,\'' . asset("img/001-eye.png") . '\');" onmouseout="unhover(this,\'' . asset("img/001-eye-copie.png") . '\');"></a>';
                $actions .= '<a class="editVisit" href="' .route("ProspectEdit",["id"=>$prospect->id]) . '"> <img src="' . asset("img/002-edit-copie.png") . '" onmouseover="hover(this,\'' . asset("img/002-edit.png") . '\');" onmouseout="unhover(this,\'' . asset("img/002-edit-copie.png") . '\');"></a>';
                $actions .= '<a class="deleteVisit" href="#"> <img src="' . asset("img/003-delete-copie.png") . '" onmouseover="hover(this,\'' . asset("img/003-delete.png") . '\');" onmouseout="unhover(this,\'' . asset("img/003-delete-copie.png") . '\');"></a>';


                return $actions;


            })
                ->editColumn('nom',function($prospect){

                    return $prospect->nom.' '.$prospect->prenom;

                })
            ->filter(function ($query) use ($request) {
                if ($request->has('selectUserF')) {
                    $query->where('user_id', '=', "{$request->get('selectUserF')}");
                }

                if ($request->has('objVisite')) {
                    if($request->get('objVisite')!='UPI'&&$request->get('objVisite')!='porteurP')
                    $query->where("{$request->get('objVisite')}", '=', 1);
                    else
                        $query->where('autoEntr', 'like', "{$request->get('objVisite')}");
                }
            })

         /*   if ($request->has('selectUserF')) {

                if($request->selectUserF!="allUsers")
                $datatables->where('user_id', $request->selectUserF);
            }*/
       /*     if ($obj = $datatables->request->get('objVisite')) {


                $datatables->where("$obj",1);

                $datatables->where("autoEntr",$obj);
            }*/


           ->make(true);

        }
        else
            return redirect()->back();
    }

    public function viewUserDetails($id)
    {

        $user=User::findOrFail($id);

        if($user->id==Auth::user()->id||Auth::user()->isAdmin=='heIs')
        return view('supAdmin.usersDetail',['user'=>$user]);

        else
            return abort(403, 'Unauthorized action.');
    }

    public function viewProspectDetails($id)
    {
        $prospect=prospects::findOrFail($id);

        if($prospect&&$prospect->user_id==Auth::user()->id||Auth::user()->isAdmin=='heIs')
            return view('prospects.details',['prospect'=>$prospect]);
        else
            return abort(403, 'Unauthorized action.');
    }
public function editProspectDetails($id){

    $prospect=prospects::find($id);

    if($prospect&&$prospect->user_id==Auth::user()->id||Auth::user()->isAdmin=='heIs')
        return view('prospects.details',['prospect'=>$prospect]);
    else
        return abort(403, 'Unauthorized action.');

}

public function editUserDetails($id)
{
    $user=User::findOrFail($id);

    if($user->id==Auth::user()->id||Auth::user()->isAdmin=='heIs')
        return view('supAdmin.usersDetail',['user'=>$user]);

    else
        return abort(403, 'Unauthorized action.');
}
    public function deleteUser($id,Request $request){
        if(Auth::user()->isAdmin=='heIs'&&$request->ajax()) {
            $thisuser = User::find($id);
if($thisuser->active=='forNow') {
    $thisuser->active = 'notAnymore';



    $thisuser->update();

    return response(['status' => 'Blocked', 'id' => $thisuser->id, 'name' => $thisuser->nom . ' ' . $thisuser->prenom], 200)
        ->header('Content-Type', 'text/html');

}
        elseif($thisuser->active=='notAnymore')
        {

    $thisuser->active = 'forNow';

    $thisuser->update();

    return response(['status' => 'Unblocked', 'id' => $thisuser->id, 'name' => $thisuser->nom . ' ' . $thisuser->prenom], 200)
        ->header('Content-Type', 'text/html');
            }
        }


        return abort(403, 'Unauthorized action.');
    }

    public function saveProspect(Request $request)
    {

            $this->validate($request, array(

                'ProsPrenom' => 'required',
                'ProsNom' => 'required',
                'ProsMail' => 'required|email|unique:prospects,mail',
                'Prossex' => 'required|in:M,F',
                'ProsTel'=>'digits:10',
                'ProsRS'=>'required|unique:prospects,RS',
                'ProsDateC' => 'date_format:"Y-m-d"',
                'dateM' => 'date_format:"Y-m-d"',
                'hourM' => 'date_format:"H:i"'
            ));

        $pros = new prospects();

$pros->user_id=Auth::user()->id;

        $pros->nom = $request->ProsNom;
        $pros->prenom=$request->ProsPrenom;
        $pros->fonction = ($request->ProsFonction)!=''?$request->ProsFonction:null;
        $pros->mail = $request->ProsMail;
        $pros->sex = $request->Prossex;
        $pros->tel = ($request->ProsTel)!=''?$request->ProsTel:null;

        $pros->RS = $request->ProsRS;
        $pros->dateCreation = ($request->ProsDateC)!=''?$request->ProsDateC:null;
        $pros->activite = ($request->ProsActivite)!=''?$request->ProsActivite:null;
        $pros->secteur = ($request->ProsSecteur)!=''?$request->ProsSecteur:null;
        $pros->fax = ($request->ProsFax)!=''?$request->ProsFax:null;
        $pros->ville = ($request->ProsVille)!=''?$request->ProsVille:null;
        $pros->chiffreAff = $request->ztT;


        $pros->imtiaz = ($request->imtiaz)!=null?1:0;
        $pros->moussanada = ($request->moussanada)!=null?1:0;
        $pros->tahfiz = ($request->tahfiz)!=null?1:0;
        $pros->istitmar = ($request->istitmar)!=null?1:0;
        $pros->systemeInfo = ($request->systInfo)!=null?1:0;
        $pros->startUp = ($request->startUp)!=null?1:0;
        $pros->consultance = ($request->consultance)!=null?1:0;
        $pros->autoEntr =($request->autoEntr)!=null?$request->o1:null;

       $pros->save();


        $idCalendar=calendar::where('user_id', '=',Auth::user()->id)
            ->first();

        if($request->dateM!=''||$request->hourM!=''||$request->empM!=''||$request->noteM!='') {
            $appoin=new appointment();
            $appoin->calendar_id = $idCalendar->id;
            $appoin->prospect_id = $pros->id;
            $appoin->date = $request->dateM;
            $appoin->hour = $request->hourM;
            $appoin->emplacement = $request->empM;
            $appoin->note = $request->noteM;
            $appoin->save();
        }
        return response()->json($pros);
    }


    public function updateProspect($id,Request $request)
    {


        $prospect = prospects::find($id);


        $this->validate($request, array(
            'nomP' => 'required',
            'prenomP' => 'required',
            'mailP'  => 'required',
            'RSP'=> 'required|unique:prospects,RS',
            'telP'=>'digits:10',
            'sexP' => 'required|in:M,F',
            'dateCP'=>'date_format:"Y-m-d"',
            'ProsDateC' => 'date_format:"Y-m-d"',
            'dateM' => 'date_format:"Y-m-d"',
            'hourM' => 'date_format:"H:i"'
        ));

        if($request->mailP!=$prospect->mail){
            $this->validate($request, array(
                'mailP'  => 'email|unique:prospects,mail',
            ));

        }


        $prospect->nom=$request->nomP;
        $prospect->prenom=$request->prenomP;
        $prospect->tel=$request->telP;
        $prospect->fonction=$request->fonctionP;
        $prospect->mail=$request->mailP;
        $prospect->sex=$request->sexP;

        $prospect->RS = $request->RSP;
        $prospect->dateCreation = ($request->dateCP)!=''?$request->dateCP:null;
        $prospect->activite = ($request->activP)!=''?$request->activP:null;
        $prospect->secteur = ($request->secteurP)!=''?$request->secteurP:null;
        $prospect->fax = ($request->faxP)!=''?$request->faxP:null;
        $prospect->ville = ($request->villeP)!=''?$request->villeP:null;
        $prospect->chiffreAff = $request->ztT;


        $prospect->imtiaz = ($request->imtiaz)!=null?1:0;
        $prospect->moussanada = ($request->moussanada)!=null?1:0;
        $prospect->tahfiz = ($request->tahfiz)!=null?1:0;
        $prospect->istitmar = ($request->istitmar)!=null?1:0;
        $prospect->systemeInfo = ($request->systInfo)!=null?1:0;
        $prospect->startUp = ($request->startUp)!=null?1:0;
        $prospect->consultance = ($request->consultance)!=null?1:0;
        $prospect->autoEntr =($request->autoEntr)!=null?$request->o1:null;

        $prospect->save();

        return response($prospect, 200)
            ->header('Content-Type', 'application/json');

    }
public function updateUser(Request $request,$id)
{

    $this->validate($request, array(
        'inpNom' => 'required',
        'inpPrenom' => 'required',
        'inpMail' => 'required',
    ));
$user=User::findOrFail($id);

    if($request->inpMail!=$user->email){
        $this->validate($request, array(
            'inpMail'  => 'email|unique:users,email',
        ));
        $user->email = $request->inpMail;
    }

    $user->nom = $request->inpNom;
    $user->prenom = $request->inpPrenom;

    $user->tel = $request->inpTel;
    $user->save();

    return response($user, 201)
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Action-Type' => 'Update User',
            'Action-User' => Auth::user()->nom,
        ]);
}
    public function autocomplete(Request $request)
    {
        $queries=[];
        $term = $request->term;
if(Auth::user()->isAdmin=='heIs')
        $queries = prospects::where('mail', 'like', $term.'%')->get();

        else
            $queries = prospects::where([['mail', 'like', $term.'%'],['user_id','=',Auth::user()->id]])->get();

        foreach ($queries as $query)
        {
            $results[] = ['id' => $query->id, 'value' => $query->mail];
        }
        return response()->json($results);
    }

}

/*'imtiaz' => 'required|numerique',
            'moussanada'  => 'required|numerique',
            'tahfiz' => 'required',
            'istitmar' => 'required|unique:prospects,mail',
            'startUp' => 'required',
            'consultance'  => 'required',
            'autoEntre'=>'required',
            'o1'  => 'required',*/