<?php

use App\Models\User;
use App\Models\Brgmasuk;
use App\Models\Brgretur;
use App\Models\Brgkeluar;
use App\Models\Mastertoko;
use App\Models\Masterbarang;
use App\Models\Laporanharian;
use App\Models\Masterpegawai;
use App\Models\Pendafoutlite;
use App\Models\Mastersupplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BrgmasukController;
use App\Http\Controllers\BrgreturController;
use App\Http\Controllers\BrgkeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MastertokoController;
use App\Http\Controllers\MasterbarangController;
use App\Http\Controllers\LaporanharianController;
use App\Http\Controllers\MasterpegawaiController;
use App\Http\Controllers\PendafoutliteController;
use App\Http\Controllers\MastersupplierController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    $dateNow = new \DateTime();
    $jumlahsales = User::where('roles', 'sales')->count();
    $jumlahbahan = Brgmasuk::count();
    $outletterdaftar = Pendafoutlite::count();
    $orderan = Brgkeluar::count();
    $jumlahtoko = Mastertoko::count();
    $jumlahsupplier = Mastersupplier::count();
    $jumlahbarangmasuk = Brgmasuk::count();
    $jumlahbaranretur = Brgretur::count();
    $laporanharianjumlah = Laporanharian::count();

    // Fetching monthly order data
    $orderMonth1 = Brgkeluar::whereMonth('created_at', now()->subMonths(1)->month)
                              ->whereYear('created_at', now()->subMonths(1)->year)
                              ->count();
    $orderMonth2 = Brgkeluar::whereMonth('created_at', now()->subMonths(2)->month)
                              ->whereYear('created_at', now()->subMonths(2)->year)
                              ->count();
    $orderMonth3 = Brgkeluar::whereMonth('created_at', now()->subMonths(3)->month)
                              ->whereYear('created_at', now()->subMonths(3)->year)
                              ->count();
    $orderMonth4 = Brgkeluar::whereMonth('created_at', now()->subMonths(4)->month)
                              ->whereYear('created_at', now()->subMonths(4)->year)
                              ->count();
    $orderMonth5 = Brgkeluar::whereMonth('created_at', now()->subMonths(5)->month)
                              ->whereYear('created_at', now()->subMonths(5)->year)
                              ->count();

    return view('dashboard', compact(
        'jumlahsales',
        'jumlahbahan',
        'orderan',
        'jumlahtoko',
        'dateNow',
        'outletterdaftar',
        'jumlahsupplier',
        'jumlahbarangmasuk',
        'jumlahbaranretur',
        'laporanharianjumlah',
        'orderMonth1',
        'orderMonth2',
        'orderMonth3',
        'orderMonth4',
        'orderMonth5'
    ));
})->middleware('auth');


