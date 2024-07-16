<?php

namespace App\Http\Controllers;

use App\Models\DemoItem;
use App\Models\Batche;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientBills;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;
use Illuminate\Support\Facades\Validator;



class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keywords = request('keywords');
        $patients = Patient::where('first_name', 'like', "%$keywords%")
            ->orWhere('father_name', 'like', "%$keywords%")
            ->orWhere('uid_number', 'like', "%$keywords%")->paginate(10);
        return view('patient.view', compact('patients'));
    }
    public function create()
    {
        $dateTime = Carbon::now();
        $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
        $latestPatient = Patient::latest('id')->first();
        if ($latestPatient) {
            $latestId = $latestPatient->id + 1;
            if ($latestId < 10) {
                $fileNo = 'NPC-0' . $latestId;
            } else {
                $fileNo = 'NPC-' . $latestId;
            }
        } else {
            $fileNo = 'NPC-01';
        }
        return view('patient.create', compact("formattedDateTime", 'fileNo'));
    }
    public function CreateBill($id)
    {
        $medicines = Medicine::all();

        $patient = Patient::find($id);
        $dateTime = Carbon::now();
        $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
        $latestBill_id = PatientBills::latest('id')->first();
        if ($latestBill_id) {
            $latestId = $latestBill_id->id + 1;
            if ($latestId < 10) {
                $bill_No = 'AB-0' . $latestId;
            } else {
                $bill_No = 'AB-' . $latestId;
            }
        } else {
            $bill_No = 'AB-01';
        }
        $uniquePageNumber = mt_rand(10000000, 99999999);


        return view('patient.create_bill', compact("patient", 'formattedDateTime', 'bill_No', 'medicines', 'uniquePageNumber'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_no' => 'required',
            'registration_date' => 'required',
            'first_name' => 'required',
            'data_of_birth' => 'required',
            'gender' => 'required',
            'uid_number' => 'required',
            'mobile_no' => 'required',
            'address' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file = null;
        if ($request->hasFile('photo')) {
            $document = $request->file('photo');
            $name = now()->format('Y-m-d_H-i-s') . '-Photo';
            $file = $name . '.' . $document->getClientOriginalExtension();
            $targetDir = public_path('./media/photos');
            $document->move($targetDir, $file);
        }
        if ($validated) {
            $patient = new Patient();
            $patient->file_no = $request->input('file_no');
            $patient->registration_date = $request->input('registration_date');
            $patient->first_name = $request->input('first_name');
            $patient->father_name = $request->input('father_name');
            $patient->gender = $request->input('gender');
            $patient->date_of_birth = $request->input('data_of_birth');
            $patient->uid_number = $request->input('uid_number');
            $patient->mobile_no = $request->input('mobile_no');
            $patient->other_id = $request->input('other_id');
            $patient->alternative_no = $request->input('alternative_no');
            $patient->address = $request->input('address');
            $patient->Image = $file;
            $patient->save();
            return redirect('patients')->with('success', 'Patient add successfully.');
        } else {
            return redirect()->back()->withErrors($validated)->withInput();
        }
    }
    public function show(string $id)
    {
    }
    // public function create_demo(Request $request)
    // {
    //     $rules = [
    //         'page_no' => 'required|integer',
    //         'medicine' => 'required|integer|exists:medicines,id',
    //         'qty' => 'required|integer|min:1',
    //         'dos' => 'required|integer',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors(),
    //         ]);
    //     }

    //     $medicineId = $request->input('medicine');
    //     $requestedQty = $request->qty;

    //     $batches = Batche::where('medicine_id', $medicineId)
    //                     ->where('quantity', '>', 0)
    //                     ->orderBy('created_at')
    //                     ->get();
    //     $totalAvailableQty = $batches->sum('quantity');
    //     if ($totalAvailableQty < $requestedQty) {
    //         $validator->errors()->add('qty', 'Not enough stock available');
    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors(),
    //         ]);
    //     }
    //     $remainingQty = $requestedQty;
    //     foreach ($batches as $batch) {
    //         if ($remainingQty <= 0) {
    //             break;
    //         }

    //         $batchQty = $batch->quantity;

    //         if ($batchQty >= $remainingQty) {
    //             DB::table('temp_stock_reservations')->insert([
    //                 'page_id' => $request->page_no,
    //                 'medicine_id' => $medicineId,
    //                 'batch_id' => $batch->id,
    //                 'quantity' => $remainingQty,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //             $remainingQty = 0;
    //         } else {
    //             DB::table('temp_stock_reservations')->insert([
    //                 'page_id' => $request->page_no,
    //                 'medicine_id' => $medicineId,
    //                 'batch_id' => $batch->id,
    //                 'quantity' => $batchQty,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //             $remainingQty -= $batchQty;
    //         }
    //     }
    //     DemoItem::create([
    //         'page_id' => $request->page_no,
    //         'medicine_id' => $medicineId,
    //         'qty' => $requestedQty,
    //         'dos' => $request->dos,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Bill created successfully',
    //     ]);
    // }
    public function create_demo(Request $request)
    {
        // Validation rules
        $rules = [
            'page_no' => 'required|integer',
            'medicine' => 'required|integer|exists:medicines,id',
            'qty' => 'required|integer|min:1',
            'dos' => 'required|integer',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $medicineId = $request->input('medicine');
        $requestedQty = $request->qty;
        // $batches = Batche::where('medicine_id', $medicineId)
        //                 ->where('quantity', '>', 0)
        //                 ->orderBy('created_at')
        //                 ->get();

        $batch = DB::table('batches')
            ->where('medicine_id', $medicineId)
            ->where('quantity', '>', 0)
            ->orderBy('created_at')
            ->first();
            $addid_qty = DB::table('demo_items')->where('batch_no', $batch->batch_no)->where('medicine_id',$medicineId)->where('page_id',$request->page_no)->get();
            // dd($addid_qty);
            if (count($addid_qty) > 0) {
                $total_qty = 0;
                foreach($addid_qty as $r){
                    $total_qty = $total_qty + $r->qty;
                    $r_quantity = $r->qty;

                }
                $r_quantity2 = $batch->quantity - $total_qty;
            }
            // dd($r_quantity2);
            if(isset($r_quantity2) && $r_quantity2 <= 0){
                $pre_id = $batch->id;
                $r_quantity = 0;
                $batch = DB::table('batches')
                ->where('medicine_id', $medicineId)
                ->where('quantity', '>', 0)
                ->where('id', '!=', $pre_id)
                ->orderBy('created_at')
                ->first();
                $addid_qty = DB::table('demo_items')->where('batch_no', $batch->batch_no)->where('medicine_id',$medicineId)->where('page_id',$request->page_no)->get();
                if (count($addid_qty) > 0) {
                    foreach($addid_qty as $r1){
                        $r_quantity = $r1->qty;
                    }
                }
            }
            // dd($batch->quantity, $r_quantity);
            if(isset($r_quantity)){
                $totalAvailableQty = $batch->quantity - $r_quantity;
            } else {
                $totalAvailableQty = $batch->quantity;
            }
            // dd($batch);


            // dd($totalAvailableQty, $requestedQty);
        if ($totalAvailableQty < $requestedQty) {
            $validator->errors()->add('qty', "Batch {$batch->batch_no} has only {$totalAvailableQty} stock available");
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $tempReservations = [];
        $demoItems = [];

            $batchQty = $batch->quantity;
            if ($batchQty < $requestedQty) {
                $validator->errors()->add('qty', "Batch {$batch->batch_no} has only {$batchQty} stock available");
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            } else {
                // $reservedQty = min($batchQty, $requestedQty);
                $tempReservations[] = [
                    'page_id' => $request->page_no,
                    'medicine_id' => $medicineId,
                    'batch_id' => $batch->id,
                    // 'batch_no' => $batch->batch_no,
                    'quantity' => $requestedQty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                DB::table('temp_stock_reservations')->insert($tempReservations);
                $idd=DB::getPdo()->lastInsertId();
                // dd($idd);
                $demoItems[] = [
                    'page_id' => $request->page_no,
                    'medicine_id' => $medicineId,
                    'batch_no' => $batch->batch_no,
                    'qty' => $requestedQty,
                    'dos' => $request->dos,
                    'stock_resrve_id' => $idd,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // $requestedQty -= $reservedQty;
                DemoItem::insert($demoItems);
            }
        // Insert all demo items
        $idPage = $request->page_no;

        $totalPrice = DB::table('demo_items as di')
            ->join('medicines as m', 'di.medicine_id', '=', 'm.id')
            ->where('di.page_id', $idPage)
            ->select(DB::raw('SUM(m.rate * di.qty) as total_price'))
            ->first();
        return response()->json([
            'status' => true,
            'total_price' =>  $totalPrice,
            'message' => 'ok',
        ]);
    }





    public function edit(string $id)
    {
        // dd('ok');
        $patient = Patient::find($id);
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'file_no' => 'required',
            'registration_date' => 'required',
            'first_name' => 'required',
            'data_of_birth' => 'required',
            'gender' => 'required',
            'uid_number' => 'required',
            'mobile_no' => 'required',
            'address' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $patient = Patient::findOrFail($id);
        if ($patient) {
            $file = $patient->Image;
            if ($request->hasFile('photo')) {
                $document = $request->file('photo');
                $name = now()->format('Y-m-d_H-i-s') . '-Photo';
                $file = $name . '.' . $document->getClientOriginalExtension();
                $targetDir = public_path('./media/photos');
                $document->move($targetDir, $file);
            }
            $patient->file_no = $request->input('file_no');
            $patient->registration_date = $request->input('registration_date');
            $patient->first_name = $request->input('first_name');
            $patient->father_name = $request->input('father_name');
            $patient->gender = $request->input('gender');
            $patient->date_of_birth = $request->input('data_of_birth');
            $patient->uid_number = $request->input('uid_number');
            $patient->mobile_no = $request->input('mobile_no');
            $patient->other_id = $request->input('other_id');
            $patient->alternative_no = $request->input('alternative_no');
            $patient->address = $request->input('address');
            $patient->Image = $file;
            $patient->save();
            return redirect('patients')->with('success', 'Patient updated successfully.');
        } else {
            return redirect('patients')->with('error', 'Patient not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function docUpload(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $patient_id = $request->input('patient_id');
            $file = $document->getClientOriginalName();
            $targetDir =  public_path('./media/photos');
            $document->move($targetDir, $file);
            DB::table('documents')->insert([
                'user_id' => Auth::id(),
                'patient_id' => $patient_id,
                'file_name' => $file,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
            return back()->with('success', 'Document Upload Successfully.');
        } else {
            return back()->with('error', 'Document not upload.');
        }
    }
    public function deletedoc($id)
    {
        $document = DB::table('documents')
            ->whereNull('deleted_at')->where('id', $id)->first();
        if (@$document) {
            DB::table('documents')->where('id', $id)->update([
                'deleted_at' => now(),
            ]);
            return redirect()->back()->with('success', 'Document Deleted');
        }
        return redirect()->back()->with('error', 'Document not Found');
    }
    public function rowdeleted($id)
    {
        $row = DB::table('demo_items')->where('id', $id)->first();

        if ($row) {
            DB::table('demo_items')->where('id', $id)->delete();
            DB::table('temp_stock_reservations')->where('id', $row->stock_resrve_id)->delete();
            return response()->json([
                'status' => true,
                'successfully' => 'successfully',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'errors' => 'eroor',
            ]);
        }
    }
    public function getRow($id)
    {
        $rows = DemoItem::where('page_id', $id)->get();
        return response()->json($rows);
    }
    public function create_bill(Request $request)
    {
        try {
            $rules = [
                'page_no' => 'required|integer',
                'bill_no' => 'required',
                'patient_id' => 'required|integer|exists:patients,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }

            $print = $request->input('print');
            // dd($print);
            $pageNo = $request->input('page_no');
            $bill_No = $request->input('page_no');
            $patientId = $request->input('patient_id');
            $note = $request->input('note');
            $total = $request->input('totalPrice');
            $demoItems = DemoItem::where('page_id', $pageNo)->get();
            if ($demoItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No demo items found for the specified page',
                ]);
            }
            DB::beginTransaction();
            $dateTime = Carbon::now();
            $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
            $patientBill = PatientBills::create([
                'bill_no' => $bill_No,
                'patient_id' => $patientId,
                'bill_date' => $formattedDateTime,
                'total_amount' => $total,
                'note' => $note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $newlyCreatedId = $patientBill->id;
            foreach ($demoItems as $item) {
                DB::table('bill_items')->insert([
                    'bill_id' => $patientBill->id,
                    'medicine_id' => $item->medicine_id,
                    'batch_no' => $item->batch_no,
                    'qty' => $item->qty,
                    'dos' => $item->dos,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('batches')
                    ->where('batch_no', $item->batch_no)
                    ->decrement('quantity', $item->qty);
            }
            DemoItem::where('page_id', $pageNo)->delete();
            DB::table('temp_stock_reservations')->where('page_id', $pageNo)->delete();
            DB::commit();
            if ($print) {
                return response()->json([
                    'status' => true,
                    'id' => $newlyCreatedId,
                    'message' => 'Bill As Print created successfully',
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Bill created successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to create bill. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showPrint($id)
    {
        $bill =   PatientBills::find($id);
        if ($bill) {
            $dateTime = Carbon::now();
            $formattedDateTime = $dateTime->format('d-m-Y | g:i A');
            $bill_item = DB::table('bill_items')->where('bill_id', $id)->get();
            return view('patient.bill_print', compact('bill', 'bill_item', 'formattedDateTime'));
        }
        abort(404);
    }
}
