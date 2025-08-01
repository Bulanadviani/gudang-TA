<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // for search feature
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $status = Status::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%')
                                    ->orWhere('jenis', 'like', '%' . $keyword . '%');
                    }
                    })->paginate(5);
                return response()->json($status, 200);
            }
        }
        $status = Status::paginate(10);
        return view("pengaturan.status",compact('status'));
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
            'nama' => 'required|string|unique:status,nama'
        ], [], [
            'nama' => 'status',
            'nama.unique' => 'Status sudah ada.',
        ]); 
        Status::create(
            [
                "nama"=>$request->nama,
                "jenis"=>$request->jenis
            ]
        );
        return redirect('pengaturan/status')->with('success', 'Status berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Status $status)
    {

        $status->nama = $request->nama;
        $status->jenis = $request->jenis;
        $status->save();

        return redirect('pengaturan/status')->with('success', 'Status berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return redirect('pengaturan/status')->with('success', 'Status berhasil dihapus');
    }
}
