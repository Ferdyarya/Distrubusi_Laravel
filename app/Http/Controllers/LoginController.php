<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() {
        return view('login');
    }

    public function loginuser(Request $request) {
        // return($request->all());
       if(Auth::attempt($request->only('email','password'))){
            return redirect('/');
        }
        return redirect('login')->with('toast_success', 'Login Berhasil');
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }

    // NEW
    public function index(Request $request)
    {
        if($request->has('search')){
            $masteruser = User::where('name', 'LIKE', '%' .$request->search.'%')->paginate(10);
        }else{
            $masteruser = User::paginate(10);
        }
        return view('masteruser.index',[
            'masteruser' => $masteruser
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masteruser.create');
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

        User::create($data);

        return redirect()->route('masteruser.index')->with('success', 'Data Telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $datauser = Masteruser::find($id);
        // // dd($data);
        // return view('masteruser.edit', compact('datauser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $masteruser)
    {
        return view('masteruser.edit', [
            'item' => $masteruser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $masteruser)
    {
        $data = $request->all();

        $masteruser->update($data);

        //dd($data);

        return redirect()->route('masteruser.index')->with('success', 'Data Telah diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $masteruser)
    {
        $masteruser->delete();
        return redirect()->route('masteruser.index')->with('success', 'Data Telah dihapus');
    }

    // public function masteruserpdf() {
    //     $data = User::all();

    //     $pdf = PDF::loadview('masteruser/masterdatapdf', ['masteruser' => $data]);
    //     return $pdf->download('laporan_masterdatauser.pdf');
    // }
}
