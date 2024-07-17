<?php

namespace App\Http\Controllers;
// https://github.com/niklasravnsborg/laravel-pdf
use PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboad');
    }
    public function dispense_view()
    {
        $search = @$_GET['search'];

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
        return view('reports.dispense', compact('data'));
    }
    public function billbook_view(Request $request)
    {
        $start_date = '';
        $end_date = '';
        $search = @$_GET['search'];

        $date = @$_GET['date'];
        if (isset($date)) {
            $date_part = explode(' to ', $date);

            $start_date = date('Y-m-d', strtotime($date_part[0]));
            $end_date = isset($date_part[1]) ? date('Y-m-d', strtotime($date_part[1])) : '';
            if(empty($end_date)){
                $end_date =  $start_date;
            }
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
        return view('reports.billbook', compact('data'));
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
            $html .= '<tr>
                                    <td class="fw-bold" style="width: 20%">' . $med->name . '</td>
                                    <td style="width: 20%">Opening: <span class="fw-bold">' . $open_stock->qty . '</span></td>
                                    <td style="width: 20%">Closing: <span class="fw-bold">' . $current_stock . '</span></td>
                                    <td style="width: 40%">Left: <span class="fw-bold">' . $open_stock->qty - $current_stock . '</span></td>
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
    public function stockbook_excel()
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
            $open_stock = DB::table('stock_history')->where('medicine_id', $med->id)->where('date', date('Y-m-d'))->first();
            $current_stock = DB::table('batches')->where('quantity', '>', '0')->where('medicine_id', $med->id)->sum('quantity');

            $csvContent = '"' . $med->name . '","Opening: ","' . $open_stock->qty . '","Closing:","' . $current_stock . '","Left:","' . $open_stock->qty - $current_stock . '"' . "\n";
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


    public function billbook_pdf()
    {
        $start_date = '';
        $end_date = '';
        $search = @$_GET['search'];

        $date = @$_GET['date'];
        if (isset($date)) {
            $date_part = explode(' to ', $date);
            // dd($date_part);

            $start_date = date('Y-m-d', strtotime($date_part[0]));
            $end_date = date('Y-m-d', strtotime($date_part[1]));
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

    public function billbook_excel()
    {
        $start_date = '';
        $end_date = '';
        $search = @$_GET['search'];

        $date = @$_GET['date'];
        if (isset($date)) {
            $date_part = explode(' to ', $date);
            // dd($date_part);

            $start_date = date('Y-m-d', strtotime($date_part[0]));
            $end_date = date('Y-m-d', strtotime($date_part[1]));
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
