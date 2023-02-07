@extends('layouts.app')
@push('style')
    <style>
         table.table-bordered.dataTable td {
            border-bottom-width: 1px;
            padding: 3px 10px;
        }
    </style>
@endpush
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

				<div class="card">
					<!-- <div class="card-header">
					</div> -->
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
                                                <th >PKP</th>
                                                <th >Nota Dinas</th>
                                                <th >Surat Perintah</th>
                                                <th >File KKP</th>
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


		<div class="modal fade" id="modalApprove" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
					</div>
					<div class="modal-body">
						<form id="approve-data" enctype="multipart/form-data">
							@csrf

							<div id="tampil-approve"></div>
						</form>
                        <div class="modal-footer">
                            <span  class="btn btn-white" onclick="hide()">Tutup</span>
                            <span id="btn-approve"  class="btn btn-success">Simpan</span>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modalrefused" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
					</div>
					<div class="modal-body">
						<form id="refused-data" enctype="multipart/form-data">
							@csrf

							<div id="tampil-refused"></div>
						</form>
                        <div class="modal-footer">
                            <span  class="btn btn-white" onclick="hide()">Tutup</span>
                            <span id="btn-refused"  class="btn btn-success">Simpan</span>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modaldetail" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" ></h5>
					</div>
					<div class="modal-body">
						<div id="tampil-detail"></div>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hide_detail()">Tutup</button>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="modalshow" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						{{-- <h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5> --}}
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
				</div>
			</div>
		</div>

        <div class="modal fade" id="tampiltable" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						{{-- <h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5> --}}
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
						<div id="error-notif"></div>
						<form id="form-refused" enctype="multipart/form-data">
							@csrf
							<div id="tampil-table"></div>
						</form>
					</div>
				</div>
			</div>
		</div>

         <!-- File KKP -->
         <div class="modal fade" id="tampilSp" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						{{-- <h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5> --}}
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
						<div id="error-notif"></div>
						<form id="form-sp" enctype="multipart/form-data">
							@csrf
							<div id="table-sp"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hidesp()">Tutup</button>
						<button id="btn-sp"  class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@push('ajax')
<script text="">
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
           ajax:"{{ url('pelaksanaan/kertas-kerja-pemeriksaan/get-data')}}",
           columns: [
               { data: 'id', render: function (data, type, row, meta)
                   {
                       return meta.row + meta.settings._iDisplayStart + 1;
                   }
               },
               { data: 'id_pkpt' },
               { data: 'jenis' },
               { data: 'pkp' },
               { data: 'nota_dinas' },
               { data: 'file_sp' },
               { data: 'file_kkp' },
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

     function tampil_kkp(id){
        $('#btn-sp').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('perencanaan/kertas-kerja-pemeriksaan/tampil-kkp')}}",
            data: "id="+id,
            success: function(msg){
                $('#table-sp').html(msg);
                $('#tampilSp').modal('show');
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

        function tambah(id){
			$('#btn-save').removeAttr('disabled','false');
			$.ajax({
				type: 'GET',
				url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/modal')}}",
				data: "id="+id,
				success: function(msg){
					$('#tampil-form').html(msg);
					$('#modalAdd').modal('show');
				}
			});
		}

        function hide(){
            $('#modalAdd').modal('hide');
        }
        function tampil(id){
            $('#btn-save').removeAttr('disabled','false');
            $.ajax({
                type: 'GET',
                url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/detail')}}",
                data: "id="+id,
                success: function(msg){
                    $('#tampil-table').html(msg);
                    $('#tampiltable').modal('show');
                }
            });
        }
        function hide_detail(){
            $('#modaldetail').modal('hide');
        }
        $('#btn-save').on('click', () => {
        var form=document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/store')}}",
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
                    if (msg == 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: msg.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{url('pelaksanaan/kertas-kerja-pemeriksaan')}}";
                            }
                        })
                    }
                }
            });
    });

    $('#btn-save').on('click', () => {
    var form=document.getElementById('form-data');
        $.ajax({
            type: 'POST',
            url: "{{url('perencanaan/program-kerja-pengawasan/approved')}}",
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


    $('#btn-approve').on('click', () => {
        var form=document.getElementById('approve-data');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/approved')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-approve').attr('disabled', 'disabled');
                    $('#btn-approve').html('Sending..');
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
                                $('#btn-approve').removeAttr('disabled','false');
                                $('#btn-approve').html('Simpan');
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
                                window.location.href = "{{url('pelaksanaan/kertas-kerja-pemeriksaan')}}";
                            }
                        })
                    }
                }
            });
    });
    $('#btn-refused').on('click', () => {
        var form=document.getElementById('refused-data');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/refused')}}",
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
                        })
                        location.reload();
                        // .then((result) => {
                        //     if (result.isConfirmed) {
                        //         window.location.href = "{{url('pelaksanaan/kertas-kerja-pemeriksaan')}}";
                        //     }
                        // })
                    }
                }
            });
    });

    function hapus(id){
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Delete This!'
			}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'GET',
                    url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/destroy')}}",
                    data: "id=" + id,
					success: function(msg){
                        if(msg.status=='success'){
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            location.reload();
                        }else{
                            Swal.fire(
                                'Failed!',
                                'Your file failed to delete.',
                                'error'
                            )
                        }
					}
				});
			}
			});
		}

    function modal_approved(id){
        $('#btn-save').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/modal-approve')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-approve').html(msg);
                $('#modalApprove').modal('show');
            }
        });
    }

    function modal_refused(id){
        $('#btn-refused').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/modal-refused')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-refused').html(msg);
                $('#modalrefused').modal('show');
            }
        });
    }

    function approved(id){
			// Swal.fire({
			// 	title: 'Are you sure?',
			// 	text: "Apakah anda yakin ingin menyetujui data ini?",
			// 	icon: 'warning',
			// 	showCancelButton: true,
			// 	confirmButtonColor: '#3085d6',
			// 	cancelButtonColor: '#d33',
			// 	confirmButtonText: 'OK'
			// }).then((result) => {
			// if (result.isConfirmed) {
				$.ajax({
					type: 'GET',
                    url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/approved')}}",
                    data: "id=" + id,
					success: function(msg){
                        if (msg.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: msg.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.assign("{{url('pelaksanaan/kertas-kerja-pemeriksaan')}}");
                                }
                            })
                        }
					}
				});
			}
		// 	});
		// }

    function refused(id){
			// Swal.fire({
			// 	title: 'Are you sure?',
			// 	text: "Apakah anda yakin ingin menolak data ini?",
			// 	icon: 'warning',
			// 	showCancelButton: true,
			// 	confirmButtonColor: '#3085d6',
			// 	cancelButtonColor: '#d33',
			// 	confirmButtonText: 'OK'
			// }).then((result) => {
			// if (result.isConfirmed) {
            var pesan = ("#pesan").val();
			$.ajax({
                type: 'GET',
                url: "{{url('pelaksanaan/kertas-kerja-pemeriksaan/refused')}}",
                data: "id="+id+"&pesan="+pesan,
                success: function(msg){
                    if (msg.status == 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: msg.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{url('/pelaksanaan/kertas-kerja-pemeriksaan')}}";
                            }
                        })
                    }
                }
            });
			}
		// 	});
		// }
</script>
@endpush
