<input type="hidden" name="id" class="form-control" value="{{$data->id}}">
<input type="hidden" name="hidden_file" class="form-control"value="{{$data->file_jawaban}}">
<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <input type="text" name="jawaban" class="form-control" value="{{$data->jawaban}}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" name="file_jawaban" class="form-control">
                    </div>
                </div>
            </div>
        </div>
</div>
