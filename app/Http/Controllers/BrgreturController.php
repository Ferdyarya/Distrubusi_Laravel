<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brgretur;
use App\Models\pendafoutlite;
use App\Models\Brgmasuk;
use App\Models\Masterpegawai;
use PDF;

class BrgreturController extends Controller
{
    public function index(Request $request)
    {
        $brgretur = Brgretur::query();
        if ($request->has('search')) {
            $brgretur = Brgretur::join('brgmasuks', 'brgmasuks.id', '=', 'brgmasuks.id_barang')
                ->where('brgmasuks.namabarang', 'LIKE', '%' . $request->search . '%')
                ->paginate(10);
        } else {
            $brgretur = $brgretur->paginate(10);
        }
        return view('brgretur.index', ['brgretur' => $brgretur]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pendafoutlite = Pendafoutlite::all();
        $brgmasuk = Brgmasuk::all();
        return view('brgretur.create', [
            'pendafoutlite' => $pendafoutlite,
            'brgmasuk' => $brgmasuk,
        ]);
        return view('brgretur.create')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $perulanganInput = count($data['tanggal']);

        for ($i = 0; $i < $perulanganInput; $i++) {
            Brgretur::create([
                'tanggal' => $data['tanggal'][$i],
                'id_barang' => $data['id_barang'][$i],
                'keluhan' => $data['keluhan'][$i],
                'id_customer' => $data['id_customer'][$i],
                'qty' => $data['qty'][$i],
            ]);
        }

        return redirect()->route('brgretur.index')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = Brgretur::find($id);
        // // dd($data);
        // return view('Brgretur.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brgretur $brgretur)
    {
        $masterpegawai = Masterpegawai::all();
        $pendafoutlite = Pendafoutlite::all();
        $brgmasuk = Brgmasuk::all();

        return view('brgretur.edit', [
            'item' => $brgretur,
            'masterpegawai' => $masterpegawai,
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
    public function update(Request $request, Brgretur $brgretur)
    {
        $data = $request->all();

        $brgretur->update($data);

        return redirect()->route('brgretur.index')->with('success', 'Data Telah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brgretur $brgretur)
    {
        $brgretur->delete();
        return redirect()->route('brgretur.index')->with('success', 'Data Telah dihapus');
    }

    public function brgreturpdf()
    {
        $data = Brgretur::all();

        $pdf = PDF::loadview('brgretur/brgreturpdf', ['brgretur' => $data]);
        return $pdf->download('laporan_Barang_retur.pdf');
    }



    // Laporan Barang Filter
    public function cetakbrgreturpertanggal()
    {
        $brgretur = Brgretur::Paginate(10);

        return view('laporansales.laporanbrgretur', ['laporanbrgretur' => $brgretur]);
    }

    public function filterdatebrgretur(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

        if ($startDate == '' && $endDate == '') {
            $laporanbrgretur = Brgretur::paginate(10);
        } else {
            $laporanbrgretur = Brgretur::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporansales.laporanbrgretur', compact('laporanbrgretur'));
    }

    public function laporanbrgreturpdf(Request $request)
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanbrgretur = Brgretur::all();
        } else {
            $laporanbrgretur = Brgretur::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->get();
        }


        $pdf = PDF::loadview('laporansales.laporanbrgreturpdf', compact('laporanbrgretur'));
        return $pdf->download('laporan_laporanbrgretur.pdf');
    }
}
