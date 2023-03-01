@extends('layouts.app')

@section('content')

<div class="page-content">
	<div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-2">
               <select class="form-control tahunxx" name="tahun" id="select2">
                @for($i=date('Y',strtotime('-1 year'));$i<=date('Y'); $i++)
                    <option @if ($i==date('Y')) selected @endif value="{{ $i }}">{{ $i }}</option>
                @endfor
               </select>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                    <select class="form-control opdxx" id="select3" name="opd">
                        <option >-- PILIH OPD --</option>
                        @foreach ($pkpt as $item)
                        <option value="{{$item->opd}}">{{$item->opd}}<option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-md-3">
                <span onclick="filter()" class="btn btn-sm btn-primary">Filter</span>
                <span onclick="refresh()" class="btn btn-sm btn-warning">Refresh</span>
            </div>
                </div>
            </div>
        </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title mb-0">Data Tindak Lanjut Rekomendasi</h4>
          </div>
          <div class="card-body">
                  <div id="realtime">
                      <canvas id="myChart" width="300" height="300"></canvas>
                  </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title mb-0">Data Realisasi PKPT</h4>
          </div>
          <div class="card-body">
              <div id="bar_chart" class="apex-charts" >
                  <canvas id="donat" width="300" height="300"></canvas>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('ajax')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  const d = new Date();
  let year = d.getFullYear();
  $(document).ready(function() {
    $('#select2').select2();
    $('#select3').select2();
  });

    new Chart("myChart", {
          type: "bar",
          data: {
            labels:["Jumlah Rekomendasi", "Sesuai", "Belum Sesuai", "Belum ditindak lanjuti"],
            datasets: [{
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
              data: [
                {{$all}},
                {{$calc}},
                {{$calc2}},
                {{$calc3}},
              ],
              barPercentage: 0.5,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
          },
          options: {
            legend: {display: false},
            title: {
              display: true,
            //   text: 'Tahun '+year
            }
          }
    });

    new Chart("donat", {
          type: 'pie',
          data: {
            labels: [
                'PKPT',
                'Surat Perintah',
                'LHP',
            ],
            datasets: [{
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'

            ],
              data: [
                {{$pkpt2}},
                {{$programkerja}},
                {{$kertaskerja}},
            ],
            }]
          },
          options: {
            legend: {display: false},
            title: {
              display: true,
            //   text: 'Tahun 2023'
            }
          }
    });


  function filter(){
    var opd = $('.opdxx').val();
    var tahun = $('.tahunxx').val();
    location.assign("{{url('Dashboard')}}?opd="+opd+"&tahun="+tahun);
  }


  function refresh(){
    location.assign("{{url('Dashboard')}}");
  }


    </script>
@endpush

