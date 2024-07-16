<?php

namespace App\Http\Controllers;

use App\Models\Batche;
use App\Models\Medicine;
use Illuminate\Http\Request;
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
        ->paginate(10);
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
        return redirect('medicines')->with('success', 'Patient updated successfully.');

        }else{
            return redirect('medicines')->with('error', 'Patient not found.');
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

            $existingBatch = Batche::where('medicine_id', $request->input('medicine'))
                                ->where('batch_no', $request->input('batch_no'))
                                ->first();

            if ($existingBatch) {
                $existingBatch->quantity += $request->input('quantity');
                $existingBatch->save();

                return redirect('medicines')->with('success', 'Stock updated successfully.');
            } else {
                $medicine = new Batche();
                $medicine->medicine_id = $request->input('medicine');
                $medicine->batch_no = $request->input('batch_no');
                $medicine->quantity = $request->input('quantity');
                $medicine->save();

                return redirect('medicines')->with('success', 'Stock added successfully.');
            }
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
