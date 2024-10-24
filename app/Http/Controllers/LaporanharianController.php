<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\masteruser;
use Illuminate\Http\Request;
use App\Models\Laporanharian;
use Illuminate\Support\Facades\Auth;

class LaporanharianController extends Controller
{
    public function index(Request $request)
{
    if ($request->has('search')) {
        $laporanharian = Laporanharian::where('area', 'LIKE', '%' . $request->search . '%')
            ->orderBy('created_at', 'desc') // Menambahkan pengurutan berdasarkan created_at
            ->paginate(10);
    } else {
        if (Auth::user()->roles == 'sales') {
            $laporanharian = Laporanharian::where('id_sales', Auth::id())
                ->orderBy('created_at', 'desc') // Menambahkan pengurutan
                ->paginate(10);
        } else {
            $laporanharian = Laporanharian::orderBy('created_at', 'desc') // Menambahkan pengurutan
                ->paginate(10);
        }
    }

    return view('laporanharian.index', [
        'laporanharian' => $laporanharian,
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

        return view('laporanharian.create', [
            'masteruser' => $masteruser,
        ]);
        return view('laporanharian.create')->with('success', 'Data Telah ditambahkan');
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

        $perulanganInput = count($data["tanggal"]);

        for ($i = 0; $i < $perulanganInput; $i++) {
            Laporanharian::create([
                'tanggal' => $data["tanggal"][$i],
                'area' => $data["area"][$i],
                'chanel' => $data["chanel"][$i],
                'call' => $data["call"][$i],
                'akumulasiec' => $data["akumulasiec"][$i],
                'targetharian' => $data["targetharian"][$i],
                'aktualharian' => $data["aktualharian"][$i],
                'id_sales' => $data["id_sales"][$i],
            ]);
        }

        return redirect()->route('laporanharian.index')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = Laporanharian::find($id);
        // // dd($data);
        // return view('Laporanharian.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Laporanharian $laporanharian)
    {
        $masteruser = User::all();
        return view('laporanharian.edit', [
            'item' => $laporanharian,
            'masteruser' => $masteruser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laporanharian $laporanharian)
    {
        $data = $request->all();

        $laporanharian->update($data);

        return redirect()->route('laporanharian.index')->with('success', 'Data Telah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporanharian $laporanharian)
    {
        $laporanharian->delete();
        return redirect()->route('laporanharian.index')->with('success', 'Data Telah dihapus');
    }

    public function Laporanharianpdf() {
        $data = Laporanharian::all();

        $pdf = PDF::loadview('laporanharian/laporanharianpdf', ['laporanharian' => $data]);
        return $pdf->download('laporan_laporanharian.pdf');
    }

    // Laporan Harian Filter
    public function cetakhariansalespertanggal()
    {
        $laporanharian = Laporanharian::Paginate(10);

        return view('laporansales.laporanhariansales', ['laporanbrgmasuk' => $laporanharian]);
    }

    public function filterdatehariansales(Request $request)
    {
        $startDate = $request->input('dari');
        $endDate = $request->input('sampai');

         if ($startDate == '' && $endDate == '') {
            $laporanhariansales = Laporanharian::paginate(10);
        } else {
            $laporanhariansales = Laporanharian::whereDate('tanggal','>=',$startDate)
                                        ->whereDate('tanggal','<=',$endDate)
                                        ->paginate(10);
        }
        session(['filter_start_date' => $startDate]);
        session(['filter_end_date' => $endDate]);

        return view('laporansales.laporanhariansales', compact('laporanhariansales'));
    }


    public function laporanhariansalespdf(Request $request )
    {
        $startDate = session('filter_start_date');
        $endDate = session('filter_end_date');

        if ($startDate == '' && $endDate == '') {
            $laporanhariansales = Laporanharian::all();
        } else {
            $laporanhariansales = Laporanharian::whereDate('tanggal', '>=', $startDate)
                                            ->whereDate('tanggal', '<=', $endDate)
                                            ->get();
        }

        // Render view dengan menyertakan data laporan dan informasi filter
        $pdf = PDF::loadview('laporansales.laporanhariansalespdf', compact('laporanhariansales'));
        return $pdf->download('laporan_laporanhariansales.pdf');
    }
}
