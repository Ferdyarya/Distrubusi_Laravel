<?php

namespace App\Http\Controllers;

use App\Models\Mastertoko;
use Illuminate\Http\Request;

class MastertokoController extends Controller
{
    // NEW
    public function index(Request $request)
    {
        if($request->has('search')){
            $mastertoko = Mastertoko::where('name', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $mastertoko = Mastertoko::paginate(10);
        }
        return view('mastertoko.index',[
            'mastertoko' => $mastertoko
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mastertoko.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validasi input untuk memastikan nama produk unik
    $request->validate([
        'namatoko' => 'required|unique:mastertokos,namatoko',
    ], [
        'namatoko.unique' => 'Nama Toko sudah ada. Silakan gunakan nama lain.',
    ]);
    
    $data = $request->all();

    // Generate a new unique code with prefix "MA"
    $lastItem = Mastertoko::orderBy('created_at', 'desc')->first();
    $lastCode = $lastItem ? $lastItem->kode : '';
    $newCode = $this->generateNewCode($lastCode);

    // Set the new code in the data array
    $data['kode'] = $newCode;

    Mastertoko::create($data);

    return redirect()->route('mastertoko.index')->with('success', 'Data Telah ditambahkan');
}

/**
 * Generate a new unique code with prefix "MA"
 *
 * @param  string  $lastCode
 * @return string
 */
private function generateNewCode($lastCode)
{
    // Extract the numeric part of the last code, if available
    $lastNumber = intval(substr($lastCode, 2)); // Assumes "MA" is 2 characters
    $nextNumber = $lastNumber + 1;

    // Format the new number to be at least 4 digits long
    $newCode = 'MA' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    return $newCode;
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = mastertoko::find($id);
        // // dd($data);
        // return view('mastertoko.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mastertoko $mastertoko)
    {
        return view('mastertoko.edit', [
            'item' => $mastertoko
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mastertoko $mastertoko)
    {
        $data = $request->all();

        $mastertoko->update($data);

        //dd($data);

        return redirect()->route('mastertoko.index')->with('success', 'Data Telah diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mastertoko $mastertoko)
    {
        $mastertoko->delete();
        return redirect()->route('mastertoko.index')->with('success', 'Data Telah dihapus');
    }

    public function mastertokopdf() {
        $data = Mastertoko::all();

        $pdf = PDF::loadview('mastertoko/mastertokopdf', ['mastertoko' => $data]);
        return $pdf->download('laporan_mastertoko.pdf');
    }
}
