<?php

namespace App\Http\Controllers;
use PDF;

use App\Models\User;
use App\Models\Orderan;
use App\Models\brgmasuk;
use App\Models\Brgkeluar;
use App\Models\Mastertoko;
use App\Models\masteruser;
use Illuminate\Http\Request;
use App\Models\pendafoutlite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BrgkeluarController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $brgkeluar = Brgkeluar::where('nopembelian', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{

        /* if( Auth::user()->roles == 'sales'){
            $brgkeluar = Brgkeluar::where('id_sales', Auth::id())->paginate(10);
        }else{
            $brgkeluar = Brgkeluar::paginate(10);
        } */
        if (Auth::user()->roles == 'sales') {
            $brgkeluar = Brgkeluar::where('id_sales', Auth::id())
                ->join('orderans', 'brgkeluars.id', '=', 'orderans.id_pembelian')
                ->join('brgmasuks', 'orderans.id_barang_keluar', '=', 'brgmasuks.id')
                ->select('brgkeluars.*',
                         DB::raw('SUM(orderans.qty * brgmasuks.hargabarang) as total_harga'))
                ->groupBy('brgkeluars.id') // Group by primary key or relevant identifier
                ->paginate(10);
        } else {
            // Query for non-sales role
            $brgkeluar = Brgkeluar::join('orderans', 'brgkeluars.id', '=', 'orderans.id_pembelian')
                ->join('brgmasuks', 'orderans.id_barang_keluar', '=', 'brgmasuks.id')
                ->select('brgkeluars.*',
                         DB::raw('SUM(orderans.qty * brgmasuks.hargabarang) as total_harga'))
                ->groupBy('brgkeluars.id') // Group by primary key or relevant identifier
                ->paginate(10);
        }
        }
        // return Auth::user()->roles;
        return view('brgkeluar.index',[
            'brgkeluar' => $brgkeluar,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $brgkeluar = Brgkeluar::with('masterbarang')->get();
    $pendafoutlite = Pendafoutlite::all();
    $brgmasuk = Brgmasuk::all();

    $today = date('Ymd');

    $lastPurchase = Brgkeluar::whereDate('created_at', today())
        ->where('nopembelian', 'like', 'PMBLN-' . $today . '%')
        ->orderBy('nopembelian', 'desc')
        ->first();

    $sequenceNumber = $lastPurchase ? (int) substr($lastPurchase->nopembelian, -2) + 1 : 1;
    $sequenceNumber = str_pad($sequenceNumber, 2, '0', STR_PAD_LEFT);

    $newPurchaseNumber = 'PMBLN-' . $today . '-' . $sequenceNumber;

    return view('brgkeluar.create', [
        'pendafoutlite' => $pendafoutlite,
        'brgmasuk' => $brgmasuk,
        'brgkeluar' => $brgkeluar,
        'newPurchaseNumber' => $newPurchaseNumber
    ]);
}


    public function store(Request $request)
{
    $nopembelian = $request->input('nopembelian');
    $tanggal = $request->input('tanggal');
    $id_sales = $request->input('id_sales');
    $id_toko = $request->input('id_toko');
    $selectedBarangs = $request->input('selectedBarangs');

    $noinvoice = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());
    $nosuratjalan = 'SJ-' . date('Ymd') . '-' . strtoupper(uniqid());

        $brgkeluar = Brgkeluar::create([
            'nopembelian' => $nopembelian,
            'tanggal' => $tanggal,
            'id_sales' => $id_sales,
            'id_toko' => $id_toko,
            'noinvoice' => $noinvoice,
            'nosuratjalan' => $nosuratjalan,
        ]);

        $id_pembelian = $brgkeluar->id;


        foreach ($selectedBarangs as $barang) {

            Orderan::create([
            'id_barang_keluar' => $barang['id_barang'],
            'qty' => $barang['qty'],
            'id_pembelian' => $id_pembelian,
        ]);
    }

    return response()->json(['message' => 'Pembelian berhasil disimpan']);
}

    private function generateNoInvoice()
    {
        $latestInvoice = Brgkeluar::max('noinvoice');
        $newInvoiceNumber = $latestInvoice ? (intval($latestInvoice) + 1) : 1000;
        return str_pad($newInvoiceNumber, 4, '0', STR_PAD_LEFT);
    }

    private function generateNoSuratJalan()
    {
        $latestSuratJalan = Brgkeluar::max('nosuratjalan');
        $newSuratJalanNumber = $latestSuratJalan ? (intval($latestSuratJalan) + 1) : 5000;
        return str_pad($newSuratJalanNumber, 4, '0', STR_PAD_LEFT);
    }


    public function show($id)
    {
        $query = DB::table('brgkeluars as bk')
        ->join('orderans as o', 'bk.id', '=', 'o.id_pembelian')
        ->join('brgmasuks as bm', 'o.id_barang_keluar', '=', 'bm.id')
        ->select('bk.nopembelian', 'bm.namabarang', 'bm.hargabarang', 'bm.kodebarang', 'o.qty')
        ->where('bk.id', $id)
        ->paginate(50);

        // return $query;
        return view('brgkeluar.show', ['query' => $query, 'id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $query = DB::table('brgkeluars as bk')
        // ->join('orderans as o', 'bk.id', '=', 'o.id_pembelian')
        // ->join('pendafoutlites as pn', 'pn.id', '=', 'pn.id')
        // ->join('brgmasuks as bm', 'o.id_barang_keluar', '=', 'bm.id')
        // ->select('bk.nopembelian', 'bm.namabarang', 'bm.hargabarang', 'bm.kodebarang', 'o.qty', 'pn.namatoko', 'pn.alamat')
        // ->where('bk.id', $id)
        // ->get();
        $brgkeluar = Brgkeluar::with('orderan')->findOrFail($id);

        $masteruser = User::all();
        $pendafoutlite = Pendafoutlite::all();
        $brgmasuk = Brgmasuk::all();

        return view('brgkeluar.edit', [
            'item' => $brgkeluar,
            'mastersupplier' => $masteruser,
            'pendafoutlite' => $pendafoutlite,
            'brgmasuk' => $brgmasuk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{

    // Temukan data yang akan diperbarui
    $data = Brgkeluar::find($id);
     // Validasi request jika diperlukan
     $request->validate([
        'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'statuskirim' => 'required|string',
        'updatekirim' => 'required|date',
    ]);

    // Jika file bukti kirim ada
    if ($request->hasFile('bukti')) {
        // Pindahkan file ke direktori yang diinginkan
        $file = $request->file('bukti');
        $filename = $file->getClientOriginalName();
        $file->move(public_path('bukti'), $filename);

        // Perbarui nama file bukti kirim
        $data->bukti = $filename;
    }

    // Perbarui data lainnya
    $data->statuskirim = $request->input('statuskirim');
    $data->updatekirim = $request->input('updatekirim');

    $data->update($request->except(['bukti', 'statuskirim','updatekirim']));

    // Simpan perubahan
    $data->save();
    return redirect()->route('brgkeluar.index')->with('success', 'Data Telah diubah');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brgkeluar $brgkeluar )
    {
        $brgkeluar->orderan()->delete();
        $brgkeluar->delete();
        return redirect()->route('brgkeluar.index')->with('success', 'Data Telah dihapus');
    }


    public function downloadAllInvoicePdf($id)
{
    $query = DB::table('brgkeluars as bk')
        ->join('orderans as o', 'bk.id', '=', 'o.id_pembelian')
        ->join('pendafoutlites as pn', 'pn.id', '=', 'pn.id')
        ->join('brgmasuks as bm', 'o.id_barang_keluar', '=', 'bm.id')
        ->select('bk.nopembelian', 'bm.namabarang', 'bm.hargabarang', 'bm.kodebarang', 'o.qty', 'pn.namatoko', 'pn.alamat')
        ->where('bk.id', $id)
        ->get();
        // return $query;
    $pdf = PDF::loadView('brgkeluar.invoicepdf', ['query' => $query]);

    // Unduh PDF
    return $pdf->download('invoice_pdf_' . $id . '.pdf'); // Nama file yang lebih jelas
}

public function downloadAllSuratJalanPdf($id)
{
    $query = DB::table('brgkeluars as bk')
        ->join('orderans as o', 'bk.id', '=', 'o.id_pembelian')
        ->join('pendafoutlites as pn', 'pn.id', '=', 'pn.id')
        ->join('users as us', 'us.id', '=', 'us.id')
        ->join('brgmasuks as bm', 'o.id_barang_keluar', '=', 'bm.id')
        ->select('bk.nopembelian', 'bm.namabarang', 'bm.hargabarang', 'bm.kodebarang', 'o.qty', 'pn.namatoko', 'pn.alamat','pn.tanggal','us.name')
        ->where('bk.id', $id)
        ->get();

    // return $query;
    $pdf = PDF::loadView('brgkeluar.suratjalanpdf', ['query' => $query]);

    // Unduh PDF
    return $pdf->download('surat_jalan_pdf_' . $id . '.pdf'); // Nama file yang lebih jelas
}



 // Laporan Barang Filter
 public function cetakbarangpertanggal()
 {
     $brgkeluar = Brgkeluar::Paginate(10);

     return view('laporansales.laporanorderan', ['laporanorderan' => $brgkeluar]);
 }

 public function filterdatebrgkeluar (Request $request)
 {
     $startDate = $request->input('dari');
     $endDate = $request->input('sampai');

      if ($startDate == '' && $endDate == '') {
         $laporanbrgkeluar = Brgkeluar::paginate(10);
     } else {
         $laporanbrgkeluar = Brgkeluar::whereDate('tanggal','>=',$startDate)
                                     ->whereDate('tanggal','<=',$endDate)
                                     ->paginate(10);
     }
     session(['filter_start_date' => $startDate]);
     session(['filter_end_date' => $endDate]);

     return view('laporansales.laporanorderan', compact('laporanbrgkeluar'));
 }


 public function laporanorderanpdf(Request $request )
 {
     $startDate = session('filter_start_date');
     $endDate = session('filter_end_date');

     if ($startDate == '' && $endDate == '') {
         $laporanbrgkeluar = Brgkeluar::all();
     } else {
         $laporanbrgkeluar = Brgkeluar::whereDate('tanggal', '>=', $startDate)
                                         ->whereDate('tanggal', '<=', $endDate)
                                         ->get();
     }

     // Render view dengan menyertakan data laporan dan informasi filter
     $pdf = PDF::loadview('laporansales.laporanorderanpdf', compact('laporanbrgkeluar'));
     return $pdf->download('laporan_laporanbrgkeluar.pdf');
 }

 public function showinvoice(Request $request)
    {
        $showinvoice = Brgkeluar::Paginate(10);

        return view('laporansales.showinvoice', ['showinvoice' => $showinvoice]);
    }

    public function validasi(Request $request, $id)
{
    $brgkeluar = Brgkeluar::find($id);

    if ($brgkeluar) {
        if ($request->has('validasi')) {
            $brgkeluar->update([
                'status' => $request->validasi
            ]);
        }
        return redirect()->route('brgkeluar.index')->with('success', 'Data Telah diupdate');
    }

    return redirect()->route('brgkeluar.index')->with('error', 'Data tidak ditemukan');
}

    // Method to upload proof
    // public function uploadBukti(Request $request, $id)
    // {
    //     $item = Brgkeluar::findOrFail($id);

    //     // Validasi file
    //     $request->validate([
    //         'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);

    //     // Hapus file lama jika perlu
    //     if ($item->bukti) {
    //         Storage::delete($item->bukti);
    //     }

    //     // Simpan file baru
    //     $file = $request->file('bukti');
    //     $path = $file->store('bukti', 'public');

    //     // Update path file di database
    //     $item->bukti = $path;
    //     $item->save();

    //     return redirect()->back()->with('success', 'Bukti berhasil diunggah.');
    // }

}
