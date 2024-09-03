<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absence;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AbsenceController extends Controller
{

    public function absence(Request $request)
    {
        $Classroom = Classroom::where('schools_id', Auth::user()->school_id)->get();
        $userId = Auth::user()->id;

        $classroomManager = Classroom::where('manager', $userId)->first();
        $classroomProfessor = Classroom::whereRaw("FIND_IN_SET($userId, professor)")->get();
        return view('absence',[
            'Classroom' => $Classroom,
            'classroomManager' => $classroomManager,
            'classroomProfessor' => $classroomProfessor,
        ]);
    }

    public function showListAbsence(Request $request)
    {
        if ($request->ajax()) {
            if($request->classId && $request->date1 && $request->date2){
                $class_id = $request->classId;
                $date1 = Carbon::createFromFormat('d/m/Y', $request->date1)->format('Y-m-d');
                $date2 = Carbon::createFromFormat('d/m/Y', $request->date2)->format('Y-m-d 23:59:59');
                $Absences = Absence::where('classrooms_id',$class_id)->whereBetween('created_at', [$date1, $date2])->latest()->get();
            }else{
                $Absences = Absence::where('schools_id',Auth::user()->school_id)->latest()->get();
            }
            return DataTables::of($Absences)
                ->editColumn('classrooms_id', function ($Absences) {
                    return $Absences->classroom->name;
                })
                ->editColumn('students_id', function ($Absences) {
                    return $Absences->student->fullName();
                })
                ->editColumn('created_at', function ($Absences) {
                    return $Absences->created_at->format('d-m-Y H:i:s');
                })
                ->make(true);
        }
    }
}
