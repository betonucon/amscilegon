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
                                                <th >Jenis Pengawasan</th>
                                                <th >Area Pengawasan</th>
                                                <th >OPD</th>
                                                <th >PKP</th>
                                                <th >Nota Dinas</th>
                                                <th >Surat Perintah</th>
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
						<div id="error-notif"></div>
						<form id="form-data" enctype="multipart/form-data">
							@csrf
							<div id="tampil-pdf"></div>
						</form>
					</div>
				</div>
			</div>
		</div>

         <!-- Modal Create -->
         <div class="modal fade" id="modalCreate" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-create" enctype="multipart/form-data">
							@csrf
							<div id="tampil-create"></div>
						</form>
					</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button id="btn-create" class="btn btn-secondary">Simpan</button>
                    </div>
				</div>
			</div>
		</div>

         <!-- Modal Approve -->
         <div class="modal fade" id="modalApprove" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-approve" enctype="multipart/form-data">
							@csrf
							<div id="tampil-approve"></div>
						</form>
                        <div class="modal-footer">
                            <span id="btn-approve"  class="btn btn-success">Simpan</span>
                        </div>
					</div>
				</div>
			</div>
		</div>

         <!-- Modal Refused -->
         <div class="modal fade" id="modalRefuse" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-refuse" enctype="multipart/form-data">
							@csrf
							<div id="tampil-refuse"></div>
						</form>
                        <div class="modal-footer">
                            <span id="btn-refuse"  class="btn btn-success">Simpan</span>
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
                ajax:"{{ url('pelaporan/tindak-lanjut/get-data')}}",
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
        function tambah(id){
            $.ajax({
                url:"{{ url('pelaporan/tindak-lanjut/modal')}}",
                type:"GET",
                data:{id:id},
                success:function(data){
                    $('#tampil-create').html(data);
                    $('#modalCreate').modal('show');
                }
            })
        }

        $('#btn-create').on('click', () => {
        var form=document.getElementById('form-create');
            $.ajax({
                type: 'POST',
                url:"{{ url('pelaporan/tindak-lanjut/store')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-create').attr('disabled', 'disabled');
                    $('#btn-create').html('Sending..');
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
                                $('#btn-create').removeAttr('disabled','false');
                                $('#btn-create').html('Simpan');
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

        function modal_approved(id){
            $('#btn-approve').removeAttr('disabled','false');
            $.ajax({
                type: 'GET',
                url: "{{url('pelaporan/tindak-lanjut/modal-approved')}}",
                data: "id="+id,
                success: function(msg){
                    $('#tampil-approve').html(msg);
                    $('#modalApprove').modal('show');
                }
            });
        }

        function modal_refused(id){
            $('#btn-refuse').removeAttr('disabled','false');
            $.ajax({
                type: 'GET',
                url: "{{url('pelaporan/tindak-lanjut/modal-refused')}}",
                data: "id="+id,
                success: function(msg){
                    $('#tampil-refuse').html(msg);
                    $('#modalRefuse').modal('show');
                }
            });
        }


        $('#btn-approve').click(function(){
            $('#btn-approve').attr('disabled','true');
            var data = $('#form-approve').serialize();
            $.ajax({
                type: 'GET',
                url: "{{url('pelaporan/tindak-lanjut/approved')}}",
                data: data,
                success: function(msg){
                    if(msg.status=='success'){
                        Swal.fire({ title: 'Success!', text: 'Data Berhasil Disimpan', icon: 'success', confirmButtonText: 'OK', allowOutsideClick: false, allowEscapeKey: false, allowEnterKey: false, stopKeydownPropagation: false, }).then((result) => {
                            if (result.value) {
                                location.reload();
                                $('#modalApprove').modal('hide');
                            }
                        });
                    }else{
                        $('#modalApprove').modal('hide');
                        $('#data-table-fixed-header').DataTable().ajax.reload();
                        swal("Success!", "Data Berhasil Disimpan", "success");
                    }
                }
            });
        });

        $('#btn-refuse').click(function(){
            $('#btn-refuse').attr('disabled','true');
            var data = $('#form-refuse').serialize();
            $.ajax({
                type: 'GET',
                url: "{{url('pelaporan/tindak-lanjut/refused')}}",
                data: data,
                success: function(msg){
                    if(msg.status=='success'){
                        Swal.fire({ title: 'Success!', text: 'Data Berhasil Disimpan', icon: 'success', confirmButtonText: 'OK', allowOutsideClick: false, allowEscapeKey: false, allowEnterKey: false, stopKeydownPropagation: false, }).then((result) => {
                            if (result.value) {
                                location.reload();
                                $('#modalRefuse').modal('hide');
                            }
                        });
                    }else{
                        $('#modalRefuse').modal('hide');
                        $('#data-table-fixed-header').DataTable().ajax.reload();
                        swal("Success!", "Data Berhasil Disimpan", "success");
                    }
                }
            });
        });


    </script>
@endpush
