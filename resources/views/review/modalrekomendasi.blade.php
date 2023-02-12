<div class="card">
    <input type="hidden" name="id_rekom" value="{{ $data->id_rekom }}" >
    <input type="hidden" name="id_program_kerja" value="{{ $data->id_program_kerja }}" >
    <input type="hidden" name="kondisi" value="{{ $data->kondisi }}" >
    <input type="hidden" name="kriteria" value="{{ $data->kriteria }}" >
    <input type="hidden" name="penyebab" value="{{ $data->penyebab }}" >
    <input type="hidden" name="akibat" value="{{ $data->akibat }}" >
    <input type="hidden" name="parent_id" value="{{ $data->parent_id }}" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <input type="text" readonly name="kondisi" class="form-control" value="{{ $data->kondisi }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kriteria</label>
                        <input type="text" readonly name="kriteria" class="form-control" value="{{ $data->kriteria }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Penyebab</label>
                        <input type="text" readonly name="penyebab" class="form-control" value="{{ $data->penyebab }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Akibat</label>
                        <input type="text" readonly name="akibat" class="form-control" value="{{ $data->akibat }}">
                    </div>
                </div>
                @if ($data->parent_id == 0)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Rekomendasi</label>
                            <input type="text" name="uraian_rekomendasi" class="form-control">
                        </div>
                    </div>  
                @else
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Rekomendasi</label>
                            <input type="text" name="uraian_rekomendasi" class="form-control" value="{{ $data->uraian_rekomendasi }}">
                        </div>
                    </div>    
                @endif
            </div>
        </div>
    </div>
</div>

<script>

</script>


