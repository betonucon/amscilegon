@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="row pb-3">
                    <div class="col-sm-12 col-md-6">
                        <span onclick="history.back()" class="btn btn-sm btn-info">Kembali</span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" scope="col">No</th>
                                    <th>Kondisi</th>
                                    <th>Kriteria</th>
                                    <th>Penyebab</th>
                                    <th>Akibat</th>
                                    <th>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $e=>$el)
                                    <tr>
                                        <td>{{$e+1}}</td>
                                        <td>{{$el->kondisi}}</td>
                                        <td>{{$el->kriteria}}</td>
                                        <td>{{$el->penyebab}}</td>
                                        <td>{{$el->akibat}}</td>
                                        <td width="1%">
                                            <center>
                                                <span onclick="lihat({{$el->id}})" class="btn btn-sm btn-primary">Lihat</span>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('ajax')

<script>
    function lihat(id){
        location.assign("{{url('pelaporan/review/view-rekomendasi?id=')}}" + id);
    }
</script>

@endpush
