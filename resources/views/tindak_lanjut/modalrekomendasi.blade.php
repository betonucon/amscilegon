<div class="card">
    <input type="hidden" name="id_rekom" value="{{ $data->id_rekom }}" >
    <input type="hidden" name="id_program_kerja" value="{{ $data->id_program_kerja }}" >
    <input type="hidden" name="kondisi" value="{{ $data->kondisi }}" >
    <input type="hidden" name="kriteria" value="{{ $data->kriteria }}" >
    <input type="hidden" name="penyebab" value="{{ $data->penyebab }}" >
    <input type="hidden" name="rekomendasi" value="{{ $data->rekomendasi }}" >
    <input type="hidden" name="akibat" value="{{ $data->akibat }}" >
    <input type="hidden" name="parent_id" value="{{ $lhp->parent_id }}" >
    <input type="hidden" name="grouping" value="{{ $data->grouping }}" >
    <input type="hidden" name="id_tindak_lanjut" value="{{ $id_tindak }}" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <input type="text" readonly name="kondisi" class="form-control" value="{{ $lhp->kondisi }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kriteria</label>
                        <input type="text" readonly name="kriteria" class="form-control" value="{{ $lhp->kriteria }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Penyebab</label>
                        <input type="text" readonly name="penyebab" class="form-control" value="{{ $lhp->penyebab }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Akibat</label>
                        <input type="text" readonly name="akibat" class="form-control" value="{{ $lhp->akibat }}">
                    </div>
                </div>
                {{-- @if ($data->parent_id == 0)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Rekomendasi</label>
                            <input type="text" name="uraian_rekomendasi" class="form-control">
                        </div>
                    </div>
                @else --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Rekomendasi</label>
                        <select name="uraian_rekomendasi" class="form-control" id="uraian_rekomendasi" onchange="carijawaban(this.value)">
                            {{-- <option value="">Pilih Rekomedasi</option> --}}
                            <option value="{{ $lhp->id_rekom }}" @if ($lhp->id_rekom==$data->parent_id) selected @endif>{{ $lhp->uraian_rekomendasi }}</option>
                            {{-- @foreach (rekomedasi($data->grouping,$data->id_rekom) as $d)
                                <option value="{{ $d->id_rekom }}" @if ($d->id_rekom==$data->parent_id) selected @endif>{{ $d->uraian_rekomendasi }}</option>
                            @endforeach --}}
                        </select>
                        {{-- <input type="text" name="uraian_rekomendasi" class="form-control" value="{{ $data->uraian_rekomendasi }}"> --}}
                    </div>
                </div>
                {{-- @endif --}}
            {{-- @if ($data->parent_id == 0)
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <input type="text" name="uraian_jawaban" class="form-control">
                    </div>
                </div>
            @else --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <input type="text" name="uraian_jawaban" id="uraian_jawaban" class="form-control">
                    </div>
                </div>
            {{-- @endif --}}
            </div>
        </div>
    </div>
</div>

<script>

</script>


