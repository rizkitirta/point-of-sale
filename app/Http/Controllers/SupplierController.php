<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //dd($kode);

        return view('supplier.index');
    }

    public function data()
    {
        $data = Supplier::orderBy('id', 'desc');

        return DataTables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('kode', function ($data) {
                return '<h5><span class="badge badge-secondary">' . $data->kode_supplier . '</span></h5>';
            })
            ->addColumn('aksi', function ($data) {
                return '
            <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary" onclick="editForm(`' . route('supplier.update', $data->id) . '`)"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(`' . route('supplier.destroy', $data->id) . '`)"><i class="fas fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'kode'])
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
            'nama' => 'required',
            'no_telpon' => 'required',
            'alamat' => 'required',
        ];

        $message = [
            'nama.required' => ' Kolom nama tidak boleh kosong!',
            'no_telpon.required' => ' Kolom telpon tidak boleh kosong!',
            'alamat.required' => ' Kolom alamat tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        //Auto numbering
        $now = Carbon::now();
        $number = $now->year . $now->month . $now->day;
        $kode = $number . rand(1, 1000000);

        $data = Supplier::create([
            'nama' => $request->nama,
            'no_telpon' => $request->no_telpon,
            'kode_supplier' => $kode,
            'alamat' => $request->alamat,
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
        $data = Supplier::find($id);
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
            'nama' => 'required',
            'no_telpon' => 'required',
            'alamat' => 'required',
        ];

        $message = [
            'nama.required' => ' Kolom nama tidak boleh kosong!',
            'no_telpon.required' => ' Kolom telpon tidak boleh kosong!',
            'alamat.required' => ' Kolom alamat tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $data = Supplier::findOrFail($id);
        $data->update([
            'nama' => $request->nama,
            'no_telpon' => $request->no_telpon,
            'alamat' => $request->alamat,
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
        $data = Supplier::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data gagal dihapus'], 422);
        }
    }
}
