<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboad');
    }
    public function dispense_view()
    {

        $date = @$_GET['date'];
        if (isset($date)) {
            $cond = date('Y-m-d', strtotime($date));
        } else {
            $cond = date('Y-m-d');
        }

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name','p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
            ->orderBy('pb.id', 'desc')
            ->get();
        return view('reports.dispense', compact('data'));
    }
    public function dispense_pdf()
    {
        $date = request()->get('date');
        $cond = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $data = DB::table('patient_bills as pb')
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name','p.other_id')
            ->join('patients as p', function ($join) {
                $join->on('p.id', 'pb.patient_id');
            })
            ->where('pb.updated_at', 'LIKE', '%' . $cond . '%')
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
        <h2>Dispense Report for ' . $date . '</h2>
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
                                            <th>Options</th>
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
                                                    <td class="text-center" colspan="8"><b>
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
            ->select('pb.*', 'p.file_no', 'p.first_name', 'p.father_name','p.other_id')
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
}
