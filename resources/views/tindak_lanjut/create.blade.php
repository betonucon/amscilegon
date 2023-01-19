@extends('layouts.app')

@section('content')
<div class="page-content">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">

        {{-- <div class="row pb-3">
            <div class="col-sm-12 col-md-6">
                <span onclick="tambah({{ $data->id }})" class="btn btn-sm btn-primary waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Tambah</span>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-body">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="data-table-fixed-header" class="table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                    <thead>
                                        <tr>
                                            <th width="1%" scope="col">No</th>
                                            <th>Uraian Temuan</th>
                                            <th>Uraian Penyebab</th>
                                            <th>Uraian Rekomendasi</th>
                                            <th >Uraian Tidak Lanjut</th>
                                            <th >Nilai Rekomendasi</th>
                                            <th >Nilai Tindak Lanjut</th>
                                            <th >Status Nilai</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="modal fade" id="modalAdd" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
                        <form id="form-data" enctype="multipart/form-data">
							@csrf
                            <input type="hidden" id="id_pkpt" name="id_pkpt" value="{{ $data->id }}">
							<div id="tampil-form"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hide()">Tutup</button>
						<button id="btn-save"  class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>

    </div>
</div>
</div>
</div>

@endsection

@push('ajax')

<script>

    function hide(){
        $('#modalAdd').modal('hide');
    }

    function tambah(id_pkpt){
        $('#btn-save').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/modal')}}",
            data: "id_pkpt="+id_pkpt,
            success: function(msg){
                $('#tampil-form').html(msg);
                $('#modalAdd').modal('show');

            }
        });
	}

    function edit(id){
        $('#btn-save').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/modal')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-form').html(msg);
                $('#modalAdd').modal('show');

            }
        });
	}

    $('#btn-save').on('click', () => {
        var form=document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/tindak-lanjut/store')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-save').attr('disabled', 'disabled');
                    $('#btn-save').html('Sending..');
                },
                error: function (msg) {
                        var data = msg.responseJSON;
                        $.each(data.errors, function (key, value) {
                            Swal.fire({
                                title: 'Gagal',
                                text: value,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $('#btn-save').removeAttr('disabled','false');
                                $('#btn-save').html('Simpan');
                            }
                        })
                        });
                },
                success:  function (msg) {
                    if (msg.status == 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: msg.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }
                }
            });
        });
</script>

<script>
        var handleDataTableFixedHeader = function() {
        "use strict";
        var id_pkpt=$('#id_pkpt').val();
        if ($('#data-table-fixed-header').length !== 0) {
            var table=$('#data-table-fixed-header').DataTable({
                
                lengthMenu: [20, 40, 60],
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: false,
                ajax:"{{ url('pelaporan/tindak-lanjut/get-table?id_pkpt=')}}"+id_pkpt,
                "columnDefs": [
                    { "width": "1%", "targets": 0 }
                ],
                columns: [
                    {data: 'id', render: function (data, type, row, meta)
                        {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'uraian_temuan' },
                    { data: 'uraian_penyebab' },
                    { data: 'uraian_rekomendasi' },
                    { data: 'uraian_tindak_lanjut' },
                    { data: 'nilai_rekomendasi' },
                    { data: 'nilai_tindak_lanjut' },
                    { data: 'status_nilai' },
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
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
			TableManageFixedHeader.init();

		});

</script>

@endpush
