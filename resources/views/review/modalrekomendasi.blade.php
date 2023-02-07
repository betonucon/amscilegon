<div class="card">
    <input type="hidden" name="id_rekom" value="{{ $data->id_rekom }}" >
    <input type="hidden" name="id_program_kerja" value="{{ $data->id_program_kerja }}" >
    <input type="hidden" name="uraian_temuan" value="{{ $data->uraian_temuan }}" >
    <input type="hidden" name="uraian_penyebab" value="{{ $data->uraian_penyebab }}" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Temuan</label>
                        <input disabled type="text" name="uraian_temuan" class="form-control" value="{{ $data->uraian_temuan }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Penyebab</label>
                        <input disabled type="text" name="uraian_penyebab" class="form-control" value="{{ $data->uraian_penyebab }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Rekomendasi</label>
                        <input type="text" name="uraian_rekomendasi" class="form-control">
                    </div>
                </div>

                <div class="col-md-6" hidden>
                    <div class="mb-3">
                        <label class="form-label">File </label>
                        <input type="file" name="file_lhp" class="form-control">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

</script>


