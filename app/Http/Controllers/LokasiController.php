<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // for search feature
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $lokasi = Lokasi::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    }
                })->paginate(5);
                return response()->json($lokasi, 200);
            }
        }
        $lokasi = Lokasi::paginate(10);
        return view("pengaturan.lokasi",compact('lokasi'));
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
            'nama' => 'required|string|unique:lokasi,nama'
        ], [], [
            'nama' => 'lokasi',
            'nama.unique' => 'Lokasi sudah ada.',
        ]);

        Lokasi::create(
            ["nama"=>$request->nama]
        );
        return redirect('pengaturan/lokasi')->with('success', 'Lokasi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Lokasi $lokasi)
    {

        $lokasi->nama = $request->nama;
        $lokasi->save();

        return redirect('pengaturan/lokasi')->with('success', 'Lokasi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();
        return redirect('pengaturan/lokasi')->with('success', 'Lokasi berhasil dihapus');
    }
}
