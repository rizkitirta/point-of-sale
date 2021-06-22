@extends('layouts.master')
@section('page', 'produk')
@section('title', 'produk')
@section('breadcrumb', 'produk')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-sm btn-primary shadow">
                        <i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="card-body">
                    <table class="table table-light table-responsive table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Merek</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th width="5%">
                                    <li class="fa fa-cog"></li>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('produk.form')
@endsection
@push('script')
    <script>
        let table;

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('produk.data') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'merek'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            })
        })

        $('#modal-form').on('submit', function(e) {
            if (!e.preventDefault()) {
                $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: 'post',
                        data: $('#modal-form form').serialize()
                    })
                    .done((response) => {
                        $('#modal-form').modal('hide')
                        table.ajax.reload()
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        })
                    })
                    .fail((errors) => {
                        Toast.fire({
                            icon: 'error',
                            title: errors.responseJSON.message
                        })
                        return;
                    })
            }
        })

        //Call add modal
        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Tambah produk')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('post')
            $('#modal-form [name=nama_produk]').focus()
        }

        //Call edit modal
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit produk')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('put')
            $('#modal-form [name=nama_produk]').focus()

            $.get(url)
                .done((response) => {
                    $('#modal-form [name="nama_produk"]').val(response.nama_produk)
                    $('#modal-form [name="merek"]').val(response.merek)
                    $('#modal-form [name="id_kategori"]').val(response.id_kategori)
                    $('#modal-form [name="kode"]').val(response.kode)
                    $('#modal-form [name="harga_beli"]').val(response.harga_beli)
                    $('#modal-form [name="harga_jual"]').val(response.harga_jual)
                    $('#modal-form [name="diskon"]').val(response.diskon)
                    $('#modal-form [name="stok"]').val(response.stok)
                })
                .fail((errors) => {
                    alert('Terjadi Kesalahan!')
                    return;
                })
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            _token: '{{ csrf_token() }}',
                            _method: 'delete'
                        })
                        .done((response) => {
                            table.ajax.reload()
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
                        })
                        .fail((error) => {
                            alert('Data gagal dihapus!')
                            return;
                        })
                }
            })
        }
    </script>
@endpush
