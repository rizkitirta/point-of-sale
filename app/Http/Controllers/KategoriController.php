<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $data = Kategori::orderBy('id_kategori', 'desc')->get();
        return DataTables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                return '
            <div class="btn-group">
            <button class="btn btn-sm btn-primary" onclick="editForm(`' . route('kategori.update', $data->id_kategori) . '`)"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('kategori.update', $data->id_kategori) . '`)"><i class="fas fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kategori::create($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Kategori::find($id);
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Kategori::find($id);
        $data->nama_kategori = $request->nama_kategori;
        $data->update();


        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        $data->delete();

        return response()->json('Data Berhasil Dihapus!', 204);
    }
}
