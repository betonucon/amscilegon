@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <span onclick="history.back()" class="btn btn-sm btn-info mb-3">Kembali</span>
                <span onclick="history.back()" class="btn btn-sm btn-danger mb-3">Download</span>

                <div class="card">
                    <div class="card-body">
                        <table id="data-table-fixed-header" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" scope="col">No</th>
                                    <th>Rekomendasi</th>
                                    <th>Jawaban</th>
                                    <th>File</th>
                                    <th>Pesan</th>
                                    <th width="20%" scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
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
                        <div id="tampil-pdf"></div>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Jawaban -->
    <div class="modal fade" id="modal-jawaban" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error-notif"></div>
                    <form id="form-jawaban" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-jawaban"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-jawaban"  class="btn btn-success">Simpan</button>
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
                ajax:"{{ url('pelaporan/tindak-lanjut/get-rekomendasi?id_lhp=')}}+{{$data->id}}",
                columns: [
                { data: 'id', render: function (data, type, row, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'rekomendasi' },
                { data: 'jawaban' },
                { data: 'file_jawaban' },
                { data: 'pesan' },
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

    function jawaban(id){
        $('#btn-jawaban').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/modal-jawaban')}}",
            data: "id="+id,
            success: function(msg){
                $('#tampil-jawaban').html(msg);
                $('#modal-jawaban').modal('show');
            }
        });
    }

    $('#btn-jawaban').on('click', () => {
    var form=document.getElementById('form-jawaban');
        $.ajax({
            type: 'POST',
            url: "{{url('pelaporan/tindak-lanjut/store-jawaban')}}",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                $('#btn-jawaban').attr('disabled', 'disabled');
                $('#btn-jawaban').html('Sending..');
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
                            $('#btn-jawaban').removeAttr('disabled','false');
                            $('#btn-jawaban').html('Simpan');
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

    function kirim(id){
        Swal.fire({
            title: 'Peringatan',
            text: "Data yang sudah dikirim tidak bisa di edit",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('pelaporan/tindak-lanjut/kirim')}}",
                    data: "id=" + id,
                    success: function(msg){
                        location.reload()
                    }
                });
            }
        });
    }

    function terima(id){
        $('#btn-save').removeAttr('disabled','false');
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/tindak-lanjut/modal-approved')}}",
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
            url: "{{url('pelaporan/tindak-lanjut/modal-refused')}}",
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
            url: "{{url('pelaporan/tindak-lanjut/approved')}}",
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
            url: "{{url('pelaporan/tindak-lanjut/refused')}}",
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
