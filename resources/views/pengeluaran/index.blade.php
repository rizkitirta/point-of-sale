@extends('layouts.master')
@section('page', 'Pengeluaran')
@section('title', 'Pengeluaran')
@section('breadcrumb', 'Pengeluaran')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <button onclick="addForm('{{ route('pengeluaran.store') }}')"
                        class="btn btn-primary shadow float-right">
                        <i class="fa fa-plus-circle"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-light table-responsive table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Deskripsi</th>
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
    @include('pengeluaran.form')
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
                    url: '{{ route('pengeluaran.data') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'nominal'
                    },
                    {
                        data: 'deskripsi'
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
            $('#modal-form .modal-title').text('Tambah Pengeluaran')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('post')
            $('#modal-form [name=deskripsi]').focus()
        }

        //Call edit modal
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Pengeluaran')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('put')
            $('#modal-form [name=deskripsi]').focus()

            $.get(url)
                .done((response) => {
                    $('#modal-form [name="deskripsi"]').val(response.deskripsi)
                    $('#modal-form [name="nominal"]').val(response.nominal)
                })
                .fail((errors) => {
                    alert('Ups Terjadi Kesalahan!')
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
