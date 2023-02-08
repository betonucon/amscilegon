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
                        @if (Auth::user()->role_id == 3)
                        <span onclick="tambah(0)" class="btn btn-sm btn-success waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Upload Excel</span>
                        @endif
                        <span onclick="download()" class="btn btn-sm btn-primary waves-effect waves-light "><i class="mdi mdi-download"></i> Download Excel</span>
                        @if (Auth::user()->role_id == 3 ||  Auth::user()->role_id >= 8 && Auth::user()->role_id <= 11)
                        <span onclick="tambahNonPkpt()" class="btn btn-sm btn-warning waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Non PKPT</span>
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-6">

                    </div>
                </div>
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
                                                {{-- <th >Jenis</th> --}}
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
				</div>
			</div>
		</div>
		<div class="modal fade" id="modalAdd" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
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
						<button  class="btn btn-white" onclick="hide()">Tutup</button>
						<button id="btn-save"  class="btn btn-success">Simpan</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="download" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabelDefault">{{ $menu }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<div id="error-notif"></div>
						<form id="form-data" enctype="multipart/form-data">
							@csrf
                            <div class="mb-3">
                                <label class="form-label">Nomor Pkpt</label>
                                <select name="nomor_pkpt" id="nomor_pkpt" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach ($nopkpt as $i)
                                        <option value="{{ $i->nomor_pkpt }}">{{ $i->nomor_pkpt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-white" onclick="hide()">Tutup</button>
						<span onclick="downloadexcell()"  class="btn btn-success">Simpan</span>
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
                ajax:"{{ url('perencanaan/pkpt/get-data')}}",
                columns: [
                    { data: 'id' },
                    // { data: 'jenis' },
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
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
			TableManageFixedHeader.init();

		});

		function tambah(id){
			$('#btn-save').removeAttr('disabled','false');
			$.ajax({
				type: 'GET',
				url: "{{url('perencanaan/pkpt/modal')}}",
				data: "id="+id,
				success: function(msg){
					$('#tampil-form').html(msg);
					$('#modalAdd').modal('show');

				}
			});
		}

		function download(){
			// $('#btn-save').removeAttr('disabled','false');
			$.ajax({
				type: 'GET',
				// url: "{{url('perencanaan/pkpt/modaldownload')}}",
				// data: "id="+id,
				success: function(msg){
                    // window.open("{{ url('public/file_excell/936258045pkpt.xlsx') }}", '_blank');
					// $('#tampil-form').html(msg);
					$('#download').modal('show');

				}
			});
		}

		function downloadexcell(){
			var nomor_pkpt=$('#nomor_pkpt').val();
			$.ajax({
				type: 'GET',
				url: "{{url('perencanaan/pkpt/download')}}",
				data: "nomor_pkpt="+nomor_pkpt,
				success: function(msg){
                    const data = msg;
                    console.log(data)
                    var url="{{ url('public/file_excel') }}"+'/'+data
                    window.location = url;
				}
			});
		}

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
                    url: "{{url('perencanaan/pkpt/destroy')}}",
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

        $('#btn-save').on('click', () => {
        var form=document.getElementById('form-data');
            $.ajax({
                type: 'POST',
                url: "{{url('perencanaan/pkpt/import')}}",
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
                                window.location.href = "{{url('perencanaan/pkpt')}}";
                            }
                        })
                    }
                }
            });
        });

        function tambahNonPkpt(){
            location.assign("{{url('perencanaan/non-pkpt/create')}}");
		}

        function edit(id){
            location.assign("{{url('perencanaan/non-pkpt/edit?id=')}}" + id);
		}

        function hide(){
            $('#modalAdd').modal('hide');
        }

	</script>
@endpush
