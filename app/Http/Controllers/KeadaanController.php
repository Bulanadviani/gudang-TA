<?php

namespace App\Http\Controllers;

use App\Models\Keadaan;
use Illuminate\Http\Request;

class KeadaanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // for search feature
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $keadaan = Keadaan::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    }
                })->paginate(5);
                return response()->json($keadaan, 200);
            }
        }
        $keadaan = Keadaan::paginate(10);
        return view("pengaturan.keadaan",compact('keadaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:keadaan,nama'
        ], [], [
            'nama' => 'keadaan',
            'nama.unique' => 'Keadaan sudah ada.',
        ]);
        
        Keadaan::create(
            ["nama"=>$request->nama]
        );
        return redirect('pengaturan/keadaan')->with('success', 'Keadaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keadaan $keadaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keadaan $keadaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Keadaan $keadaan)
    {

        $keadaan->nama = $request->nama;
        $keadaan->save();

        return redirect('pengaturan/keadaan')->with('success', 'Keadaan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keadaan $keadaan)
    {
        $keadaan->delete();
        return redirect('pengaturan/keadaan')->with('success', 'Keadaan berhasil dihapus');
    }
}
