<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //dd($kode);

        return view('pengeluaran.index');
    }

    public function data()
    {
        $data = Pengeluaran::orderBy('id_pengeluaran', 'desc');

        return DataTables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($data) {
                return tanggal_id($data->created_at);
            })
            ->addColumn('aksi', function ($data) {
                return '
            <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary" onclick="editForm(`' . route('pengeluaran.update', $data->id_pengeluaran) . '`)"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(`' . route('pengeluaran.destroy', $data->id_pengeluaran) . '`)"><i class="fas fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'created_at'])
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
        //dd($request->all());
        $rules = [
            'deskripsi' => 'required',
            'nominal' => 'required',
        ];

        $message = [
            'deskripsi.required' => ' Kolom deskripsi tidak boleh kosong!',
            'nominal.required' => ' Kolom nominal tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $data = Pengeluaran::create([
            'deskripsi' => $request->deskripsi,
            'nominal' => $request->nominal,
        ]);

        if ($data) {
            return response()->json(['message' => 'Data berhasil ditambahkan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal ditambahkan'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pengeluaran::find($id);
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
        $rules = [
            'deskripsi' => 'required',
            'nominal' => 'required',
        ];

        $message = [
            'deskripsi.required' => ' Kolom deskripsi tidak boleh kosong!',
            'nominal.required' => ' Kolom nominal tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $data = Pengeluaran::findOrFail($id);
        $data->update([
            'deskripsi' => $request->deskripsi,
            'nominal' => $request->nominal,
        ]);

        if ($data) {
            return response()->json(['message' => 'Data berhasil diupdate!'], 200);
        } else {
            return response()->json(['message' => 'Data gagal diupdate!'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pengeluaran::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data gagal dihapus'], 422);
        }
    }
}
