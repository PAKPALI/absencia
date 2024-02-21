<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function user()
    {
        $Country = Pays::all();

        return view('user',[
            'Country' => $Country,
        ]);
    }

    public function showListUser(Request $request)
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $Users = User::where('user_type', 2);
            return DataTables::of($Users)
                ->addIndexColumn()
                ->editColumn('pays_id' , function($Users){
                    return strtoupper($Users->country->nom);
                })
                ->editColumn('school_id' , function($Users){
                    return $Users->school_id ?? '-';
                })
                // ->editColumn('created_at' , function($Users){
                //     return $Users->created_at->translatedFormat('d M Y');
                // })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editUser">Mod</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTown">Sup</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.town');
    }

    public function profil()
    {

        return view('profil');
    }

    public function updatePassword(Request $request)
    {

        $error_messages = [
            "AM.required" => "Remplir le champ ancien mot de passe!",
            "NM.required" => "Remplir le champ nouveau mot de passe!",
            "CM.required" => "Remplir le champ confirmer mot de passe!",
            "NM.min" => "Le nouveau mot de passe doit comporter au moins 8 caracteres!",
        ];

        $validator = Validator::make($request->all(),[
            'AM' => ['required', 'min:8'],
            'NM' => ['required', 'min:8'],
            'CM' => ['required', 'min:8'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "CONNECTION ECHOUEE",
            "msg" => $validator->errors()->first()]);

        $id = $request-> id;
        $User = User::find($id);

        if(Hash::check($request-> AM, $User-> password)){

            if($request-> NM == $request-> CM){
                $search = User::find($id);
                if($search){
                    $search -> update([
                        'password' =>  Hash::make($request-> CM)
                    ]);
                    return response()->json([
                        "status" => true,
                        "reload" => true,
                        "redirect_to" => "0",
                        "title" => "MIS A JOUR REUSSIE",
                        "msg" => "Mis a jour reussie"
                    ]);
                }
            }else{

                return response()->json([

                    "status" => false,
                    "reload" => false,
                    "title" => "CONNECTION ECHOUE",
                    "msg" => "Le nouveau mot de passe et la confirmation du mot de passe sont différents"
    
                ]);

            }

        }else{

            return response()->json([

                "status" => false,
                "reload" => false,
                "title" => "CONNECTION ECHOUE",
                "msg" => "L'ancien mot de passe saisie ne correspond pas au mot de passe enregistré dans la base de donnée"

            ]);
        }
    }

    public function add_user(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            "email.required" => "Remplir le champ Email!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "num1.required" => "Remplir le champ Numéro 1!",
            // "num2.required" => "Remplir le champ Numéro 2!",
            "gender.required" => "Sélectionnez le genre!",
            "pays_id.required" => "Sélectionnez le pays!",
            "password.required" => "Remplir le champ mot de passe!",
            "password.min" => "Le mot de passe doit comporter au moins 8 caracteres!",
            "password.confirmed" => "Les deux champs de mots de passe ne correspondent pas",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['required','unique:users'],
            'num1' => ['required'],
            // 'num2' => ['required'],
            'gender' => ['required'],
            'pays_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "AJOUT ECHOUE",
                "msg" => $validator->errors()->first()
            ]);

        User::create([
            'last_name' => $request-> last_name,
            'first_name' => $request-> first_name,
            'email' => $request-> email,
            'num1' => $request-> num1,
            'num2' => $request-> num2,
            'gender' => $request-> gender,
            'pays_id' => $request-> pays_id,
            'user_type' => 2,
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "AJOUT REUSSI",
            "msg" => "L'utilisateur au nom de ".$request-> nom." a bien été ajouté"
        ]);
    }

    // 
    public function getUserInfoById(Request $request)
    {
        $id = $request-> id;
        $User = User::find($id);
        return response()->json([
            "status" => true,
            "last_name" => $User->last_name,
            "first_name" => $User->first_name,
            "email" => $User->email,
            "num1" => $User->num1,
            "num2" => $User->num2,
            "gender" => $User->gender,
            "pays_id" => $User->pays_id,
        ]);
    }


    public function update_user(Request $request)
    {
        $error_messages = [
            "nom.required" => "Remplir le champ nom!",
            "email.required" => "Remplir le champ nom!",
            // "email.unique" => "L'email '".$request-> email. "' existe deja!",
        ];

        $validator = Validator::make($request->all(),[
            'nom' => ['required'],
            // 'email' => ['required','unique:users'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MIS A JOUR ERRONE",
            "msg" => $validator->errors()->first()]);
        
        $id = $request-> id;
        $sc = $request-> sousCaisee;
        $nom = $request-> nom;
        $email = $request-> email;

        $emailExist = User::where('email', $email) ->first();
        
        $search = User::find($id);
        if($search){
            if($emailExist){
                $search -> update([
                    'nom' => $nom,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis a jour reussie"
                ]);
            }
            else{
                $search -> update([
                    'nom' => $nom,
                    'email' => $email
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis a jour reussie"
                ]);
            }
        }
    }

    public function parametre(Request $request)
    {
        $error_messages = [
            "sousCaisse.required" => "Selectionnez la sous caisse pour la lier a l'utilisateur!",
        ];

        $validator = Validator::make($request->all(),[
            'sousCaisse' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "MIS A JOUR ERRONE",
            "msg" => $validator->errors()->first()]);
        
        $id = $request-> id;
        $sc = $request-> sousCaisse;
        
        $search = User::find($id);
        if($search){
            if($sc == 0){
                $search -> update([
                    'sous_caisse_id' => null,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis a jour reussie"
                ]);
            }else{
                $search -> update([
                    'sous_caisse_id' => $sc,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis a jour reussie"
                ]);
            }
            
        }
    }

    public function connected(Request $request)
    {
        
        $id = $request-> id;
        $connected = $request-> connected;
        
        $search = User::find($id);
        if($search){
            if($connected == 0){
                $search -> update([
                    'connected' => false,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "CONNEXION DESACTIVER",
                    "msg" => "Desactivation reussie pour ".$search->nom
                ]);
            }else{
                $search -> update([
                    'connected' => true,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "CONNEXION ACTIVER",
                    "msg" => "activation reussie pour ".$search->nom
                ]);
            }
        }
    }

    public function status(Request $request)
    {
        
        $id = $request-> id;
        $connected = $request-> connected;
        
        $search = User::find($id);
        if($search){
            if($connected == 0){
                $search -> update([
                    'status_client' => false,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "GESTION CLIENT DESACTIVER",
                    "msg" => "Desactivation reussie pour ".$search->nom
                ]);
            }else{
                $search -> update([
                    'status_client' => true,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "GESTION CLIENT ACTIVER",
                    "msg" => "activation reussie pour ".$search->nom
                ]);
            }
        }
    }

    public function delete(Request $request)
    {

        $error_messages = [
            "id.required" => "Remplir le champ id!",
            "id.numeric" => "Remplir le champ id avec les chiffres!",
        ];

        $validator = Validator::make($request->all(),[
            'id' => 'required| numeric'
        ], $error_messages);

        if($validator->fails())
            return response()->json([
            "status" => false,
            "reload" => false,
            "title" => "SUPPRESSION",
            "msg" => $validator->errors()->first()]);
        
        $id = $request-> id;
        $search = User::find($id);
        if($search){
            $search -> delete();

            return response()->json([
                "status" => true,
                "reload" => true,
                "redirect_to" => route('user'),
                "title" => "SUPPRESSION",
                "msg" => "suppression reussie"
            ]);
        }else{
           
            return response()->json([
                "status" => false,
                "reload" => true,
                "title" => "SUPPRESSION",
                "msg" => "Utilisateur inexistant"
            ]);
        }
    }

    public function outUser(Request $request)
    {
        $id =  $request->id;
        // $user = User::find($id);

        // Auth::logout($user);
        $request->session()->invalidate();

        return response()->json([
            "status" => true,
            "reload" => true,
            "redirect_to" => route('conn'),
            "title" => "DECONNEXION REUSSI",
            'check' => Auth::check(),
            "msg" => "Au revoir, a bientot"
        ]);
    }
}
