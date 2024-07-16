<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboad');
    }
    public function dispense_view(){

        $data = DB::table('patient_bills as pb')
        ->select('pb.*','p.file_no','p.first_name','p.father_name')
        ->join('patients as p', function($join) {
            $join->on('p.id','pb.patient_id');
        })
        ->where('pb.updated_at','LIKE','%'. date('Y-m-d') .'%')
        ->orderBy('pb.id','desc')
        ->get();
        return view('reports.dispense', compact('data'));
    }
}
