<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" class="form-horizontal" id="form">
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
                                <label for="deskripsi">Deskripsi</label>
                                <input id="deskripsi" class="form-control" type="text" autocomplete="off"
                                    name="deskripsi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input id="nominal" class="form-control" type="text" autocomplete="off" name="nominal">
                            </div>
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
