<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // for search feature
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $merk = Merk::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    }
                })->paginate(5);
                return response()->json($merk, 200);
            }
        }
        $merk = Merk::paginate(10);
        return view("pengaturan.merk",compact('merk'));
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
            'nama' => 'required|string|unique:merk,nama'
        ], [], [
            'nama' => 'merk',
            'nama.unique' => 'Merk sudah ada.',
        ]);

        Merk::create(
            ["nama"=>$request->nama]
        );
        return redirect('pengaturan/merk')->with('success', 'Merk berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merk $merk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merk $merk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Merk $merk)
    {
        $merk->nama = $request->nama;
        $merk->save();

        return redirect('pengaturan/merk')->with('success', 'Merk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merk $merk)
    {
        $merk->delete();
        return redirect('pengaturan/merk')->with('success', 'Merk berhasil dihapus');
    }
}
