@extends('layouts.app')

@section('content')
{{-- <input type="hidden" name="id" value="{{ $data->id }}"> --}}


<div class="page-content">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="form-data" method="post" action="{{ url('perencanaan/program-kerja-pengawasan/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Hak Akses</label>
                        <select class="form-control"  name="grouping">
                            <option value=""> --Pilih-- </option>
                            @foreach ($user as $el)
                            <option value="{{ $el->sts }}">{{ $el->name.'-'.$el->nama }} </option>
                        @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">PKP</label>
                        <input class="form-control" type="file" name="pkp" id="pkp" required>
                        <span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`{{ $data->pkp }}`)"><img src="{{ asset('public/img/pdf-file.png') }}" width="10px" height="10px"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nota Dinas</label>
                        <input class="form-control" type="file" name="nota_dinas" id="nota_dinas" required>
                        <span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`{{ $data->nota_dinas }}`)"><img src="{{ asset('public/img/pdf-file.png') }}" width="10px" height="10px"></span>
                    </div>

                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="data-table-fixed-header" class="table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                    <thead>
                                        <tr>
                                            <th width="1%" scope="col">Pilih</th>
                                            <th>No</th>
                                            <th >Jenis</th>
                                            <th >Area Pengawasan</th>
                                            <th >Jenis Pengawasan</th>
                                            <th >OPD</th>
                                            <th >RMP</th>
                                            <th >RPL</th>
                                            <th >Sarana & Prasarana</th>
                                            <th >Tingkat Resiko</th>
                                            <th >Keterangan</th>
                                            <th >Tujuan</th>
                                            <th >Koorwas</th>
                                            <th >PT</th>
                                            <th >KT</th>
                                            <th >AT</th>
                                            <th >Jumlah</th>
                                            <th >Jumlah Laporan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row mb-1 mx-1">
                <div class="col-md-6">
                    <button id="btn-save" class="btn btn-success btn-sm">Simpan</button>
                </div>
            </div>
        </form>
        </div>
        <div class="modal fade" id="modalshow" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-refused" enctype="multipart/form-data">
							@csrf
							<div id="tampil-pdf"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hide()">Tutup</button>
						<button id="btn-refused"  class="btn btn-success">Simpan</button>

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
    function buka_file(file){
        $('#modalshow').modal('show');
        var files=file.split(".");
        var surat =files[3];
        if(surat=='pdf'){
            $('#tampil-pdf').html('<embed src="{{ url('public/file_upload') }}/'+file+'" width="100%" height="500px">');
        }else{
            $('#tampil-pdf').html('<embed src="{{ url('public/file_upload') }}/'+file+'" width="100%" height="500px">');
        }
    }
 $('#btn-save').on('click', () => {
        var form=document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{url('perencanaan/program-kerja-pengawasan/store')}}",
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
                                window.location.href = "{{url('perencanaan/program-kerja-pengawasan')}}";
                            }
                        })
                    }
                }
            });
    });
</script>
<script>
    //   function getTable(jenis){
    //         var table=$('#data-table-fixed-header').DataTable();
	// 		table.ajax.url("{{ url('perencanaan/program-kerja-pengawasan/getTable')}}?jenis="+jenis).load();
    //     }

        var handleDataTableFixedHeader = function() {
        "use strict";
        if ($('#data-table-fixed-header').length !== 0) {
            var table=$('#data-table-fixed-header').DataTable({
                lengthMenu: [20, 40, 60],
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: false,
                ajax:"{{ url('perencanaan/program-kerja-pengawasan/getTable')}}",
                "columnDefs": [
                    { "width": "1%", "targets": 0 }
                ],
                columns: [
                    { data: 'id', render: function (data, type, row, meta)
                        {
                            return '<input type="radio"  name="id_pkpt" value="'+data+'" >';
                        }
                    },
                    {data: 'id', render: function (data, type, row, meta)
                        {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'jenis' },
                    { data: 'area_pengawasan' },
                    { data: 'jenis_pengawasan' },
                    { data: 'opd' },
                    { data: 'rmp' },
                    { data: 'rpl' },
                    { data: 'sarana_prasarana' },
                    { data: 'tingkat_resiko' },
                    { data: 'keterangan' },
                    { data: 'tujuan' },
                    { data: 'koorwas' },
                    { data: 'pt' },
                    { data: 'kt' },
                    { data: 'at' },
                    { data: 'jumlah' },
                    { data: 'jumlah_laporan' },
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
