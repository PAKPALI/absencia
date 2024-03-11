<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    
    public function showListStudent()
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $Student = Student::all();
            return DataTables::of($Student)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editUser">Modifier</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addStudent(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            // "email.required" => "Remplir le champ Email!",
            // "email2.required" => "Remplir le champ Email2!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "email2.unique" => "L'email ".$request-> email. " existe déjà!",
            // "num1.numeric" => "Remplir le champ Numéro 1 avec des chiffres!",
            // "num2.numeric" => "Remplir le champ Numéro 2 avec des chiffres!",
            "gender.required" => "Sélectionnez le genre!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['unique:users'],
            // 'num1' => ['numeric'],
            // 'num2' => ['numeric'],
            'gender' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "AJOUT ECHOUE",
                "msg" => $validator->errors()->first()
            ]);

        Student::create([
            'classrooms_id' => $request-> classroom_id,
            'last_name' => $request-> last_name,
            'first_name' => $request-> first_name,
            'email' => $request-> email,
            'email2' => $request-> email2,
            'num1' => $request-> num1,
            'num2' => $request-> num2,
            'gender' => $request-> gender,
        ]);

        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "AJOUT REUSSI",
            "msg" => "L'étudiant au nom de ".$request-> last_name." ".$request-> first_name." a bien été ajouté"
        ]);
    }
}
