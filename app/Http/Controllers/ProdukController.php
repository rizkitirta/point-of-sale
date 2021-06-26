<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $thn_bulan = $now->year . $now->month;
        $cek_number = Produk::count();
        if ($cek_number == 0) {
            $no_urut = '';
            $number = 'KD' . $thn_bulan . $no_urut;
            //dd($number);
        } else {
            $get =  Produk::all()->last();
            $no_urut = (int)substr($get->id, -4) + 1;
            $number = 'KD' . $thn_bulan . $no_urut;
        }

        $data = Kategori::all();
        return view('produk.index', compact('data', 'number'));
    }

    public function data()
    {
        $data = Produk::leftjoin('kategoris', 'kategoris.id', 'produks.id_kategori')
            ->select('produks.*', 'nama_kategori')
            ->orderBy('id', 'desc')
            ->get();

        return DataTables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                return '<input type="checkbox" name="id_produk[]" value="' . $data->id . '">';
            })
            ->addColumn('kode', function ($data) {
                return '<h5><span class="badge badge-secondary">' . $data->kode . '</span></h5>';
            })
            ->addColumn('harga_beli', function ($data) {
                return format_uang($data->harga_beli);
            })
            ->addColumn('harga_jual', function ($data) {
                return format_uang($data->harga_jual);
            })
            ->addColumn('stok', function ($data) {
                return format_uang($data->stok);
            })
            ->addColumn('aksi', function ($data) {
                return '
            <div class="btn-group">
            <button class="btn btn-sm btn-primary" onclick="editForm(`' . route('produk.update', $data->id) . '`)"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('produk.destroy', $data->id) . '`)"><i class="fas fa-trash"></i></button>
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
        $rules = [
            'nama_produk' => 'required|unique:produks,nama_produk',
            'merek' => 'required|string',
            'id_kategori' => 'required|integer',
            'kode' => 'required|string',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'diskon' => 'required|integer',
            'stok' => 'required|integer',
        ];
        $message = [
            'nama_produk.required' => ' Kolom nama tidak boleh kosong!',
            'nama_produk.unique' => ' Nama produk sudah digunakan!',
            'merek.required' => ' Kolom merek tidak boleh kosong!',
            'id_kategori.required' => ' Kolom kategori tidak boleh kosong!',
            'id_kategori.integer' => ' Kolom kategori berupa integer!',
            'kode.required' => ' Kolom kode tidak boleh kosong!',
            'harga_beli.required' => ' Kolom harga_beli tidak boleh kosong!',
            'harga_beli.integer' => ' Kolom harga beli berupa angka!',
            'harga_jual.required' => ' Kolom harga_jual tidak boleh kosong!',
            'harga_jual.integer' => ' Kolom harga jual berupa angka!',
            'stok.required' => 'Kolom stok tidak boleh kosong!',
            'stok.integer' => 'Kolom stok berupa angka!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $data = Produk::create($request->all());
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
        $data = Produk::find($id);
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
        $data = Produk::find($id);
        $data->update($request->all());


        return response()->json(['message' => 'Data Berhasil Disimpan'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Produk::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data gagal dihapus'], 422);
        }
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response()->json(['message' => 'Data Yang Dipilih Berhasil Dihapus!']);
    }

    public function cetakBarcode(Request $request)
    {
        $data = [];
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $data[] = $produk;
        }

        $pdf = PDF::loadView('produk.barcode', compact('data'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
