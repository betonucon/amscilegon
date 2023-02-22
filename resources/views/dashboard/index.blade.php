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
            <h4 class="card-title mb-0">PKPT, Surat Perintah dan LHP</h4>
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

  $.getJSON("{{ url('/dashboard-json') }}", function(result){
        console.log(result.xValues)
        new Chart("myChart", {
          type: "bar",
          data: {
            labels: result.xValues,
            datasets: [{
              backgroundColor: result.barColors,
              data: result.yValues,
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
              text: 'Tahun '+year
            }
          }
        });
        new Chart("donat", {
          type: 'pie',
          data: {
            labels: result.labels,
            datasets: [{
              backgroundColor: result.donutColors,
              data: result.donut

            }]
          },
          options: {
            legend: {display: false},
            title: {
              display: true,
              text: 'Tahun '+year
            }
          }
        });

      });

  function filter(){
    var opd = $('.opdxx').val();
    var tahun = $('.tahunxx').val();
    $.getJSON("{{ url('/dashboard-json?opd=') }}"+opd+ "&tahun="+tahun , function(result){
        console.log(result.xValues)
        location.reload();
        new Chart("myChart", {
          type: "bar",
          data: {
            labels: result.xValues,
            datasets: [{
              backgroundColor: result.barColors,
              data: result.yValues,
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
              text: 'Tahun '+tahun
            }
          }
        });
        new Chart("donat", {
          type: 'pie',
          data: {
            labels: result.labels,
            datasets: [{
              backgroundColor: result.donutColors,
              data: result.donut

            }]
          },
          options: {
            legend: {display: false},
            title: {
              display: true,
              text: 'Tahun '+tahun
            }
          }
        });

      });
  }


    </script>
@endpush

