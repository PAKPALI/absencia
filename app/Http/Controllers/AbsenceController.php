<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{

    public function absence(Request $request)
    {
        $Classroom = Classroom::where('schools_id', Auth::user()->school_id)->get();
        return view('absence',[
            'Classroom' => $Classroom,
            // 'AllClassroom' => $AllClassroom,
            // 'Student' => $Student,
            // 'Manager' => 0,
        ]);

        // if ($request->ajax()) {
        //     if($request->month_client==1){
        //         $all_clients = CrmClients::withoutTrashed()->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->get();
        //     }elseif($request->year_client==1){
        //         $all_clients = CrmClients::withoutTrashed()->whereBetween('created_at', [$startOfCurrentYear, $endOfCurrentYear])->get();
        //     }
        //     return DataTables::of($all_clients)
        //         ->editColumn('contact_number', function ($creation) {
        //             return $creation->contact_number ?? '-';
        //         })
        //         ->editColumn('sites_number', function ($sites) {
        //             return $sites->sites->count();
        //         })
        //         ->editColumn('created_at', function ($creation) {
        //             return $creation->created_at->translatedFormat('d  M Y');
        //         })
        //         ->make(true);
        // }
    }
}
