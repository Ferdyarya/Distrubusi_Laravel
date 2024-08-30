<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masterpegawai;
use PDF;

class MasterpegawaiController extends Controller
{
    // NEW
    public function index(Request $request)
    {
        if($request->has('search')){
            $masterpegawai = Masterpegawai::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masterpegawai = Masterpegawai::paginate(10);
        }
        return view('masterpegawai.index',[
            'masterpegawai' => $masterpegawai
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masterpegawai.create');
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

        Masterpegawai::create($data);

        return redirect()->route('masterpegawai.index')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datapegawai = Masterpegawai::find($id);
        // // dd($data);
        // return view('masterpegawai.edit', compact('datapegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Masterpegawai $masterpegawai)
    {
        return view('masterpegawai.edit', [
            'item' => $masterpegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masterpegawai $masterpegawai)
    {
        $data = $request->all();

        $masterpegawai->update($data);

        //dd($data);

        return redirect()->route('masterpegawai.index')->with('success', 'Data Telah diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masterpegawai $masterpegawai)
    {
        $masterpegawai->delete();
        return redirect()->route('masterpegawai.index')->with('success', 'Data Telah dihapus');
    }

    public function masterpegawaipdf() {
        $data = Masterpegawai::all();

        $pdf = PDF::loadview('masterpegawai/masterdatapdf', ['masterpegawai' => $data]);
        return $pdf->download('laporan_masterdatapegawai.pdf');
    }



}


