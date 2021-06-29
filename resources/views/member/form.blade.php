<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('member.store') }}" method="POST" class="form-horizontal" id="form">
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
                                <label for="nama">Nama Member</label>
                                <input autocomplete="off" id="nama" class="form-control" type="text"
                                    name="nama">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="no_telpon">Telpon</label>
                                <input autocomplete="off" id="no_telpon" class="form-control" type="text" name="no_telpon">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" class="form-control" name="alamat" rows="3"></textarea>
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
