<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\masteruser;
use Illuminate\Http\Request;
use App\Models\Pendafoutlite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendafoutliteController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $pendafoutlite = Pendafoutlite::where('namatoko', 'LIKE', '%' . $request->search . '%')
            ->orderBy('created_at', 'desc') // Menambahkan pengurutan berdasarkan created_at
            ->paginate(10);
    } else {
        if (Auth::user()->roles == 'sales') {
            $pendafoutlite = Pendafoutlite::where('id_sales', Auth::id())
                ->orderBy('created_at', 'desc') // Menambahkan pengurutan
                ->paginate(10);
        } else {
            $pendafoutlite = Pendafoutlite::orderBy('created_at', 'desc') // Menambahkan pengurutan
                ->paginate(10);
        }
    }

    return view('pendafoutlite.index', [
        'pendafoutlite' => $pendafoutlite,
    ]);
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $masteruser = User::all();

        return view('pendafoutlite.create', [
            'masteruser' => $masteruser,
        ]);
        return view('pendafoutlite.create')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate input to ensure the product name is unique and id_sales is present
    $request->validate([
        'namatoko' => 'required|unique:pendafoutlites,namatoko',
        'id_sales' => 'required|exists:users,id', // Ensure id_sales exists in the users table
    ], [
        'namatoko.unique' => 'Nama toko sudah ada. Silakan gunakan nama lain.',
        'id_sales.required' => 'ID sales harus diisi.',
        'id_sales.exists' => 'ID sales tidak valid.',
    ]);

    // Create a new Pendafoutlite record with request data
    $data = $request->all();

    $pendafoutlite = Pendafoutlite::create($data);

    // Handle file uploads
    if ($request->hasFile('fotoktp')) {
        $fotoktpName = $request->file('fotoktp')->getClientOriginalName();
        $request->file('fotoktp')->move('fotoktp/', $fotoktpName);
        $pendafoutlite->fotoktp = $fotoktpName;
    }

    if ($request->hasFile('fototoko')) {
        $fototokoName = $request->file('fototoko')->getClientOriginalName();
        $request->file('fototoko')->move('fototoko/', $fototokoName);
        $pendafoutlite->fototoko = $fototokoName;
    }

    // Save the updated Pendafoutlite record with file names
    $pendafoutlite->save();

    // Redirect with success message
    return redirect()->route('pendafoutlite.index')->with('success', 'Data Telah ditambahkan');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = Pendafoutlite::find($id);
        // // dd($data);
        // return view('Pendafoutlite.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pendafoutlite $pendafoutlite)
    {
        $masteruser = User::all();
        return view('pendafoutlite.edit', [
            'item' => $pendafoutlite,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendafoutlite $pendafoutlite)
    {
        $data = $request->all();

        $pendafoutlite->update($data);

        return redirect()->route('pendafoutlite.index')->with('success', 'Data Telah diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendafoutlite $pendafoutlite)
    {
        $pendafoutlite->delete();
        return redirect()->route('pendafoutlite.index')->with('success', 'Data Telah dihapus');
    }

    public function validasi(Request $request, $id)
    {
        $pendafoutlite = Pendafoutlite::find($id);
        // $email= $pendafoutlite->customermaster->email;
        if ($request->has('validasi')) {
            $pendafoutlite->update([
                'status' => $request->validasi
            ]);

        }
        return redirect()->route('pendafoutlite.index')->with('success', 'Data Telah diupdate');
    }


    public function pernama(Request $request)
{
    // Ambil filter dari request, defaultnya adalah null
    $filter = $request->query('filter', null);

    // Ambil data peminjaman berdasarkan filter
    if ($filter === 'all' || empty($filter)) {
        $pendafoutlite = Pendafoutlite::paginate(10);
    } else {
        $pendafoutlite = Pendafoutlite::where('id_sales', $filter)->paginate(10);
    }

    // Ambil data agregat
    $idAnggotaCounts = Pendafoutlite::select('id_sales', DB::raw('count(*) as count'))
        ->groupBy('id_sales')
        ->orderBy('id_sales')
        ->get();

    // Ambil data master anggota
    $masteruser = User::all();

    return view('laporansales.pernama', [
        'pendafoutlite' => $pendafoutlite,
        'idAnggotaCounts' => $idAnggotaCounts,
        'filter' => $filter,
        'masteruser' => $masteruser,
    ]);
}

public function pernama_pdf(Request $request, $filter = 'all')
{
    // Ambil data berdasarkan filter
    if ($filter === 'all') {
        $pendafoutlite = Pendafoutlite::all();
    } else {
        $pendafoutlite = Pendafoutlite::where('id_sales', $filter)->get();
    }

    // Ambil data agregat berdasarkan filter
    $idAnggotaCounts = Pendafoutlite::when(
        $filter !== 'all',
        function ($query) use ($filter) {
            $query->where('id_sales', $filter);
        }
    )
    ->groupBy('id_sales')
    ->orderBy('id_sales')
    ->select(DB::raw('count(*) as count, id_sales'))
    ->get();

    // Muat tampilan dan konversi ke PDF
    $pdf = Pdf::loadView('laporansales.pernamapdf', [
        'pendafoutlite' => $pendafoutlite,
        'idAnggotaCounts' => $idAnggotaCounts,
        'filter' => $filter,
    ]);

    // Kembalikan PDF yang dihasilkan sebagai unduhan
    return $pdf->download('laporan_pernama.pdf');
}




    public function cetakpegawaipertanggal()
    {
        $pendafoutlite = Pendafoutlite::Paginate(10);

        return view('laporansales.laporanoutlet', ['pendafoutlite' => $pendafoutlite]);
    }

    public function filterdate(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanoutlet = Pendafoutlite::paginate(10);
        } else {
            $laporanoutlet = Pendafoutlite::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporansales.laporanoutlet', compact('laporanoutlet'));
    }


    public function laporanoutletpdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanoutlet = Pendafoutlite::all();
        } else {
            $laporanoutlet = Pendafoutlite::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }



        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporansales.laporanoutletpdf', compact('laporanoutlet'));
        return $pdf->download('laporan_laporanoutlet.pdf');
    }


    // Masterdatatokog
    public function mastertoko_index(Request $request)
    {
        $query = Pendafoutlite::query();

        // Filter pencarian
        if ($request->has('search')) {
            $query->where('namabarang', 'LIKE', '%' . $request->search . '%');
        }

        $pendafoutlite = $query->paginate(10);


        return view('mastertoko.index', compact('pendafoutlite'));
    }

    public function updateStatus(Request $request, $id)
{
    // Ambil data item berdasarkan ID
    $item = Pendafoutlite::findOrFail($id);

    // Validasi status: hanya izinkan update jika status saat ini bukan 'approve'
    if ($item->status === 'approve') {
        return redirect()->back()->withErrors(['status' => 'Data sudah disetujui dan tidak bisa diubah.']);
    }

    // Update status menjadi 'approve'
    $item->status = 'approve';
    $item->save();

    return redirect()->back()->with('success', 'Status berhasil diperbarui.');
}






}
