<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    public function classroom()
    {
        $Professor = User::where('user_type', 3)->where('school_id', Auth::user()->school_id)->get();

        return view('classroom/classroom',[
            'Professor' => $Professor,
        ]);
    }

    public function showListClassroom(Request $request)
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $Class = Classroom::where('schools_id', Auth::user()->school_id);
            return DataTables::of($Class)
                ->addIndexColumn()
                ->editColumn('manager' , function($Class){
                    return $Class->user->fullName()?? '-';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-view"  data-id="'.$row->id.'" data-original-title="Detail" class="btn btn-primary btn-sm mr-1 viewUser">Détail</a>';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Modifier" class="btn btn-warning btn-sm mr-1 editUser">Mod</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" data-original-title="Supprimer" class="btn btn-danger btn-sm deleteUser">Sup</a>';
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
            "manager.required" => "Sélectionnez le responsable!",
            // "professor.required" => "Sélectionnez un ou plusieurs professeurs intervenant!",
        ];

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'manager' => ['required'],
            // 'professor' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "AJOUT ECHOUE",
                "msg" => $validator->errors()->first()
            ]);

        if($request->professor){
            $professorId = implode(',', $request->professor);
        }else{
            $professorId = '';
        }

        Classroom::create([
            'schools_id' => Auth::user()->school_id,
            'name' => $request-> name,
            'manager' => $request-> manager,
            'professor' => $professorId,
        ]);

        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "AJOUT REUSSI",
            "msg" => "La classe au nom de ".$request-> name." a bien été ajoutée"
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
        ]);
    }

    public function view($id)
    {
        $Classroom = Classroom::find($id);
        $professor_selected_array = [];
        if($Classroom->professor){
            $professors_id = explode(',', $Classroom->professor);
            foreach ($professors_id as $prof) {
                $user = User::find($prof);
                array_push($professor_selected_array , $user);
            }
        }
        return view('classroom/view',[
            'Classroom' => $Classroom,
            'professor_selected_array' => $professor_selected_array,
        ]);
    }

    public function edit($id)
    {
        $Classroom = Classroom::find($id);
        $Professor = User::where('user_type', 3)->where('school_id', Auth::user()->school_id)->get();
        $professor_selected_array = [];
        if($Classroom->professor){
            $professors_id = explode(',', $Classroom->professor);
            foreach ($professors_id as $prof) {
                $user = User::find($prof);
                array_push($professor_selected_array , $user);
            }
        }
        return view('classroom/edit',[
            'Classroom' => $Classroom,
            'Professor' => $Professor,
            'professor_selected_array' => $professor_selected_array,
        ]);
    }
    

    public function update(Request $request)
    {
        $error_messages = [
            "name.required" => "Remplir le champ Nom!",
            "manager.required" => "Sélectionnez le responsable!",
            // "professor.required" => "Sélectionnez un ou plusieurs professeurs intervenant!",
        ];

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'manager' => ['required'],
            // 'professor' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "AJOUT ECHOUE",
                "msg" => $validator->errors()->first()
            ]);

        if($request->professor){
            $professorId = implode(',', $request->professor);
        }else{
            $professorId = '';
        }

        $id = $request-> id;
        $search = Classroom::find($id);
        $search -> update([
            'name' => $request-> name,
            'manager' => $request-> manager,
            'professor' => $professorId,
        ]);

        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "Mis à jour réussie",
            "msg" => "La classe au nom de ".$request-> name." a été mis à jour avec succès"
        ]);
    }

    public function delete_user(Request $request)
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
                "msg" => $validator->errors()->first()
            ]);
        
        $id = $request-> id;
        $search = User::find($id);
        if($search){
            $search -> delete();
            if($search->school_id){
                return response()->json([
                    "status" => false,
                    "reload" => true,
                    // "redirect_to" => route('user'),
                    "title" => "SUPPRESSION ECHOUEE",
                    "msg" => "l'utilisateur ".$search->name." est lié a une école"
                ]);
            }else{
                return response()->json([
                    "status" => true,
                    "reload" => true,
                    // "redirect_to" => route('user'),
                    "title" => "SUPPRESSION",
                    "msg" => "suppression reussie"
                ]);
            }
        }else{
            return response()->json([
                "status" => false,
                "reload" => true,
                "title" => "SUPPRESSION",
                "msg" => "Utilisateur inexistant"
            ]);
        }
    }
}
