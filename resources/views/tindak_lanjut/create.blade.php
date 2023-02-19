@extends('layouts.app')

@section('content')
<div class="page-content">
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">

        <div class="row pb-3">
            <div class="col-sm-12 col-md-6">
                <span onclick="back()" class="btn btn-sm btn-danger waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Kembali</span>
                @if ($data->status_tindak_lanjut ==null || $data->status_tindak_lanjut ==0)
                    @if (Auth::user()['role_id'] > 15 )
                        <span onclick="selesai({{$data->id}})" class="btn btn-sm btn-success waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Kirim</span>
                    @endif
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table id="data-table-fixed-header" class="display table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width: 100%;" >
                                    <thead>
                                        <tr>
                                            <th width="1%" scope="col">No</th>
                                            <th></th>
                                            <th>File LHP</th>
                                            <th>Kondisi</th>
                                            <th>Kriteria</th>
                                            <th>Penyebab</th>
                                            <th>Akibat</th>
                                            {{-- <th class="dtr-details">Rekomendasi</th> --}}
                                            {{-- @if ($data->status_tindak_lanjut == null)
                                                @if (Auth::user()['role_id'] > 15 )
                                                    <th>Jawaban</th>
                                                @endif
                                            @endif --}}
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
						<button id="btn-tindak-lanjut" class="btn btn-success">Simpan</button>
						{{-- <button id="btn-tindak-lanjut" class="btn btn-primary">Update</button> --}}
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
<script>$('#uraian_rekomendasi').css('pointer-events','none');</script>
<script>
    // function child()
    function format(d) {
    // `d` is the original data object for the row
        return (
            '<table style="overflow: scroll;" class="display table table-bordered table-responsive dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed">' +
                '<tr>' +
                    'Detail Rekomendasi :' +
                '</tr>' +
                '<tr>' +
                    '<td><span class="btn btn-sm btn-ghost-primary waves-effect waves-light" onclick="modalrekom('+d.id_rekom+')">Tambah</span></td>' +
                '</tr>' +
                '<tr>' +
                    '<th>Uraian Rekomendasi' +
                    '<th>Uraian Jawaban' +
                '</tr>' +
                '<tr>' +
                    '<td>'+d.uraian_rekomendasi+'</td>' +
                    '<td>'+d.jawaban+'</td>' +                    
                '</tr>' +
                // d.rekom+
                '<tr>' +
                    '<td>'+d.parent_rekom+'</td>' +
                    // '<td>'+d.jawaban+'</td>' +                    
                '</tr>' +
            '</table>'
        );
    }

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
                    ajax:"{{ url('pelaporan/tindak-lanjut/get-create?id=1')}}",
                    columns: [
                        { data: 'id', render: function (data, type, row, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                { data: 'file_lhp' },
                { data: 'kondisi' },
                { data: 'kriteria' },
                { data: 'penyebab' },
                { data: 'akibat' },
                // { data: 'rekomedasi' },
                //    { data: 'action' },
                    ],
                    language: {
                        paginate: {
                            previous: '<< previous',
                            next: 'Next>>'
                        }
                    }
            });
            $('#data-table-fixed-header tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
        
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
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
    function buka_file(file){
        $('#modalshow').modal('show');
        var files=file.split(".");
        var surat =files[3];
        if(surat=='pdf'){
            $('#tampil-pdf').html('<embed src="{{ url('public/file_lhp') }}/'+file+'" width="100%" height="500px">');
        }else{
            $('#tampil-pdf').html('<embed src="{{ url('public/file_lhp') }}/'+file+'" width="100%" height="500px">');
        }
    }

    function back(){
        window.location.href = "{{ url('pelaporan/tindak-lanjut') }}";
    }

    function hide(){
        $('#modalAdd').modal('hide');
    }
    $('input[type="checkbox"]').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', false);
    });
    

    function modalrekom(id_rekom){
			$.ajax({
				type: 'GET',
				url: "{{url('pelaporan/tindak-lanjut/modal-rekomendasi')}}",
				data: "id_rekom="+id_rekom,
				success: function(msg){
					$('#tampil-rekom').html(msg);
					$('#modalrekom').modal('show');
				}
			});
	}

    // $('input[type="checkbox"]').hide()
    
    function editrekom(id_tindak_lanjut){ 
        // var checkedValue = document.querySelector('#parent_rekom:checked').value;     
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/modal-edit-rekomendasi')}}",
            data: "id_tindak_lanjut="+id_tindak_lanjut ,
            success: function(msg){
                $('#tampil-rekom').html(msg);
                $('#modalrekom').modal('show');
            }
        }); 
	}

    function hapusrekom(){
        var checkedValue = document.querySelector('#parent_rekom:checked').value;  
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/hapus-rekomendasi')}}",
            data: "id_tindak_lanjut="+checkedValue,
            success: function(msg){
                location.reload();
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
                            $('#modalAdd').modal('hide');
                            location.reload();
                        }
                    })
                }
            }
        });
    });

    $('#btn-tindak-lanjut').on('click', () => {
    var form=document.getElementById('form-rekom');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/tindak-lanjut/simpan-tindak-lanjut')}}",
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
                        }
                    })
                }
            }
        });
    });

    $('#edit-rekom').on('click', () => {
    var form=document.getElementById('form-rekom');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/tindak-lanjut/edit-rekom')}}",
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
                    url: "{{url('pelaporan/tindak-lanjut/selesai')}}",
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
                                    window.location.href = "{{url('pelaporan/tindak-lanjut')}}";
                                }
                            })
                        }
                    }
                });
            }
        })
    }


</script>
@endpush
