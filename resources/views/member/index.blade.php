@extends('layouts.master')
@section('page', 'Kategori')
@section('title', 'Kategori')
@section('breadcrumb', 'Kategori')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <button type="button" onclick="deleteSelected('{{ route('member.deleteSelected') }}')"
                        class="btn btn-danger shadow">
                        <i class="fas fa-trash-alt"></i> Delete Selected</button>
                    <button onclick="cetakMember('{{ route('member.cetak') }}')" class="btn btn-info"><i
                            class="fas fa-id-card nav-icon"></i> Cetak Member</button>
                    <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-primary shadow float-right">
                        <i class="fa fa-plus-circle"></i> Tambah</button>

                </div>
                <div class="card-body">
                    <form action="" method="post" id="form-member">
                        @csrf
                        <table class="table table-light table-responsive table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="select_all" id="select_all"></th>
                                    <th width="5%">No</th>
                                    <th>Kategori</th>
                                    <th>Kode</th>
                                    <th>Telpon</th>
                                    <th>Alamat</th>
                                    <th width="5%">
                                        <li class="fa fa-cog"></li>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('member.form')
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
                    url: '{{ route('member.data') }}'
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'no_telpon'
                    },
                    {
                        data: 'alamat'
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
            $('#modal-form .modal-title').text('Tambah Kategori')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('post')
            $('#modal-form [name=nama_kategori]').focus()
        }

        //Call edit modal
        function editForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Kategori')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('put')
            $('#modal-form [name=nama_kategori]').focus()

            $.get(url)
                .done((response) => {
                    $('#modal-form [name="nama"]').val(response.nama)
                    $('#modal-form [name="no_telpon"]').val(response.no_telpon)
                    $('#modal-form [name="alamat"]').val(response.alamat)
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


        //Select all checkbox
        $('[name=select_all]').click(function() {
            $(':checkbox').prop('checked', this.checked)
        })

        //Delete selected
        function deleteSelected(url) {
            if ($('input:checked').length > 1) {
                if (confirm('Apakah anda yakin?')) {
                    $.post(url, $('#form-member').serialize())
                        .done((res) => {
                            console.log(res)
                            table.ajax.reload()
                            Swal.fire('Deleted!', res.message, 'success')
                        })
                        .fail((error) => {
                            console.log(res.message)
                            alert('Tidak dapat mengahpus data!')
                            return;
                        })
                }
            }
        }

        //Cetak member'
        function cetakMember(url) {
            if ($('input:checked').length < 1) {
                alert('Pilih member yang akan dicetak!')
                return;
            } else {
                $('#form-member')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit()
            }
        }
    </script>
@endpush
