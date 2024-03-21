<?php

namespace App\Http\Controllers;

use App\Models\Absence;
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
        $Student = Student::where('classrooms_id', $classroom_id)->get();
        if(request()->ajax()){
            // $Student = Student::all();
            return DataTables::of($Student)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-update"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editStudent">M</a>'.
                    $btn = ' <a data-id="'.$row->id.'" data-name="'.$row->fullName().'" data-original-title="Edit" class="btn btn-dark btn-sm absent">AB?</a>'.
                    $btn = ' <a data-id="'.$row->id.'" data-original-title="Archiver" class="btn btn-danger btn-sm archive">AC?</a>';
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
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "email2.unique" => "L'email ".$request-> email2. " existe déjà!",
            // "num1.numeric" => "Remplir le champ Numéro 1 avec des chiffres!",
            // "num2.numeric" => "Remplir le champ Numéro 2 avec des chiffres!",
            "gender.required" => "Sélectionnez le genre!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['unique:students'],
            'email' => ['unique:students'],
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
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            "email2.unique" => "L'email ".$request-> email2. " existe déjà!",
            "email.unique" => "L'email ".$request-> email. " existe déjà!",
            // "email2.unique" => "L'email ".$request-> email. " existe déjà!",
            // "num1.numeric" => "Remplir le champ Numéro 1 avec des chiffres!",
            // "num2.numeric" => "Remplir le champ Numéro 2 avec des chiffres!",
            "gender.required" => "Sélectionnez le genre!",
        ];

        $validator = Validator::make($request->all(),[
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['unique:students'],
            'email' => ['unique:students'],
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
        $authUserSchoolId = Auth::user()->school_id;
        $search = Student::find($id);
        $this->addAbsent($id,$authUserSchoolId);
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
            if ($email1) {
                $message->to($email1);
            }
            
            if ($email2){
                $message->cc($email2);
            }
            $message->subject('ABSENCIA');
        });
    }

    public function addAbsent($student_id, $school_id)
    {
        Absence::create([
            'students_id' => $student_id,
            'schools_id' => $school_id,
        ]);
        $search = Student::find($student_id);
        $currentAbsence = $search->absence;
        $absenceUpdate = $currentAbsence + 1;
        $search -> update([
            'absence' => $absenceUpdate,
        ]);
    }

    public function moove(Request $request)
    {
        $error_messages = [
            "classroom.required" => "Sélectionnez la classe!",
            "student.required" => "Sélectionnez au moins un étudiant!",
        ];

        $validator = Validator::make($request->all(),[
            'classroom' => ['required'],
            'student' => ['required'],
        ], $error_messages);

        if($validator->fails())
            return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "TRANSFERT ERRONE".$request-> student."f",
                "msg" => $validator->errors()->first()
            ]);

        // $students = explode(',', $request-> student);
        $students = $request-> student;
        $Classroom = Classroom::find($request->classroom);
        foreach ($students as $studentId) {
            // Find student
            $student = Student::find($studentId);
        
            // verify if student exist
            if ($student) {
                // update student classroom id
                $student->update([
                    'classrooms_id' => $request->classroom,
                    'absence' => 0,
                ]);
            }
        }
        return response()->json([
            "status" => true,
            "reload" => true,
            // "redirect_to" => route('user'),
            "title" => "TRANSFERT REUSSI",
            "msg" => "Transfert réussi vers la classe ".$Classroom->name
        ]);
    }

}
