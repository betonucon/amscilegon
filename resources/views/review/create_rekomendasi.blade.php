@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="row pb-3">
                    <div class="col-sm-12 col-md-6">
                        <span onclick="history.back()" class="btn btn-sm btn-info">Kembali</span>
                        <span onclick="tambahRekomendasi({{$data->id}})" class="btn btn-sm btn-primary">Tambah Rekomendasi</span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="data-table-fixed-header" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" scope="col">No</th>
                                    <th>Rekomendasi</th>
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

    <div class="modal fade" id="modal-tambah-rekomendasi-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-rekomendasi" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-tambah-rekomendasi"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-tambah-rekomendasi"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-rekomendasi-show" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-rekomendasi" enctype="multipart/form-data">
                        @csrf
                        <div id="tampil-edit-rekomendasi"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-edit-rekomendasi"  class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ajax')

<script>
    function tambahRekomendasi(id){
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-tambah-rekomendasi')}}",
            data:"id="+id,
            success: function(msg){
                $('#tampil-tambah-rekomendasi').html(msg);
                $('#modal-tambah-rekomendasi-show').modal('show');
            }
        });
    }

    function editRekomendasi(id){
        $.ajax({
            type: 'GET',
            url: "{{url('pelaporan/review/modal-edit-rekomendasi')}}",
            data:"id="+id,
            success: function(msg){
                $('#tampil-edit-rekomendasi').html(msg);
                $('#modal-edit-rekomendasi-show').modal('show');
            }
        });
    }

    $('#btn-tambah-rekomendasi').on('click', () => {
        var form=document.getElementById('form-tambah-rekomendasi');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/review/store-rekomendasi')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-tambah-rekomendasi').attr('disabled', 'disabled');
                    $('#btn-tambah-rekomendasi').html('Sending..');
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
                            $('#btn-tambah-rekomendasi').removeAttr('disabled','false');
                            $('#btn-tambah-rekomendasi').html('Simpan');
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

    $('#btn-edit-rekomendasi').on('click', () => {
        var form=document.getElementById('form-edit-rekomendasi');
            $.ajax({
                type: 'POST',
                url: "{{url('pelaporan/review/store-rekomendasi')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-edit-rekomendasi').attr('disabled', 'disabled');
                    $('#btn-edit-rekomendasi').html('Sending..');
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
                            $('#btn-edit-rekomendasi').removeAttr('disabled','false');
                            $('#btn-edit-rekomendasi').html('Simpan');
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
                    url: "{{url('pelaporan/review/destory-rekomendasi')}}",
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
                ajax:"{{ url('pelaporan/review/get-table-rekomendasi?id_lhp=')}}+{{$data->id}}",
                columns: [
                { data: 'id', render: function (data, type, row, meta)
                    {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'rekomendasi' },
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
