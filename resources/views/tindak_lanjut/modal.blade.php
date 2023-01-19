<div class="card">
    <input type="hidden" name="id" value="{{ $lhp->id }}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nomor Surat Perintah</label>
                        @if ($lhp->id==null)
                            <input readonly type="text" name="no_sp" class="form-control" value="{{$sp->no_sp}}">                                      
                        @else
                            <input readonly type="text" name="no_sp" class="form-control" value="{{$lhp->no_sp}}">
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Temuan</label>
                        <input readonly type="text" name="uraian_temuan" class="form-control" value="{{ $lhp->uraian_temuan }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Penyebab</label>
                        <input readonly type="text" name="uraian_penyebab" class="form-control" value="{{ $lhp->uraian_penyebab }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Rekomendasi</label>
                        <input readonly type="text" name="uraian_rekomendasi" class="form-control" value="{{ $lhp->uraian_rekomendasi }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Uraian Tindak Lanjut</label>
                        <input type="text" name="uraian_tindak_lanjut" class="form-control" required>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nilai Rekomendasi</label>
                        <input type="text" name="nilai_rekomendasi" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nilai Tindak Lanjut</label>
                        <input type="text" name="nilai_tindak_lanjut" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status Nilai</label>
                        <input type="text" name="status_nilai" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Pilih Status</option>
                            @foreach ($status as $el)
                                <option value="{{ $el->kode }}">{{ $el->status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

</script>


