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
                    @if (Auth::user()['role_id'] >= 17 && Auth::user()['role_id'] <= 20 )
                        <span onclick="selesai({{$data->id}})" class="btn btn-sm btn-success waves-effect waves-light "><i class="mdi mdi-plus-circle-outline"></i> Selesai</span>
                    @endif
                @endif
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
                                            <th>Kondisi</th>
                                            <th>Kriteria</th>
                                            <th>Penyebab</th>
                                            <th>Akibat</th>
                                            <th>Rekomendasi</th>
                                            <th>Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach ($get as $g)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td><span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`{{ $g->file_lhp }}`)"><center><img src="{{ asset('public/img/pdf-file.png') }}" width="10px" height="10px"></center></span></td>
                                                <td>{{ $g->kondisi }}</td>
                                                <td>{{ $g->kriteria }}</td>
                                                <td>{{ $g->penyebab }}</td>
                                                <td>{{ $g->akibat }}</td>
                                                <td>
                                                    <table class="display table  table-responsive">
                                                        <tr>
                                                            <td colspan="2">
                                                                <p>{{ $g->uraian_rekomendasi }}</p>
                                                                <ul>
                                                                    @foreach (childrekomedasi($g->grouping,$g->id_rekom) as $a)
                                                                        <li>{{ $a->uraian_jawaban }} <input type="checkbox"  id="parent_rekom" value="{{ $a->id_rekom }}"></li>
                                                                    @endforeach
                                                                </ul>  
                                                            </td>
                                                        </tr>
                                                        @foreach (group($g->grouping,$g->id_rekom) as $u)
                                                        <tr>
                                                            <td>
                                                               <p>{{ $u->uraian_rekomendasi }}</p>                                                                   
                                                                <ul>
                                                                    @foreach (childrekomedasi($u->grouping,$u->id_rekom) as $b)
                                                                        <li>{{ $b->uraian_jawaban }} <input type="checkbox"  id="parent_rekom" value="{{ $b->id_rekom }}"> </li> 
                                                                    @endforeach
                                                                </ul> 
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </td>

                                                {{-- <td>
                                                    <table class="display table  table-responsive">
                                                        <tr>
                                                            <td colspan="2">{{ $g->uraian_jawaban }}</td>
                                                        </tr>
                                                        @foreach (group($g->grouping,$g->id_rekom) as $u)
                                                        <tr>
                                                            <td>
                                                                {{ $u->uraian_jawaban }}
                                                            </td>--}}
                                                            @if (Auth::user()['role_id'] >= 17 && Auth::user()['role_id'] <= 20) 
                                                                <td>
                                                                    <span class="btn btn-ghost-primary waves-effect waves-light" onclick="modalrekom({{ $g->id_rekom }},0)">Tambah</span>
                                                                    <span class="btn btn-ghost-success waves-effect waves-light" onclick="editrekom({{ $g->id_rekom }})">Edit</span>
                                                                    <span class="btn btn-ghost-danger waves-effect waves-light" onclick="hapusrekom({{ $g->id_rekom }})">hapus</span>
                                                                </td>
                                                            @endif
                                                        {{-- </tr>
                                                        @endforeach
                                                    </table>
                                                </td> --}}

                                                @if (Auth::user()['role_id'] >= 17 && Auth::user()['role_id'] <= 20)
                                                <td>
                                                    @if (checkgroup($g->grouping,$g->id_rekom)==0)
                                                        <span class="btn btn-success waves-effect waves-light btn-sm" onclick="tambah({{$data->id}},{{ $g->id_rekom }})">Edit</span>
                                                        <span class="btn btn-danger waves-effect waves-light btn-sm" onclick="hapusrekom({{ $g->id_rekom }})">Hapus</span>
                                                    @endif
                                                </td>
                                                @endif
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
						<button id="btn-tindak-lanjut" class="btn btn-success">Simpan</button>
						<button id="edit-tindak-lanjut" class="btn btn-primary">Update</button>
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
    

    function modalrekom(id_rekom,id){
            if (id==0) {
                $('#btn-tindak-lanjut').show();
                $('#edit-tindak-lanjut').hide();
            } else {
                $('#btn-tindak-lanjut').hide();
                $('#edit-tindak-lanjut').show();
            }
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

    $('input[type="checkbox"]').hide()
    function editrekom(id_rekom){
        $('input[type="checkbox"]').show()
        $('#btn-tindak-lanjut').hide();
        $('#edit-tindak-lanjut').show();
        var parent_rekom =$("#parent_rekom").val();
        $('input[type="checkbox"]').on('change', function(e){
            if(e.target.checked){
                $.ajax({
                    alert(parent_rekom)
                    type: 'GET',
                    url: "{{url('pelaporan/tindak-lanjut/modal-rekomendasi')}}",
                    data: "id_tindak_lanjut="+parent_rekom,
                    success: function(msg){
                        $('#tampil-rekom').html(msg);
                        $('#modalrekom').modal('show');
                    }
                }); 
            }
        });
	}

    function hapusrekom(id_rekom){
			$.ajax({
				type: 'GET',
				url: "{{url('pelaporan/tindak-lanjut/hapus-rekomendasi')}}",
				data: "id_rekom="+id_rekom,
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
