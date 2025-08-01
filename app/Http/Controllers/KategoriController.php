<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $kategori = Kategori::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    }
                })->paginate(5);

                return response()->json($kategori, 200);
            }
        }
        $kategori = Kategori::paginate(10);
        return view("pengaturan.kategori",compact('kategori'));
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
            'nama' => 'required|string|unique:kategori,nama'
        ], [], [
            'nama' => 'kategori',
            'nama.unique' => 'Kategori sudah ada.',
            
        ]);

        Kategori::create(
            ["nama"=>$request->nama]
            
        );
        return redirect('pengaturan/kategori')->with('success', 'Kategori berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Kategori $kategori)
    {

        $kategori->nama = $request->nama;
        $kategori->save();

        return redirect('pengaturan/kategori')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect('pengaturan/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