Route::prefix('dashboard')->middleware(['auth:sanctum'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Master Data
    Route::resource('masteruser', LoginController::class);
    Route::resource('mastertoko', MastertokoController::class);
    Route::resource('mastersupplier', MastersupplierController::class);
    // Route::resource('masterbarang', MasterbarangController::class);

// Data Tables
    Route::resource('pendafoutlite', PendafoutliteController::class);
    Route::resource('brgmasuk', BrgmasukController::class);
    Route::resource('brgkeluar', BrgkeluarController::class);
    Route::resource('laporanharian', LaporanharianController::class);
    Route::resource('brgretur', BrgreturController::class);

    Route::get('/barang', [BrgmasukController::class, 'barang'])->name('barang');


//validasi update status
Route::patch('/brgmasuk/{id}/update-status', [BrgMasukController::class, 'updateStatus'])->name('brgmasuk.updateStatus');
Route::patch('/pendafoutlite/{id}/update-status', [PendafoutliteController::class, 'updateStatus'])->name('pendafoutlite.updateStatus');
Route::patch('/brgkeluar/{id}/update-status', [BrgkeluarController::class, 'updateStatus'])->name('brgkeluar.updateStatus');

// Masterdata Barang dari brgmsk
Route::get('masterbarang', [BrgmasukController::class, 'masterbarang_index'])->name('masterbarang.index');

// Masterdata Barang dari brgmsk
Route::get('mastertoko', [PendafoutliteController::class, 'mastertoko_index'])->name('mastertoko.index');

Route::get('/brgkeluar/{id}', [BrgkeluarController::class, 'show'])->name('brgkeluar.show');
Route::get('/laporansales/showinvoice', [BrgkeluarController::class, 'showinvoice'])->name('laporansales.showinvoice');

Route::get('/brgkeluar/invoicepdf/{id}', [BrgkeluarController::class, 'downloadAllInvoicePdf'])->name('brgkeluar.invoicepdf');
Route::get('/brgkeluar/suratjalanpdf/{id}', [BrgkeluarController::class, 'downloadAllSuratJalanPdf'])->name('brgkeluar.suratjalanpdf');


// Master Data Report
Route::get('laporanharianpdf', [LaporanharianController::class, 'laporanharianpdf'])->name('laporanharianpdf');
Route::get('brgreturpdf', [BrgreturController::class, 'brgreturpdf'])->name('brgreturpdf');



// Data Tables Report Report
Route::get('pendafoutlitepdf', [PendafoutliteController::class, 'pendafoutlitepdf'])->name('pendafoutlitepdf');
Route::get('brgmasukpdf', [BrgmasukController::class, 'brgmasukpdf'])->name('brgmasukpdf');
Route::get('brgkeluarpdf', [BrgkeluarController::class, 'brgkeluarpdf'])->name('brgkeluarpdf');
Route::get('laporanharianpdf', [LaporanharianController::class, 'laporanharianpdf'])->name('laporanharianpdf');
Route::get('brgreturpdf', [BrgreturController::class, 'brgreturpdf'])->name('brgreturpdf');


// Validasi
Route::patch('sales/{id}/validasi', [PendafoutliteController::class, 'validasi'])->name('validasisales');
Route::patch('brgkluar/{id}/validasi', [BrgkeluarController::class, 'validasi'])->name('validasikirim');
// Route::patch('/validasisales/{id}', [SalesController::class, 'validasisales'])->name('validasisales');

// Recap Laporan Tampilan

Route::get('laporansales/laporanoutlet', [PendafoutliteController::class, 'cetakpegawaipertanggal'])->name('laporanoutlet');
Route::get('laporansales/laporanbrgmasuk', [BrgmasukController::class, 'cetakbarangpertanggal'])->name('laporanbrgmasuk');
Route::get('laporansales/laporanorderan', [BrgkeluarController::class, 'cetakbrgkeluarpertanggal'])->name('laporanorderan');
Route::get('laporansales/laporanhariansales', [LaporanharianController::class, 'cetakhariansalespertanggal'])->name('laporanhariansales');
Route::get('laporansales/laporanbrgretur', [BrgreturController::class, 'cetakbrgreturpertanggal'])->name('laporanbrgretur');

Route::get('laporansales/invoicepdf', [BrgkeluarController::class, 'invoicepdf'])->name('invoicepdf');
Route::get('laporansales/suratjalanpdf', [BrgkeluarController::class, 'suratjalanpdf'])->name('suratjalanpdf');
Route::get('invoicepdf/{filter}', [BrgkeluarController::class, 'invoicepdf'])->name('invoicepdf');
Route::get('suratjalanpdf/{filter}', [BrgkeluarController::class, 'suratjalanpdf'])->name('suratjalanpdf');

// Filtering
Route::get('laporanoutlet', [PendafoutliteController::class, 'filterdate'])->name('laporanoutlet');
Route::get('laporanbrgmasuk', [BrgmasukController::class, 'filterdatebarang'])->name('laporanbrgmasuk');
Route::get('laporanorderan', [BrgkeluarController::class, 'filterdatebrgkeluar'])->name('laporanorderan');
Route::get('laporanhariansales', [LaporanharianController::class, 'filterdatehariansales'])->name('laporanhariansales');
Route::get('laporanbrgretur', [BrgreturController::class, 'filterdatebrgretur'])->name('laporanbrgretur');



// Filter Laporan
Route::get('laporansales/pernama', [PendafoutliteController::class, 'pernama'])->name('pernama');
Route::get('/pernamapdf', [PendafoutliteController::class, 'pernama_pdf'])->name('pernama.pdf');
Route::get('/pernamapdf/{filter?}', [PendafoutliteController::class, 'pernama_pdf'])->name('pernamapdf');


Route::get('laporanoutletpdf/filter={filter}', [PendafoutliteController::class, 'laporanoutletpdf'])->name('laporanoutletpdf');
Route::get('laporanbrgmasukpdf/filter={filter}', [BrgmasukController::class, 'laporanbrgmasukpdf'])->name('laporanbrgmasukpdf');
Route::get('laporanorderanpdf/filter={filter}', [BrgkeluarController::class, 'laporanorderanpdf'])->name('laporanorderanpdf');
Route::get('laporanhariansalespdf/filter={filter}', [LaporanharianController::class, 'laporanhariansalespdf'])->name('laporanhariansalespdf');
Route::get('laporanbrgreturpdf/filter={filter}', [BrgreturController::class, 'laporanbrgreturpdf'])->name('laporanbrgreturpdf');


// Rute untuk update status
Route::patch('/brgkeluar/{id}/update-status', [BrgkeluarController::class, 'updateStatus'])->name('brgkeluar.updateStatus');

// Rute untuk upload bukti
Route::post('/brgkeluar/{id}/upload-bukti', [BrgkeluarController::class, 'uploadBukti'])->name('brgkeluar.uploadBukti');

});



// Login Register
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/loginuser', [LoginController::class, 'loginuser'])->name('loginuser');








