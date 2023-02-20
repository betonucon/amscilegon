<div class="card">
    <input type="hidden" name="id" value="{{ $data->id }}" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <input type="text" name="kondisi" class="form-control" value="{{$data->kondisi}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kriteria</label>
                        <input type="text" name="kriteria" class="form-control" value="{{$data->kriteria}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Penyebab</label>
                        <input type="text" name="penyebab" class="form-control" value="{{$data->penyebab}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Akibat</label>
                        <input type="text" name="akibat" class="form-control" value="{{$data->akibat}}">
                    </div>
                </div>
            </div>
        </div>
</div>



