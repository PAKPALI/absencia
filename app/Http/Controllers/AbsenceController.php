<?php

namespace App\Http\Controllers;

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
        return view('absence',[
            'Classroom' => $Classroom,
        ]);
    }

    public function showListAbsence(Request $request)
    {
        if ($request->ajax()) {
            if($request->classId!==0 && $request->date1!==0 && $request->date2!==0){
                $class_id = $request->classId;
                $date1 = $request->date1;
                $date2 = $request->date2;
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
                    return $Absences->created_at->translatedFormat('d  M Y');
                })
                ->make(true);
        }
    }
}
