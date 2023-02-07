@extends('layouts.app')

@section('content')
<div class="page-content">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">

        <div class="row pb-3">
            <div class="col-sm-12 col-md-6">
                <span onclick="back()" class="btn btn-sm btn-danger waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Kembali</span>
                <span onclick="tambah({{$data->id}},0)" class="btn btn-sm btn-primary waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Tambah Uraian</span>
                <span onclick="selesai({{$data->id}})" class="btn btn-sm btn-success waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Selesai</span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="shiftTable" class="table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                    <thead>
                                        <tr>
                                            <th width="1%" scope="col">No</th>
                                            <th>File LHP</th>
                                            <th>Uraian Temuan</th>
                                            <th>Uraian Penyebab</th>
                                            <th>Uraian Rekomendasi</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
        <div class="modal fade" id="modalrekom" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
                        <form id="form-rekom" enctype="multipart/form-data">
							@csrf
							<div id="tampil-rekom"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hide()">Tutup</button>
						<button id="btn-rekom" class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>

            <div class="modal fade" id="modalshow" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                                <div id="tampil-pdf"></div>
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

    function back(){
        window.location.href = "{{ url('pelaporan/review') }}";
    }

    function hide(){
        $('#modalAdd').modal('hide');
    }

    function tambah(id,id_rekom){
			$('#btn-save').removeAttr('disabled','false');
			$.ajax({
				type: 'GET',
				url: "{{url('pelaporan/review/modal')}}",
				data: "id="+id+"&id_rekom="+id_rekom,
				success: function(msg){
					$('#tampil-form').html(msg);
					$('#modalAdd').modal('show');
				}
			});
	}
    function modalrekom(id_rekom){
			$('#btn-save').removeAttr('disabled','false');
			$.ajax({
				type: 'GET',
				url: "{{url('pelaporan/review/modal-rekomendasi')}}",
				data: "id_rekom="+id_rekom,
				success: function(msg){
					$('#tampil-rekom').html(msg);
					$('#modalrekom').modal('show');
				}
			});
	}

    $('#btn-save').on('click', () => {
    var form=document.getElementById('form-data');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/review/store')}}",
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
                            $('#modalAdd').modal('hide');
                            location.reload();
                            // window.location.href = "{{url('pelaporan/review')}}";
                        }
                    })
                }
            }
        });
    });

    $('#btn-rekom').on('click', () => {
    var form=document.getElementById('form-rekom');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/review/store-rekom')}}",
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
                            $('#modalAdd').modal('hide');
                            location.reload();
                            // window.location.href = "{{url('pelaporan/review')}}";
                        }
                    })
                }
            }
        });
    });

    function selesai(id){
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang sudah disetujui tidak dapat diubah kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('pelaporan/review/selesai')}}",
                    data: "id="+id,
                    success: function(msg){
                        if (msg.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: msg.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{url('pelaporan/review')}}";
                                }
                            })
                        }
                    }
                });
            }
        })
    }

</script>
<script type="text/javascript">
    var tes = {!! json_encode($get) !!};

    var model = tes;
    var shiftDataTable;


    console.log(model)

   $(document).ready(function () {

           DisplayShiftTableData(model);

       });

   function DisplayShiftTableData(model) {
        shiftDataTable = $('#shiftTable').dataTable({
           paging: false,
           "aaSorting": [[5, 'asc']],
           "aaData": model,
           rowsGroup: [4],
           "aoColumns": [
           {
               "data": function (data) {
                       return data[0];
                   },
               sDefaultContent: ""
           },
           {
               "data": function (data) {
                       return data.file_lhp;
                   },
               sDefaultContent: ""
           },
           {
               "data": function (data) {
                       return data.uraian_temuan;
                   },
               sDefaultContent: ""
           },
           {
               "data": function (data) {
                       return data.uraian_penyebab;
                   },
               sDefaultContent: ""
           },
           {
               "data": function (data) {
                       return data.uraian_rekomendasi+'<span class="btn btn-ghost-success waves-effect waves-light" onclick="modalrekom('+data.id_rekom+')"><i class="mdi mdi-plus-circle-outline"></i></span>';
                   },
               sDefaultContent: ""
           },
           {
               "data": function (data) {
                       return '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modalLhp('+data.id_rekom+')">Edit</span>';
                   },
               sDefaultContent: ""
           },

           ]
       });
   }
</script>
{{-- <script>
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
                rowsGroup: [2,3],
                ajax:"{{ url('pelaporan/review/get-table?id_program_kerja= '.$data->id.'')}}",
                columns: [
                    {data: 'id_rekom' },
                    { data: 'file_lhp' },
                    { data: 'uraian_temuan' },
                    { data: 'uraian_penyebab' },
                    { data: 'uraian_rekomendasi' },
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
</script> --}}

@endpush
