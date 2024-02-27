<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function school()
    {
        return view('school');
    }

    public function showListSchool(Request $request)
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $School = School::where('users_id', Auth::user()->id);
            return DataTables::of($School)
                ->addIndexColumn()
                ->editColumn('pays_id' , function($School){
                    return strtoupper($School->country->nom);
                })
                ->editColumn('users_id' , function($School){
                    return $School->user->last_name ?? '-';
                })
                ->editColumn('connected' , function($School){
                    if($School->connected){
                        return 'ACTIVER';
                        // $btn = '<a href="javascript:void(0)" class="btn btn-success btn-sm">ACTIVER</a>';
                    }else{
                        return 'DESACTIVER';
                        // $btn = '<a class="btn btn-danger btn-sm">DESACTIVER</a>';
                    }
                    // return $btn;
                })
                // ->editColumn('created_at' , function($Users){
                //     return $Users->created_at->translatedFormat('d M Y');
                // })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editSchool">Mod</a>';
                    // $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Sup</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add(Request $request)
    {
        $error_messages = [
            "name.required" => "Remplir le champ Nom!",
            "email.required" => "Remplir le champ Email!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "num1.required" => "Remplir le champ Numéro!",
            "num1.numeric" => "Remplir le champ Numéro avec des chiffres!",
        ];

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required','unique:users'],
            'num1' => ['required','numeric'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "AJOUT ECHOUE",
                "msg" => $validator->errors()->first()
            ]);

        if(!Auth::user()->school_id){
            $School = School::create([
                'name' => $request-> name,
                'email' => $request-> email,
                'numero' => $request-> num1,
                'pays_id' => Auth::user()->country->id,
                'users_id' => Auth::user()->id,
            ]);
    
            // update colum school id of user authenticate
            $user = User::find(Auth::user()->id);
            $user -> update([
                'school_id' => $School->id,
            ]);
    
            return response()->json([
                "status" => true,
                "reload" => true,
                // "redirect_to" => route('user'),
                "title" => "AJOUT REUSSI",
                "msg" => "L'école au nom de ".$request-> name." a bien été ajoutée"
            ]);
        }else{
            return response()->json([
                "status" => false,
                "reload" => true,
                // "redirect_to" => route('user'),
                "title" => "AJOUT ECHOUE",
                "msg" => "Vous avez déjà une école a votre actif"
            ]);
        }
    }

    //get user info by Id
    public function getSchoolInfoById(Request $request)
    {
        $id = $request-> id;
        $School = School::find($id);
        return response()->json([
            "status" => true,
            "name" => $School->name,
            "email" => $School->email,
            "numero" => $School->numero,
        ]);
    }

    public function update(Request $request)
    {
        $error_messages = [
            "name.required" => "Remplir le champ Nom!",
            "email.required" => "Remplir le champ Email!",
            "num1.required" => "Remplir le champ Numéro!",
            "num1.numeric" => "Remplir le champ Numéro avec les chiffres!",
        ];

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
            'num1' => ['required','numeric'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "MIS A JOUR ERRONE",
                "msg" => $validator->errors()->first()
            ]);
        
        $id = $request-> id;
        $emailExist = School::where('email', $request-> email)->first();
        
        $search = School::find($id);
        if($search){
            if($emailExist){
                $search -> update([
                    'name' => $request-> name,
                    'numero' => $request-> num1,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    // "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis à jour reussie"
                ]);
            }
            else{
                $search -> update([
                    'name' => $request-> name,
                    'email' => $request-> email,
                    'numero' => $request-> num1,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    // "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis à jour reussie"
                ]);
            }
        }
    }
}
