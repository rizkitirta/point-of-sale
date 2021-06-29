<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('member.index');
    }

    public function data()
    {
        $data = Member::orderBy('id', 'desc');

        return DataTables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                return '<input type="checkbox" name="id_member[]" value="' . $data->id . '">';
            })
            ->addColumn('kode', function ($data) {
                return '<h5><span class="badge badge-secondary">' . $data->kode . '</span></h5>';
            })
            ->addColumn('aksi', function ($data) {
                return '
            <div class="btn-group">
            <button class="btn btn-sm btn-primary" onclick="editForm(`' . route('member.update', $data->id) . '`)"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('member.destroy', $data->id) . '`)"><i class="fas fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'kode', 'select_all'])
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
        $modelCount = Member::count();
        $modelLast = Member::all()->last();
        $get = $modelLast;
        $query = $get->kode_member;

        $number = autoNumber($modelCount,$modelLast,$query);
        //dd($number);

        $data = Member::create([
            'nama' => $request->nama,
            'no_telpon' => $request->no_telpon,
            'kode_member' => $number,
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
        $data = Member::find($id);
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
            'nama' => 'required|unique:members,nama',
            'kode' => 'required|unique:members,kode_member',
            'no_telpon' => 'required',
            'kode' => 'required',
        ];

        $message = [
            'nama.required' => ' Kolom nama tidak boleh kosong!',
            'kode.required' => ' Kolom nama tidak boleh kosong!',
            'kode.unique' => ' Kode member sudah digunakan!',
            'no_telpon.required' => ' Kolom telpon tidak boleh kosong!',
            'alamat.required' => ' Kolom alamat tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $data = Member::find($id);
        $data->update($request->all());

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
        $data = Member::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data gagal dihapus'], 422);
        }
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $member->delete();
        }

        return response()->json(['message' => 'Data Yang Dipilih Berhasil Dihapus!']);
    }

    public function cetakBarcode(Request $request)
    {
        $data = [];
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $data[] = $member;
        }

        $pdf = PDF::loadView('member.barcode', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('member.pdf');
    }
}
