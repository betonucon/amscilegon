@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="row pb-3">
                    <div class="col-sm-12 col-md-6">
                        <span onclick="history.back()" class="btn btn-sm btn-info">Kembali</span>
                        <span onclick="tambahUraian({{$data->id}})" class="btn btn-sm btn-primary">Tambah Uraian</span>
                        <span onclick="kirim({{$data->id}})" class="btn btn-sm btn-success">Kirim</span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="data-table-fixed-header" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" scope="col">No</th>
                                    <th>Kondisi</th>
                                    <th>Kriteria</th>
                                    <th>Penyebab</th>
                                    <th>Akibat</th>
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

    <div class="modal fade" id="modal-tambah-uraian-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-uraian" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-tambah-uraian"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-tambah-uraian"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-uraian-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-uraian" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-edit-uraian"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-edit-uraian"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ajax')

<script>
    function kirim(id){
        Swal.fire({
            title: 'Peringatan',
            text: "Data yang sudah dikirim tidak bisa di edit atau hapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('pelaporan/review/kirim')}}",
                    data: "id=" + id,
                    success: function(msg){
                        if (msg.status == 'success') {
                            history.back()
                        } else {
                            Swal.fire(
                                'Failed!',
                                msg.message,
                                'error'
                            )
                        }
                    }
                });
            }
        });
    }
</script>

<script>
    function rekomendasi(id){
        location.assign("{{url('pelaporan/review/create-rekomendasi?id=')}}" + id);
    }

    function tambahUraian(id){
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-tambah-uraian')}}",
            data:"id="+id,
            success: function(msg){
                $('#tampil-tambah-uraian').html(msg);
                $('#modal-tambah-uraian-show').modal('show');
            }
        });
    }

    function editUraian(id){
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-edit-uraian')}}",
            data:"id="+id,
            success: function(msg){
                $('#tampil-edit-uraian').html(msg);
                $('#modal-edit-uraian-show').modal('show');
            }
        });
    }

    $('#btn-tambah-uraian').on('click', () => {
        var form=document.getElementById('form-tambah-uraian');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/review/store-uraian')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-tambah-uraian').attr('disabled', 'disabled');
                    $('#btn-tambah-uraian').html('Sending..');
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
                            $('#btn-tambah-uraian').removeAttr('disabled','false');
                            $('#btn-tambah-uraian').html('Simpan');
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

    $('#btn-edit-uraian').on('click', () => {
        var form=document.getElementById('form-edit-uraian');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/review/store-uraian')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-edit-uraian').attr('disabled', 'disabled');
                    $('#btn-edit-uraian').html('Sending..');
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
                            $('#btn-edit-uraian').removeAttr('disabled','false');
                            $('#btn-edit-uraian').html('Simpan');
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
                    url: "{{url('pelaporan/review/destory-uraian')}}",
                    data: "id=" + id,
                    success: function(msg){
                        location.reload();
                    }
                });
            }
        });
    }
</script>

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
                ajax:"{{ url('pelaporan/review/get-table?id_program_kerja=')}}+{{$data->id}}",
                columns: [
                { data: 'id', render: function (data, type, row, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'kondisi' },
                { data: 'kriteria' },
                { data: 'penyebab' },
                { data: 'akibat' },
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

@endpush
