<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/home', [HomeController::class, 'index']);
    Route::resource('patients', PatientController::class);
    Route::post('/upload', [PatientController::class, 'docUpload'])->name('doc.upload');
    Route::get('/document/delete/{id}', [PatientController::class, 'deletedoc']);
    Route::get('add-bill/{id}', [PatientController::class, 'CreateBill']);
    Route::get('add-bill', [PatientController::class, 'CreateBill_']);
    Route::post('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::post('/savebill', [PatientController::class, 'update']);
    Route::resource('medicines', MedicineController::class);
    Route::post('stock/store', [MedicineController::class,'store_stock']);
    Route::post('/medicines/{id}', [MedicineController::class,'update'])->name('medicines.update');
    Route::get('/medicine/dropdown/{id}', [MedicineController::class,'getdropdown']);
    Route::post('/demo/create', [PatientController::class,'create_demo']);
    Route::post('/demo/updated', [PatientController::class,'updateDemoItems'])->name('bill.updatedDemoItems');
    Route::post('/bill/create', [PatientController::class,'store_bill']);
    Route::get('/demo/get-row/{id}', [PatientController::class, 'getRow']);
    Route::get('/print/{id}', [PatientController::class, 'showPrint']);
    Route::get('/print_', [HomeController::class, 'showPrint_']);
    Route::get('/print_PDF', [HomeController::class, 'billPDF']);
    Route::get('/demo/delete-row/{id}', [PatientController::class, 'rowdeleted']);
    Route::get('/dispense', [HomeController::class,'dispense_view']);
    Route::get('/dispense/pdf', [HomeController::class,'dispense_pdf']);
    Route::get('/dispense/excel', [HomeController::class,'dispense_excel']);
    Route::get('/stockbook', [HomeController::class,'stockBook_view']);
    Route::get('/stock/pdf', [HomeController::class,'stockbook_pdf']);
    Route::get('/stock/excel', [HomeController::class,'stockbook_excel']);
    Route::get('/billbook', [HomeController::class,'billbook_view']);
    Route::get('/billbook/pdf', [HomeController::class,'billbook_pdf']);
    Route::get('/billbook/excel', [HomeController::class,'billbook_excel']);
    Route::get('/delete-bill/{id}', [HomeController::class,'deleteBill']);
    Route::get('/detail-bill/{id}', [PatientController::class,'detailBill']);
    Route::get('/bill/edit/{id}', [PatientController::class,'bill_edit']);
    Route::get('/bill/get-item/{id}', [PatientController::class,'getitem']);
    Route::get('/batch_qty/check/{id}/{qty}', [PatientController::class,'batchQty']);
    Route::get('/patient/get', [PatientController::class, 'search'])->name('patients.getPatients');
    Route::get('/bill/delete-item/{id}/{page_no}', [PatientController::class, 'deleteitem']);
    Route::post('/bill/update',[PatientController::class,'update_bill'])->name('bills.update');
    Route::get('/demo/delete-editrow/{id}', [PatientController::class, 'editrowdelete']);
    Route::get('/demo/edit-row/{page_no}/{id}', [PatientController::class, 'getEditRow']);
    Route::post('/demo/update-row/{id}', [PatientController::class, 'updateDemoRows']);
    Route::get('/demo/total_amount/{page_no}', [PatientController::class, 'gettotal_amount']);
    Route::get('/patient/export', [PatientController::class, 'export'])->name('patients.export');

});
require __DIR__.'/auth.php';
