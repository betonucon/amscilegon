@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span onclick="history.back()" class="btn btn-sm btn-info mb-3">Kembali</span>
                <span onclick="cetak()" class="btn btn-sm btn-danger mb-3">Download</span>
                <div class="card">
                    <div class="card-body">
                        <table id="data-table-fixed-header" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" scope="col">No</th>
                                    <th>Kondisi</th>
                                    <th>Kriteria</th>
                                    <th>Penyebab</th>
                                    <th>Akibat</th>
                                    <th width="20%" scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="modal-tambah-uraian-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-uraian" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-tambah-uraian"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-tambah-uraian"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-uraian-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-uraian" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-edit-uraian"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-edit-uraian"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ajax')
<script>
    var handleDataTableFixedHeader = function() {
        "use strict";
        if ($('#data-table-fixed-header').length !== 0) {
            var table=$('#data-table-fixed-header').DataTable({
                lengthMenu: [20, 40, 60],
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: true,
                ajax:"{{ url('pelaporan/tindak-lanjut/get-table?id_program_kerja=')}}+{{$data->id}}",
                columns: [
                { data: 'id', render: function (data, type, row, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'kondisi' },
                { data: 'kriteria' },
                { data: 'penyebab' },
                { data: 'akibat' },
                { data: 'action' },
                ],
                language: {
                    paginate: {
                        previous: '<< previous',
                        next: 'Next>>'
                    }
                }
            });
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
			TableManageFixedHeader.init();
		});
</script>

<script>
     function rekomendasi(id){
        location.assign("{{url('pelaporan/tindak-lanjut/view-rekomendasi?id=')}}" + id);
    }
    function cetak(){
        location.assign("{{url('pelaporan/tindak-lanjut/cetak')}}");
    }

</script>
@endpush
