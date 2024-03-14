<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Professor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProfessorController extends Controller
{
    public function professor()
    {
        return view('professor');
    }

    public function showListProfessor(Request $request)
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $Users = User::where('user_type', 3)->where('school_id', Auth::user()->school_id);
            return DataTables::of($Users)
                ->addIndexColumn()
                ->editColumn('pays_id' , function($Users){
                    return strtoupper($Users->country->nom);
                })
                ->editColumn('school_id' , function($Users){
                    return $Users->school->name ?? '-';
                })
                // ->editColumn('created_at' , function($Users){
                //     return $Users->created_at->translatedFormat('d M Y');
                // })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editUser">Modifier</a>';
                    // $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger mr-4 btn-sm deleteUser">Sup</a>';
                    // if($row->connected){
                    //     $btn = $btn.'<div data-id="'.$row->id.'" class="custom-control checkbox custom-switch custom-switch-off-danger custom-switch-on-success">
                    //                     <input type="checkbox" class="custom-control-input" id="checkbox_'.$row->id.'" checked>
                    //                     <label class="custom-control-label" for="checkbox_'.$row->id.'"></label>
                    //                 </div>';
                    // }else{
                    //     $btn = $btn.'<div data-id="'.$row->id.'" class="custom-control checkbox custom-switch custom-switch-off-danger custom-switch-on-success">
                    //                     <input type="checkbox" class="custom-control-input" id="checkbox_'.$row->id.'">
                    //                     <label class="custom-control-label" for="checkbox_'.$row->id.'"></label>
                    //                 </div>';
                    // }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    // public function showListStudent()
    // {
    //     // composer require yajra/laravel-datatables-oracle
    //     if(request()->ajax()){
    //         $Classroom = Classroom::where('manager', Auth::user()->id);
    //         // $Student = Student::where('classrooms_id', $Classroom->id);
    //         $Student = Student::all();
    //         return DataTables::of($Student)
    //             ->addIndexColumn()
    //             ->addColumn('action', function($row){
    //                 $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editUser">Modifier</a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    // }
    
    public function add(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            "email.required" => "Remplir le champ Email!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "gender.required" => "Sélectionnez le genre!",
            "subject.required" => "Remplir le champ Matière!",
            "password.required" => "Remplir le champ mot de passe!",
            "password.min" => "Le mot de passe doit comporter au moins 8 caracteres!",
            "password.confirmed" => "Les deux champs de mots de passe ne correspondent pas",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['required','unique:users'],
            'gender' => ['required'],
            'subject' => ['required'],
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
            'pays_id' => Auth::user()->pays_id,
            'school_id' => Auth::user()->school_id,
            'last_name' => $request-> last_name,
            'first_name' => $request-> first_name,
            'email' => $request-> email,
            'gender' => $request-> gender,
            'user_type' => 3,
            'password' => Hash::make($request['password']),
            'subject' => $request-> subject,
        ]);

        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "AJOUT REUSSI",
            "msg" => "Le professeur au nom de ".$request-> last_name." a bien été ajouté"
        ]);
    }

    //get user info by Id
    public function getProfessorInfoById(Request $request)
    {
        $id = $request-> id;
        $User = User::find($id);
        return response()->json([
            "status" => true,
            "last_name" => $User->last_name,
            "first_name" => $User->first_name,
            "email" => $User->email,
            "gender" => $User->gender,
            "subject" => $User->subject,
        ]);
    }

    public function update(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            "email.required" => "Remplir le champ Email!",
            // "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "gender.required" => "Sélectionnez le genre!",
            "subject.required" => "Remplir le champ Matière!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['required'],
            'gender' => ['required'],
            'subject' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "MIS A JOUR ERRONE",
                "msg" => $validator->errors()->first()
            ]);
        
        $id = $request-> id;

        $emailExist = User::where('email', $request-> email)->first();
        
        $search = User::find($id);
        if($search){
            if($emailExist){
                $search -> update([
                    'last_name' => $request-> last_name,
                    'first_name' => $request-> first_name,
                    'gender' => $request-> gender,
                    'subject' => $request-> subject,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    // "redirect_to" => route('user'),
                    "title" => "MIS A JOUR REUSSIE",
                    "msg" => "Mis a jour reussie"
                ]);
            }
            else{
                $search -> update([
                    'last_name' => $request-> last_name,
                    'first_name' => $request-> first_name,
                    'email' => $request-> email,
                    'gender' => $request-> gender,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    // "redirect_to" => route('user'),
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
                    "title" => "CONNEXION DESACTIVEE",
                    "msg" => "Désactivation réussie pour ".$search->fullName()
                ]);
            }else{
                $search -> update([
                    'connected' => true,
                ]);
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    "redirect_to" => route('user'),
                    "title" => "CONNEXION ACTIVEE",
                    "msg" => "Activation réussie pour ".$search->fullName()
                ]);
            }
        }
    }

    public function classroomManager($id)
    {
        $decryptedId = decrypt($id);
        $Classroom = Classroom::find($decryptedId['id']);
        return view('student',[
            'Classroom' => $Classroom,
            'Manager' => 1,
        ]);
    }

    public function classroomProfessor($id)
    {
        $decryptedId = decrypt($id);
        $Classroom = Classroom::find($decryptedId['id']);
        return view('student',[
            'Classroom' => $Classroom,
            'Manager' => 0,
        ]);
    }

}
