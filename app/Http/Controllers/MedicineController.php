<?php

namespace App\Http\Controllers;

use App\Models\Batche;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keywords = request('keywords');
        $medicines = Medicine::where('name', 'like', "%$keywords%")
        ->paginate(30);
        return view('medicine.view',compact('medicines'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'rate' => 'required',
            'tax' => 'required',
        ]);
        if ($validated) {
            $medicine = new Medicine();
            $medicine->name = $request->input('name');
            $medicine->rate = $request->input('rate');
            $medicine->tax = $request->input('tax');
            $medicine->save();
            return redirect('medicines')->with('success', 'Medicines add successfully.');
        } else {
            return redirect()->back()->withErrors($validated)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $medicine = Medicine::find($id);

        if($medicine){

        $history =  DB::table('medicine_history')->where('medicine_id',$id)->whereNull('deleted_at')->paginate('10');
            return view('medicine.history',compact('history','id','medicine'));
        }
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::find($id);

        return view('medicine.edit',compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
 {
    $validated = $request->validate([
        'name' => 'required',
        'rate' => 'required',
        'tax' => 'required',
    ]);
        $me = Medicine::find($id);
        if($me){
            $me->name = $request->input('name');
            $me->rate = $request->input('rate');
            $me->tax = $request->input('tax');
            $me->save();
        return redirect('medicines')->with('success', 'Medicine updated successfully.');

        }else{
            return redirect('medicines')->with('error', 'Medicine not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
    public function store_stock(Request $request)
    {
        $validated = $request->validate([
            'medicine' => 'required',
            'batch_no' => 'required',
            'quantity' => 'required|numeric',
        ]);


        if ($validated) {
            $qty = $request->input('quantity');
            $leftstock = DB::table('batches')
            ->where('medicine_id', $request->input('medicine'))
            ->sum('quantity');
            $left = $leftstock + $qty;

            $existingBatch = Batche::where('medicine_id', $request->input('medicine'))
                                ->where('batch_no', $request->input('batch_no'))
                                ->first();
                                $currentDateTime = Date::now()->format('h:i A');

            if ($existingBatch) {
                $existingBatch->quantity += $qty;
                $existingBatch->save();

                DB::table('medicine_history')->insert([
                    'batch_id' =>  $existingBatch->id,
                    'medicine_id' => $existingBatch->medicine_id,
                    'stock' => $qty,
                    'status' => 'Adding Stock'.' '.$qty,
                    'time' => $currentDateTime,
                    'batch_no' => $existingBatch->batch_no,
                    'left_stock' => $left,
                ]);
                return redirect('medicines')->with('success', 'Stock updated successfully.');



            }
            $batch = new Batche();
                $batch->medicine_id = $request->input('medicine');
                $batch->batch_no = $request->input('batch_no');
                $batch->quantity = $request->input('quantity');
                $batch->save();
                DB::table('medicine_history')->insert([
                    'batch_id' =>  $batch->id,
                    'medicine_id' => $batch->medicine_id,
                    'stock' => $request->input('quantity'),
                    'status' => 'Adding Stock'.' '.$qty,
                    'time' => $currentDateTime,
                    'batch_no' => $batch->batch_no,
                    'left_stock' => $left,
                ]);
                return redirect('medicines')->with('success', 'Stock added successfully');
        } else {
            return redirect()->back()->withErrors($validated)->withInput();
        }
    }
    public function getdropdown($id)
    {
        $medicines = Medicine::all()->map(function ($medicine) use ($id) {
            $totalQuantity = DB::table('batches')
                ->where('medicine_id', $medicine->id)
                ->sum('quantity');
            $reservedQuantity = DB::table('temp_stock_reservations')
                ->where('medicine_id', $medicine->id)
                ->where('page_id', $id)
                ->sum('quantity');

            $availableQuantity = $totalQuantity - $reservedQuantity;
            return [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'totalQuantity' => $availableQuantity,
            ];
        });

        return response()->json($medicines);
    }
}
