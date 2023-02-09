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
                                <table id="shiftTable" class="display table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                    <thead>
                                        <tr>
                                            <th width="1%" scope="col">No</th>
                                            <th>File LHP</th>
                                            <th>Uraian Temuan</th>
                                            <th>Uraian Penyebab</th>
                                            <th>Uraian Rekomendasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach ($get as $g)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $g->file_lhp }}</td>
                                                <td>{{ $g->uraian_temuan }}</td>
                                                <td>{{ $g->uraian_penyebab }}</td>
                                                <td>
                                                    <span class="btn btn-ghost-success waves-effect waves-light" onclick="modalrekom({{ $g->id_rekom }})"><i class="mdi mdi-plus-circle-outline"></i></span>
                                                    <table class="display table table-bordered table-responsive">
                                                        <tr>
                                                            <td>{{ $g->uraian_rekomendasi }}</td>
                                                        </tr>
                                                        @foreach (group($g->grouping,$g->id_rekom) as $u)
                                                        <tr>
                                                            <td>{{ $u->uraian_rekomendasi }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                    {{-- <ul>
                                                        @foreach (group($g->grouping,$g->id_rekom) as $u)
                                                            <li>{{ $u->uraian_rekomendasi }}</li>
                                                        @endforeach
                                                    </ul> --}}
                                                </td>
                                                <td><span class="btn btn-success waves-effect waves-light btn-sm" onclick="modalLhp({{ $g->id_rekom }})">Edit</span></td>
                                            </tr>                                           
                                        @endforeach
                                    </tbody>
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
{{-- <script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script> --}}
{{-- <script type="text/javascript">
    var tes = {!! json_encode($output) !!};

    var model = tes;
    var shiftDataTable;


    console.log(model)

   $(document).ready(function () {

           DisplayShiftTableData(model);

       });

   function DisplayShiftTableData(model) {
        shiftDataTable = $('#shiftTable').dataTable({
            'data': [
                ["Tiger Nixon","System Architect","Edinburgh","5421","2011/04/25","$320,800"],
                ["Tiger Nixon","Additional information","","","",""],
                ["Garrett Winters","Accountant","Tokyo","8422","2011/07/25","$170,750"],
                ["Garrett Winters","Additional information","","","",""],
                ["Ashton Cox","Junior Technical Author","San Francisco","1562","2009/01/12","$86,000"],
                ["Ashton Cox","Additional information","","","",""],
                ["Cedric Kelly","Senior Javascript Developer","Edinburgh","6224","2012/03/29","$433,060"],
                ["Cedric Kelly","Additional information","","","",""],
                ["Airi Satou","Accountant","Tokyo","5407","2008/11/28","$162,700"],
                ["Airi Satou","Additional information","","","",""]
            ],
            'columnDefs': [
                {
                    'targets': [1, 2, 3, 4, 5],
                    'orderable': false,
                    'searchable': false
                }
            ],
            'rowsGroup': [0],
            'createdRow': function(row, data, dataIndex){
                // Use empty value in the "Office" column
                // as an indication that grouping with COLSPAN is needed
                if(data[2] === ''){
                    // Add COLSPAN attribute
                    $('td:eq(1)', row).attr('colspan', 5);

                    // Hide required number of columns
                    // next to the cell with COLSPAN attribute
                    $('td:eq(2)', row).css('display', 'none');
                    $('td:eq(3)', row).css('display', 'none');
                    $('td:eq(4)', row).css('display', 'none');
                    $('td:eq(5)', row).css('display', 'none');
                }
            } 
       });
   }
</script> --}}

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
                },
                rowGroup: [3]
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
