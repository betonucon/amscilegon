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
                                                {{-- <th >PKP</th>
                                                <th >Nota Dinas</th> --}}
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
        function viewUraian(id){
            location.assign("{{url('pelaporan/tindak-lanjut/view-uraian?id=')}}" + id);
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
    </script>
@endpush
