<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" class="form-horizontal">
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
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-md-2 col-md-offset-1 control-lable mt-2">Kategori</label>
                        <div class="col-md-8">
                            <input id="nama_kategori" class="form-control" type="text" name="nama_kategori">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
