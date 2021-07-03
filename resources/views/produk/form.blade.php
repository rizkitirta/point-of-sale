<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('produk.store') }}" method="POST" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-formLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input id="nama_produk" class="form-control" type="text" name="nama_produk">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="merek">Merek Produk</label>
                                <input id="merek" class="form-control" type="text" name="merek">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="id_kategori">Kategori</label>
                                <select id="id_kategori" class="form-control" name="id_kategori">
                                    <option>Pilih Kategori</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="kode_produk">Kode Produk</label>
                                <input id="kode_produk" class="form-control" type="text" name="kode_produk" placeholder=""
                                    value="{{ $kode }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input id="harga_beli" class="form-control" type="number" name="harga_beli">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input id="harga_jual" class="form-control" type="number" name="harga_jual">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input id="diskon" class="form-control" type="number" name="diskon">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="stok">Stok Produk</label>
                                <input id="stok" class="form-control" type="number" name="stok">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
