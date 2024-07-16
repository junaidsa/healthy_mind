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
    Route::post('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::resource('medicines', MedicineController::class);
    Route::post('stock/store', [MedicineController::class,'store_stock']);
    Route::post('/medicines/{id}', [MedicineController::class,'update'])->name('medicines.update');
    Route::get('/medicine/dropdown/{id}', [MedicineController::class,'getdropdown'])->name('medicines.update');
    Route::post('/demo/create', [PatientController::class,'create_demo']);
    Route::post('/bill/create', [PatientController::class,'create_bill']);
    Route::get('/demo/get-row/{id}', [PatientController::class, 'getRow']);
    Route::get('/print/{id}', [PatientController::class, 'showPrint']);
    Route::get('/demo/delete-row/{id}', [PatientController::class, 'rowdeleted']);
    Route::get('/dispense', [HomeController::class,'dispense_view']);
});
require __DIR__.'/auth.php';
