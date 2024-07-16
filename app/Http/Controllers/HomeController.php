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
        ->join('patients as p', function($join) {
            $join->on('p.id','pb.patient_id');
        })
        ->where('pb.updated_at','LIKE','%'. date('Y-m-d') .'%')
        ->orderBy('pb.id','desc')
        ->get();

        // dd($data);
        return view('reports.dispense', compact('data'));
    }
}
