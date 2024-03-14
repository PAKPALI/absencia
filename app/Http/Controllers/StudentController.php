<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function showListStudent($classroom_id)
    {
        // composer require yajra/laravel-datatables-oracle
        if(request()->ajax()){
            $Student = Student::where('classrooms_id', $classroom_id);
            // $Student = Student::all();
            return DataTables::of($Student)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editStudent">Modifier</a>'.
                    $btn = ' <a  data-id="'.$row->id.'" data-name="'.$row->fullName().'" data-original-title="Edit" class="btn btn-dark btn-sm absent">A?</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    //get user info by Id
    public function getStudentInfoById(Request $request)
    {
        $id = $request-> id;
        $User = Student::find($id);
        return response()->json([
            "status" => true,
            "last_name" => $User->last_name,
            "first_name" => $User->first_name,
            "email1" => $User->email,
            "email2" => $User->email2,
            "num1" => $User->num1,
            "num2" => $User->num2,
            "gender" => $User->gender,
        ]);
    }

    public function addStudent(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            // "email.required" => "Remplir le champ Email!",
            // "email2.required" => "Remplir le champ Email2!",
            // "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "email2.unique" => "L'email ".$request-> email. " existe déjà!",
            // "num1.numeric" => "Remplir le champ Numéro 1 avec des chiffres!",
            // "num2.numeric" => "Remplir le champ Numéro 2 avec des chiffres!",
            "gender.required" => "Sélectionnez le genre!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            // 'email' => ['unique:users'],
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

    public function update(Request $request)
    {
        $error_messages = [
            "last_name.required" => "Remplir le champ Nom!",
            "first_name.required" => "Remplir le champ Prénom!",
            // "email.required" => "Remplir le champ Email!",
            // "email2.required" => "Remplir le champ Email2!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            // "email2.unique" => "L'email ".$request-> email. " existe déjà!",
            // "num1.numeric" => "Remplir le champ Numéro 1 avec des chiffres!",
            // "num2.numeric" => "Remplir le champ Numéro 2 avec des chiffres!",
            "gender.required" => "Sélectionnez le genre!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            // 'email' => ['unique:users'],
            // 'num1' => ['numeric'],
            // 'num2' => ['numeric'],
            'gender' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "MIS A JOUR ERRONE",
                "msg" => $validator->errors()->first()
            ]);
        
        $id = $request-> id;
        
        $search = Student::find($id);
        if($search){
            $search -> update([
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
                "title" => "MIS A JOUR REUSSIE",
                "msg" => "Mis a jour réussie"
            ]);
        }
    }

    public function absent(Request $request)
    {
        $id = $request-> id;
        $search = Student::find($id);
        if($search->email OR $search->email2){
            $this->sendEmail($search->email,$search->email2,$search->fullName());
            return response()->json([
                "status" => true,
                "reload" => true,
                // "redirect_to" => route('user'),
                "title" => "ENREGISTREMENT REUSSIE",
                "msg" => "Email envoyé aux parents avec succès"
            ]);
        }else{
            return response()->json([
                "status" => true,
                "reload" => true,
                // "redirect_to" => route('user'),
                "title" => "ENREGISTREMENT REUSSIE",
                "msg" => "Email non envoyé"
            ]);
        }
    }

    public function sendEmail($email1, $email2, $fullName)
    {
        $profSubject = Auth::user()->subject;
        $text = "L'élève ".$fullName." est absent(e) au cours de ".strtoupper($profSubject)."";

        // Envoyez l'e-mail avec le code généré
        Mail::send('emails.absenceEmail', ['text' => $text], function($message) use ($email1, $email2){
            $message->to($email1)
                    ->cc($email2)
                    ->subject('ABSENCIA');
        });
    }

}
