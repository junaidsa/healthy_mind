<?php

namespace App\Http\Controllers;
// https://github.com/niklasravnsborg/laravel-pdf
use PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Barryvdh\DomPDF\PDF;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboad');
    }
    public function dispense_view(Request $request)
    {
        // $search = @$_GET['search'];

        // $date = @$_GET['date'];
        // if (isset($date)) {
        //     $cond = date('Y-m-d', strtotime($date));
        // } else {
        //     $cond = date('Y-m-d');
        // }

        // $data = DB::table('patient_bills as pb')
        //     ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
        //     ->join('patients as p', function ($join) {
        //         $join->on('p.id', 'pb.patient_id');
        //     })
        //     ->where(function ($q) use ($search) {
        //         if (!empty($search)) {
        //             $q->where('pb.bill_no', 'like', '%' . $search . '%')
        //                 ->orWhere('p.first_name', 'like', '%' . $search . '%')
        //                 ->orWhere('p.father_name', 'like', '%' . $search . '%')
        //                 ->orWhere('p.other_id', 'like', '%' . $search . '%')
        //                 ->orWhere('p.file_no', 'like', '%' . $search . '%');
        //         }
        //     })
        //     ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
        //     ->orderBy('pb.id', 'desc')
        //     ->get();


        $search = $request->get('search', '');
        $date = $request->get('date');
        $cond = isset($date) ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.uid_number')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where(function ($q) use ($search) {
                if (!empty($search)) {
                    $q->where('pb.bill_no', 'like', '%' . $search . '%')
                        ->orWhere('p.first_name', 'like', '%' . $search . '%')
                        ->orWhere('p.father_name', 'like', '%' . $search . '%')
                        ->orWhere('p.other_id', 'like', '%' . $search . '%')
                        ->orWhere('p.file_no', 'like', '%' . $search . '%');
                }
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();
            if($request->ajax()){
                $last_batches = [];
                 $result = [];
                 foreach($data as $row){

                     $bill_items = DB::table('bill_items')
                     ->where('bill_id', $row->id)
                     ->orderBy('medicine_id')
                     ->orderBy('batch_no')
                     ->get();
                     $batch_notifications = [];
                     foreach ($bill_items as $item) {
                         if (isset($last_batches[$item->medicine_id]) && $last_batches[$item->medicine_id] != $item->batch_no){
                            $med_name = DB::table('medicines')
                                ->where('id', $item->medicine_id)
                                ->first();
                                $batch_notifications[] = [
                                    'medicine_name' => $med_name->name,
                                    'batch_no' => $item->batch_no,
                                ];
                            }
                            $last_batches[$item->medicine_id] = $item->batch_no;
                     }
                     $med_qty = $bill_items->sum('qty');
                     $result[] = [
                        'bill_id' => $row->id,
                        'bill_no' => $row->bill_no,
                        'file_no' => $row->file_no,
                        'first_name' => $row->first_name,
                        'father_name' => $row->father_name,
                        'other_id' => $row->uid_number,
                        'med_qty' => $med_qty,
                        'batch_notifications' => $batch_notifications
                    ];
                 }
                return response()->json($result);
            }
        return view('reports.dispense', compact('data'));
    }
    // public function fatchDispense(Request $request){




    // }
    public function billbook_view(Request $request)
    {

    if ($request->ajax()) {
    $start_date = '';
    $end_date = '';
    $search = $request->input('search', '');
    $date = $request->input('date', '');
    // dd($date);

    if (!empty($date)) {
        $date_part = explode(' to ', $date);
        $start_date = date('Y-m-d', strtotime($date_part[0]));
        $end_date = isset($date_part[1]) ? date('Y-m-d', strtotime($date_part[1])) : $start_date;
    }

    $query = DB::table('patient_bills as pb')
    ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.uid_number', 'p.Image', 'p.date_of_birth',
    DB::raw('(SELECT SUM(bi.qty) FROM bill_items as bi WHERE bi.bill_id = pb.id) as med_qty'))
        ->join('patients as p', 'p.id', '=', 'pb.patient_id')
        ->where(function ($q) use ($search) {
            if (!empty($search)) {
                $q->where('pb.bill_no', 'like', '%' . $search . '%')
                  ->orWhere('p.first_name', 'like', '%' . $search . '%')
                  ->orWhere('p.father_name', 'like', '%' . $search . '%')
                  ->orWhere('p.uid_number', 'like', '%' . $search . '%')
                  ->orWhere('p.date_of_birth', 'like', '%' . $search . '%')
                  ->orWhere('pb.total_amount', 'like', '%' . $search . '%')
                  ->orWhere('p.file_no', 'like', '%' . $search . '%');
            }
        })
        ->where(function ($q) use ($start_date, $end_date) {
            if (!empty($start_date)) {
                $q->where('pb.updated_at', '>=', $start_date . ' 00:00:00')
                  ->where('pb.updated_at', '<=', $end_date . ' 23:59:59');
            }
        })
        ->orderBy('pb.id', 'desc');
        $data = $query->get();
        // dd($data);
        return response()->json($data);
    }
    return view('reports.billbook');
    }
    public function stockBook_view()
    {
        $date = @$_GET['date'];
        if (isset($date)) {
            $cond = date('Y-m-d', strtotime($date));
        } else {
            $cond = date('Y-m-d');
        }

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();

        $medicnes = DB::table('medicines')->whereNull('deleted_at')->get();
        return view('reports.stockBook', compact('data', 'medicnes'));
    }
    public function dispense_pdf()
    {
        $date = request()->get('date');
        $cond = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();
        $pdf_date = isset($date) ? date('d M Y', strtotime($date)) : date('d M Y');
        $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Dispense Report</title>
        <style>
            body {
                font-size: 12px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h2>Dispense Report for: ' . $pdf_date . '</h2>
        <table>
            <thead>
                <tr>
                    <th>S.No.</th>
                                            <th>Bill No.</th>
                                            <th>File No.</th>
                                            <th>Name</th>
                                            <th>Father\'s Name</th>
                                            <th>Aadhar Number</th>
                                            <th>Medicine</th>
                </tr>
            </thead>
            <tbody>';
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $batch_notifications = [];

            foreach ($bill_items as $item) {
                if (
                    isset($last_batches[$item->medicine_id]) &&
                    $last_batches[$item->medicine_id] != $item->batch_no
                ) {
                    $med_name = DB::table('medicines')
                        ->where('id', $item->medicine_id)
                        ->first();
                    $batch_notifications[] = [
                        'medicine_name' => $med_name->name,
                        'batch_no' => $item->batch_no,
                    ];
                }
                $last_batches[$item->medicine_id] = $item->batch_no;
            }
            $med_qty = $bill_items->sum('qty');
            foreach ($batch_notifications as $change) {
                $html .=  '<tr class="batch-info">
                                                    <td colspan="7" style="text-align: center;"><b>
                                                            ' . $change['medicine_name'] . ' Batch Changed:
                                                            ' . $change['batch_no'] . '</b></td>
                                                </tr>';
            }
            $html .= '<tr>
                        <td>' . @$sr++ . '</td>
                        <td>' . @$row->bill_no . '</td>
                        <td>' . @$row->file_no . '</td>
                        <td>' . @$row->first_name . '</td>
                        <td>' . @$row->father_name . '</td>
                        <td>' . @$row->other_id . '</td>
                        <td>' . $med_qty . '</td>
                    </tr>';
        }
        $html .= '</tbody>
        </table>
    </body>
    </html>';

        $pdf = PDF::loadHTML($html);
        return $pdf->stream('dispense.pdf');
    }
    public function stockbook_pdf()
    {
        $date = request()->get('date');
        $cond = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $medicnes = DB::table('medicines')->whereNull('deleted_at')->get();

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();
        $pdf_date = isset($date) ? date('d M Y', strtotime($date)) : date('d M Y');
        $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Dispense Report</title>
        <style>
            body {
                font-size: 12px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h2>Stock Book Report for: ' . $pdf_date . '</h2>
        <table>
            <tbody>';
        foreach ($medicnes as $med) {
            $open_stock = DB::table('stock_history')->where('medicine_id', $med->id)->where('date', date('Y-m-d'))->first();
            $current_stock = DB::table('batches')->where('quantity', '>', '0')->where('medicine_id', $med->id)->sum('quantity');


              $currentDate = date('Y-m-d');
                                $check_date = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'].' - 1 day')) : date('Y-m-d',strtotime( $currentDate.' - 1 day'));
                                $check_date2 = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d',strtotime( $currentDate));
                                    $check_time1=DB::table('bill_items')->where('medicine_id', $med->id)->whereDate('created_at', $check_date2)->orderBy('id','asc')->first();

                                    $check_time=$check_date2.' 23:59:59';
                                    $open_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_time )->orderBy('id','desc')->sum('stock');




                                    $open_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $opening_balence = $open_stock - $open_sold;
                                    $close_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('stock');
                                    $close_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $closing_balence = $close_stock - $close_sold;


            $html .= '<tr>
                                    <td class="fw-bold" style="width: 20%">' . $med->name . '</td>
                                    <td style="width: 20%">Opening: <span class="fw-bold">' . @$opening_balence . '</span></td>
                                    <td style="width: 20%">Closing: <span class="fw-bold">' .@$opening_balence - $closing_balence. '</span></td>
                                    <td style="width: 40%">Left: <span class="fw-bold">' .  $closing_balence . '</span></td>
                                </tr>';
        }
        $html .= '</tbody>
            </table>
        <table>
            <thead>
                <tr>
                    <th>S.No.</th>
                                            <th>Bill No.</th>
                                            <th>File No.</th>
                                            <th>Name</th>
                                            <th>Father\'s Name</th>
                                            <th>Aadhar Number</th>
                                            <th>Medicine</th>
                </tr>
            </thead>
            <tbody>';
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $batch_notifications = [];

            foreach ($bill_items as $item) {
                if (
                    isset($last_batches[$item->medicine_id]) &&
                    $last_batches[$item->medicine_id] != $item->batch_no
                ) {
                    $med_name = DB::table('medicines')
                        ->where('id', $item->medicine_id)
                        ->first();
                    $batch_notifications[] = [
                        'medicine_name' => $med_name->name,
                        'batch_no' => $item->batch_no,
                    ];
                }
                $last_batches[$item->medicine_id] = $item->batch_no;
            }
            $med_qty = $bill_items->sum('qty');
            foreach ($batch_notifications as $change) {
                $html .=  '<tr class="batch-info">
                                                    <td colspan="7" style="text-align: center;"><b>
                                                            ' . $change['medicine_name'] . ' Batch Changed:
                                                            ' . $change['batch_no'] . '</b></td>
                                                </tr>';
            }
            $html .= '<tr>
                        <td>' . @$sr++ . '</td>
                        <td>' . @$row->bill_no . '</td>
                        <td>' . @$row->file_no . '</td>
                        <td>' . @$row->first_name . '</td>
                        <td>' . @$row->father_name . '</td>
                        <td>' . @$row->other_id . '</td>
                        <td>' . $med_qty . '</td>
                    </tr>';
        }
        $html .= '</tbody>
        </table>
    </body>
    </html>';

        $pdf = PDF::loadHTML($html);
        return $pdf->stream('dispense.pdf');
    }

    public function dispense_excel()
    {
        $date = request()->get('date');
        $cond = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();


        // Define CSV file name
        $filename = 'dispense_' . date('YmdHis') . '.csv';

        // Define CSV headers
        $headers = [
            'S.No.',
            'Bill No.',
            'File No.',
            'Name',
            'Father\'s Name',
            'Aadhar Number',
            'Medicine',
        ];

        // Prepare CSV content
        $csvContent = implode(',', $headers) . "\n"; // Add headers as the first line

        // Prepare CSV rows
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $batch_notifications = [];

            foreach ($bill_items as $item) {
                if (isset($last_batches[$item->medicine_id]) && $last_batches[$item->medicine_id] != $item->batch_no) {
                    $med_name = DB::table('medicines')
                        ->where('id', $item->medicine_id)
                        ->first();
                    $batch_notifications[] = $med_name->name . ' Batch Changed: ' . $item->batch_no;
                }
                $last_batches[$item->medicine_id] = $item->batch_no;
            }
            $med_qty = $bill_items->sum('qty');

            // Add main row for each patient bill
            $csvContent .= '"' . $sr++ . '","' . $row->bill_no . '","' . $row->file_no . '","' . $row->first_name . '","' . $row->father_name . '","' . $row->other_id . '","' . $med_qty . '"';

            if (!empty($batch_notifications)) {
                $csvContent .= ',"' . implode('; ', $batch_notifications) . '"';
            }

            $csvContent .= "\n";
        }
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output CSV content
        echo $csvContent;
        exit;
    }
    public function stockbook_excel(Request $request)
    {
        $date = request()->get('date');
        $cond = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();


        // Define CSV file name
        $filename = 'dispense_' . date('YmdHis') . '.csv';
        $medicnes = DB::table('medicines')->whereNull('deleted_at')->get();

        foreach ($medicnes as $med) {
             $currentDate = date('Y-m-d');
                                $check_date = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'].' - 1 day')) : date('Y-m-d',strtotime( $currentDate.' - 1 day'));
                                $check_date2 = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d',strtotime( $currentDate));
                                    $check_time1=DB::table('bill_items')->where('medicine_id', $med->id)->whereDate('created_at', $check_date2)->orderBy('id','asc')->first();

                                    $check_time=$check_date2.' 23:59:59';
                                    $open_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_time )->orderBy('id','desc')->sum('stock');




                                    $open_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $opening_balence = $open_stock - $open_sold;
                                    $close_stock = DB::table('medicine_history')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('stock');
                                    $close_sold = DB::table('bill_items')->where('medicine_id', $med->id)->where('created_at','<=', $check_date2.' 23:59:59')->orderBy('id','desc')->sum('qty');
                                    $closing_balence = $close_stock - $close_sold;


            $csvContent = '"' . $med->name . '","Opening: ","' . @$opening_balence . '","Closing:","' .@$opening_balence - $closing_balence   . '","Left:","' . $closing_balence . '"' . "\n";
        }

        // Define CSV headers
        $headers = [
            'S.No.',
            'Bill No.',
            'File No.',
            'Name',
            'Father\'s Name',
            'Aadhar Number',
            'Medicine',
        ];

        // Prepare CSV content
        $csvContent .= implode(',', $headers) . "\n"; // Add headers as the first line

        // Prepare CSV rows
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $batch_notifications = [];

            foreach ($bill_items as $item) {
                if (isset($last_batches[$item->medicine_id]) && $last_batches[$item->medicine_id] != $item->batch_no) {
                    $med_name = DB::table('medicines')
                        ->where('id', $item->medicine_id)
                        ->first();
                    $batch_notifications[] = $med_name->name . ' Batch Changed: ' . $item->batch_no;
                }
                $last_batches[$item->medicine_id] = $item->batch_no;
            }
            $med_qty = $bill_items->sum('qty');

            // Add main row for each patient bill
            $csvContent .= '"' . $sr++ . '","' . $row->bill_no . '","' . $row->file_no . '","' . $row->first_name . '","' . $row->father_name . '","' . $row->other_id . '","' . $med_qty . '"';

            if (!empty($batch_notifications)) {
                $csvContent .= ',"' . implode('; ', $batch_notifications) . '"';
            }

            $csvContent .= "\n";
        }
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output CSV content
        echo $csvContent;
        exit;
    }


    public function deleteBill($id)
    {
        $bill_items = DB::table('bill_items')->where('bill_id', $id)->get();
        // dd($bill_items);
        if (count($bill_items) > 0) {
            foreach ($bill_items as $item) {
                DB::table('batches')->where('medicine_id', $item->medicine_id)->where('quantity', '>', '0')->increment('quantity', $item->qty);
            }
        }
        DB::table('patient_bills')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Bill Deleted');
    }


    public function billbook_pdf(Request $request)
    {
        $start_date = '';
        $end_date = '';
        $search = $request->input('search_data');

        $date = $request->input('date_data');
        if (isset($date)) {
            $date_part = explode(' to ', $date);

            // Check if $date_part has at least one part
            if (count($date_part) >= 1) {
                $start_date = date('Y-m-d', strtotime($date_part[0]));
                $end_date = isset($date_part[1]) ? date('Y-m-d', strtotime($date_part[1])) : date('Y-m-d');
            } else {
                // Handle the error if date range is not correctly formatted
                return response()->json(['error' => 'Invalid date range format. Please use "YYYY-MM-DD to YYYY-MM-DD".'], 400);
            }
        } else {
            // If no date is provided, set both start_date and end_date to the current date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }


        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id', 'p.Image', 'p.date_of_birth')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where(function ($q) use ($search) {
                if (!empty($search)) {
                    $q->where('pb.bill_no', 'like', '%' . $search . '%')
                        ->orWhere('p.first_name', 'like', '%' . $search . '%')
                        ->orWhere('p.father_name', 'like', '%' . $search . '%')
                        ->orWhere('p.other_id', 'like', '%' . $search . '%')
                        ->orWhere('p.date_of_birth', 'like', '%' . $search . '%')
                        ->orWhere('pb.total_amount', 'like', '%' . $search . '%')
                        ->orWhere('p.file_no', 'like', '%' . $search . '%');
                }
            })
            ->where(function ($q) use ($date, $start_date, $end_date) {
                if (!empty($date)) {
                    $q->where('pb.updated_at', '>=', $start_date . ' 00:00:00')
                        ->where('pb.updated_at', '<=', $end_date . ' 23:59:59');
                }
            })
            ->orderBy('pb.id', 'desc')
            ->get();
        $html = '<!DOCTYPE html>
    <html>
    <head>
        <title>Dispense Report</title>
        <style>
            body {
                font-size: 12px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h2>Bill Book Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Bill No.</th>
                                            <th>File No.</th>
                                            <th>Name</th>
                                            <th>Father\'s Name</th>
                                            <th>Age</th>
                                            <th>Aadhar Number</th>
                                            <th>Medicine</th>
                                            <th>Amount</th>
                </tr>
            </thead>
            <tbody>';
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $med_qty = $bill_items->sum('qty');
            $html .= '<tr>
                        <td>' . @$row->bill_no . '</td>
                        <td>' . @$row->file_no . '</td>
                        <td>' . @$row->first_name . '</td>
                        <td>' . @$row->father_name . '</td>
                        <td>' . @$row->date_of_birth . '</td>
                        <td>' . @$row->other_id . '</td>
                        <td>' . @$med_qty . '</td>
                        <td>' . @$row->total_amount . '</td>
                    </tr>';
        }
        $html .= '</tbody>
        </table>
    </body>
    </html>';

        $pdf = PDF::loadHTML($html);
        return $pdf->stream('Billbook.pdf');
    }

    public function billbook_excel(Request $request)
    {
        // $start_date = '';
        // $end_date = '';
        // $search = @$_GET['search'];

        // $date = @$_GET['date'];
        // if (isset($date)) {
        //     $date_part = explode(' to ', $date);
        //     // dd($date_part);

        //     $start_date = date('Y-m-d', strtotime($date_part[0]));
        //     $end_date = date('Y-m-d', strtotime($date_part[1]));
        // }
        $start_date = '';
        $end_date = '';
        $search = $request->input('search_data');

        $date = $request->input('date_data');
        if (isset($date)) {
            $date_part = explode(' to ', $date);

            // Check if $date_part has at least one part
            if (count($date_part) >= 1) {
                $start_date = date('Y-m-d', strtotime($date_part[0]));
                $end_date = isset($date_part[1]) ? date('Y-m-d', strtotime($date_part[1])) : date('Y-m-d');
            } else {
                // Handle the error if date range is not correctly formatted
                return response()->json(['error' => 'Invalid date range format. Please use "YYYY-MM-DD to YYYY-MM-DD".'], 400);
            }
        } else {
            // If no date is provided, set both start_date and end_date to the current date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name', 'p.other_id', 'p.Image', 'p.date_of_birth')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where(function ($q) use ($search) {
                if (!empty($search)) {
                    $q->where('pb.bill_no', 'like', '%' . $search . '%')
                        ->orWhere('p.first_name', 'like', '%' . $search . '%')
                        ->orWhere('p.father_name', 'like', '%' . $search . '%')
                        ->orWhere('p.other_id', 'like', '%' . $search . '%')
                        ->orWhere('p.date_of_birth', 'like', '%' . $search . '%')
                        ->orWhere('pb.total_amount', 'like', '%' . $search . '%')
                        ->orWhere('p.file_no', 'like', '%' . $search . '%');
                }
            })
            ->where(function ($q) use ($date, $start_date, $end_date) {
                if (!empty($date)) {
                    $q->where('pb.updated_at', '>=', $start_date . ' 00:00:00')
                        ->where('pb.updated_at', '<=', $end_date . ' 23:59:59');
                }
            })
            ->orderBy('pb.id', 'desc')
            ->get();


        // Define CSV file name
        $filename = 'billbook_' . date('YmdHis') . '.csv';

        // Define CSV headers
        $headers = [
            'Bill No.',
            'File No.',
            'Name',
            'Father\'s Name',
            'Age',
            'Aadhar Number',
            'Medicine',
            'Amount',
        ];

        // Prepare CSV content
        $csvContent = implode(',', $headers) . "\n"; // Add headers as the first line

        // Prepare CSV rows
        $sr = 1;
        foreach ($data as $row) {
            $bill_items = DB::table('bill_items')
                ->where('bill_id', $row->id)
                ->orderBy('medicine_id')
                ->orderBy('batch_no')
                ->get();
            $med_qty = $bill_items->sum('qty');

            // Add main row for each patient bill
            $csvContent .= '"' . $row->bill_no . '","' . $row->file_no . '","' . $row->first_name . '","' . $row->father_name . '","' . $row->date_of_birth . '","' . $row->other_id . '","' . $med_qty . '","' . $row->total_amount . ' ₹"';


            $csvContent .= "\n";
        }
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output CSV content
        echo $csvContent;
        exit;
    }

    // public function showPrint_(Request $request)
    // {
    //     $startField = $request->start_field;
    //     $endField = $request->end_field;
    //     $selected_ids = $request->selected_ids;

    //     preg_match('/([A-Z]+)-(\d+)/', $startField, $startMatches);
    //     preg_match('/([A-Z]+)-(\d+)/', $endField, $endMatches);

    //     $startPrefix = $startMatches[1];
    //     $startNumber = (int)$startMatches[2];
    //     $endPrefix = $endMatches[1];
    //     $endNumber = (int)$endMatches[2];
    //     $bills = DB::table('patient_bills')
    //         ->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
    //             $query->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
    //                 $query->where('bill_no', 'like', "$startPrefix%")
    //                     ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber])
    //                     ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
    //             });

    //             if ($startPrefix != $endPrefix) {
    //                 $query->orWhere(function ($query) use ($startPrefix, $startNumber) {
    //                     $query->where('bill_no', 'like', "$startPrefix%")
    //                         ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber]);
    //                 });

    //                 $query->orWhere(function ($query) use ($endPrefix, $endNumber) {
    //                     $query->where('bill_no', 'like', "$endPrefix%")
    //                         ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
    //                 });
    //             }
    //         })
    //         ->get();
    //     if ($bills) {
    //         $dateTime = Carbon::now();
    //         $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
    //         // $bill_item = DB::table('bill_items')->where('bill_id', $id)->get();
    //         return view('reports.batch_print', compact('bills', 'formattedDateTime'));
    //     }
    //     abort(404);
    // }
    public function showPrint_(Request $request)
{
    $startField = $request->start_field;
    $endField = $request->end_field;
    $selectedIds = $request->selected_ids;
    $duplicate = $request->duplicate;

    $billsByRange = collect();
    $billsByIds = collect();

    if (!empty($startField) && !empty($endField)) {
        preg_match('/([A-Z]+)-(\d+)/', $startField, $startMatches);
        preg_match('/([A-Z]+)-(\d+)/', $endField, $endMatches);

        $startPrefix = $startMatches[1];
        $startNumber = (int)$startMatches[2];
        $endPrefix = $endMatches[1];
        $endNumber = (int)$endMatches[2];

        $billsByRange = DB::table('patient_bills')
            ->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
                $query->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
                    $query->where('bill_no', 'like', "$startPrefix%")
                        ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber])
                        ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
                });

                if ($startPrefix != $endPrefix) {
                    $query->orWhere(function ($query) use ($startPrefix, $startNumber) {
                        $query->where('bill_no', 'like', "$startPrefix%")
                            ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber]);
                    });

                    $query->orWhere(function ($query) use ($endPrefix, $endNumber) {
                        $query->where('bill_no', 'like', "$endPrefix%")
                            ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
                    });
                }
            })
            ->get();
    }

    if (!empty($selectedIds)) {
        $billsByIds = DB::table('patient_bills')
            ->whereIn('id', $selectedIds)
            ->get();
    }

    $bills = $billsByRange->merge($billsByIds)->unique('id');

    if ($bills->isNotEmpty()) {
        $dateTime = Carbon::now();
        $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
        return view('reports.batch_print', compact('bills', 'duplicate','formattedDateTime'));
    }

    abort(404);
}

    public function billPDF(Request $request)
    {
        $startField = $request->start_field;
    $endField = $request->end_field;
    $selectedIds = $request->selected_ids;
    $duplicate = $request->duplicate;

    $billsByRange = collect();
    $billsByIds = collect();

    if (!empty($startField) && !empty($endField)) {
        preg_match('/([A-Z]+)-(\d+)/', $startField, $startMatches);
        preg_match('/([A-Z]+)-(\d+)/', $endField, $endMatches);

        $startPrefix = $startMatches[1];
        $startNumber = (int)$startMatches[2];
        $endPrefix = $endMatches[1];
        $endNumber = (int)$endMatches[2];

        $billsByRange = DB::table('patient_bills')
            ->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
                $query->where(function ($query) use ($startPrefix, $startNumber, $endPrefix, $endNumber) {
                    $query->where('bill_no', 'like', "$startPrefix%")
                        ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber])
                        ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
                });

                if ($startPrefix != $endPrefix) {
                    $query->orWhere(function ($query) use ($startPrefix, $startNumber) {
                        $query->where('bill_no', 'like', "$startPrefix%")
                            ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) >= ?", [$startNumber]);
                    });

                    $query->orWhere(function ($query) use ($endPrefix, $endNumber) {
                        $query->where('bill_no', 'like', "$endPrefix%")
                            ->whereRaw("CAST(SUBSTRING_INDEX(bill_no, '-', -1) AS UNSIGNED) <= ?", [$endNumber]);
                    });
                }
            })
            ->get();
    }

    if (!empty($selectedIds)) {
        $billsByIds = DB::table('patient_bills')
            ->whereIn('id', $selectedIds)
            ->get();
    }

    $bills = $billsByRange->merge($billsByIds)->unique('id');

            $dateTime = Carbon::now();
            $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
        $pdf = $pdf = PDF::loadView('reports.pdf', compact('bills','formattedDateTime', 'duplicate'), [],[
            'format' => 'A3','isRemoteEnabled'=>true
          ]);
        return $pdf->stream('bill.pdf');
    }
}
