<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mastersupplier;

class MastersupplierController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $mastersupplier = Mastersupplier::where('name', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $mastersupplier = Mastersupplier::paginate(10);
        }
        return view('mastersupplier.index',[
            'mastersupplier' => $mastersupplier
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mastersupplier.create');
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

        Mastersupplier::create($data);

        return redirect()->route('mastersupplier.index')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = Mastersupplier::find($id);
        // // dd($data);
        // return view('Mastersupplier.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mastersupplier $mastersupplier)
    {
        return view('mastersupplier.edit', [
            'item' => $mastersupplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mastersupplier $mastersupplier)
    {
        $data = $request->all();

        $mastersupplier->update($data);

        return redirect()->route('mastersupplier.index')->with('success', 'Data Telah diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mastersupplier $mastersupplier)
    {
        $mastersupplier->delete();
        return redirect()->route('mastersupplier.index')->with('success', 'Data Telah dihapus');
    }

    public function mastersupplierpdf() {
        $data = Mastersupplier::all();

        $pdf = PDF::loadview('mastersupplier/mastersupplierpdf', ['mastersupplier' => $data]);
        return $pdf->download('laporan_mastersupplier.pdf');
    }
}

