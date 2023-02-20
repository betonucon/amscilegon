@extends('layouts.app')

@section('content')

<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">{{ $menu }}</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item">
								<a href="javascript: void(0);">{{ $headermenu }}</a>
							</li>
							<li class="breadcrumb-item active">{{ $menu }}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-lg-12">
                <div class="row pb-3">
                    <div class="col-sm-12 col-md-6">
                    </div>
                    <div class="col-sm-12 col-md-6">

                    </div>
                </div>
				<div class="card">
					<div class="card-body small">
						<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
							<div class="row">
								<div class="col-sm-12">
									<table id="data-table-fixed-header" class="table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                        <thead>
                                            <tr>
                                                <th width="1%" scope="col">No</th>
                                                <th >Area Pengawasan</th>
                                                <th >Jenis Pengawasan</th>
                                                <th >OPD</th>
                                                <th >PKP</th>
                                                <th >Nota Dinas</th>
                                                <th >Surat Perintah</th>
                                                <th >LHP</th>
                                                <th >Pesan</th>
                                                <th >Status</th>
                                                <th width="5%" >Action</th>
                                            </tr>
                                        </thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

         <!-- Modal Upload File -->
        <div class="modal fade" id="modal-upload" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<form id="form-upload" enctype="multipart/form-data">
							@csrf
							<div id="tampil-upload"></div>
						</form>
					</div>
                    <div class="modal-footer">
						<button id="btn-upload"  class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>

        <!-- Modal Show File -->
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

        <div class="modal fade" id="modalAdd" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-data" enctype="multipart/form-data">
							@csrf
							<div id="tampil-form"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button id="btn-save"  class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="modal-refused" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-refused" enctype="multipart/form-data">
							@csrf
							<div id="tampil-refused"></div>
						</form>
					</div>
                    <div class="modal-footer">
						<button id="btn-refused"  class="btn btn-success">Simpan</button>
					</div>
				</div>
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
                ajax:"{{ url('pelaporan/review/get-data')}}",
                columns: [
                     { data: 'id', render: function (data, type, row, meta)
                   {
                       return meta.row + meta.settings._iDisplayStart + 1;
                   }
               },
               { data: 'id_pkpt' },
               { data: 'jenis' },
               { data: 'opd' },
               { data: 'pkp' },
               { data: 'nota_dinas' },
               { data: 'file_sp' },
               { data: 'file_lhp' },
               { data: 'pesan_lhp' },
               { data: 'disposisi' },
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
        function view(id){
            location.assign("{{url('pelaporan/review/view?id=')}}" + id);
        }

        function proses(id){
            location.assign("{{url('pelaporan/review/create?id=')}}" + id);
        }

        function upload(id){
            $('#btn-upload').removeAttr('disabled','false');
            $.ajax({
                type: 'GET',
                url: "{{url('pelaporan/review/modal-upload')}}",
                data: "id="+id,
                success: function(msg){
                    $('#tampil-upload').html(msg);
                    $('#modal-upload').modal('show');
                }
            });
        }

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


        $('#btn-upload').click(function(){
            $('#btn-upload').attr('disabled','true');
            var form=document.getElementById('form-upload');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/review/upload')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
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
                            $('#btn-upload').removeAttr('disabled','false');
                            $('#btn-upload').html('Simpan');
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
                                location.reload()
                            }
                        })
                    }
                }
            });
        });

    function terima(id){
        $('#btn-save').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-approved')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-form').html(msg);
                $('#modalAdd').modal('show');
            }
        });
    }

    function tolak(id){
        $('#btn-refused').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-refused')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-refused').html(msg);
                $('#modal-refused').modal('show');
            }
        });
    }

    $('#btn-save').on('click', () => {
    var form=document.getElementById('form-data');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/review/approved')}}",
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
                            location.reload()
                        }
                    })
                }
            }
        });
    });

    $('#btn-refused').on('click', () => {
    var form=document.getElementById('form-refused');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/review/refused')}}",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                $('#btn-refused').attr('disabled', 'disabled');
                $('#btn-refused').html('Sending..');
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
                            $('#btn-refused').removeAttr('disabled','false');
                            $('#btn-refused').html('Simpan');
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
                            location.reload()
                        }
                    })
                }
            }
        });
    });



</script>

@endpush
