<!DOCTYPE html>
<html>
<head>
	<title>Laporan Uraian</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<table class='table table-bordered'>
		<thead>
			<tr>
                <th>No</th>
				<th>Kondisi</th>
				<th>Kriteria</th>
				<th>Penyebab</th>
				<th>Akibat</th>
                <th>Rekomedendasi</th>
                <th>Jawaban</th>
                <th>Status</th>


			</tr>
		</thead>
		<tbody>
			@foreach($data as $e=>$el)
			<tr>
                @if($el->urut==1)
                <td>{{$el->id}}</td>
				<td>{{$el->kondisi}}</td>
				<td>{{$el->kriteria}}</td>
				<td>{{$el->penyebab}}</td>
				<td>{{$el->akibat}}</td>

				

                @else
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                

                @endif

				<td>{{$el->urut}} {{$el->rekomendasi}}</td>
				<td>{{$el->urut}} {{$el->jawaban}}</td>
				@if ($el->status==0|| $el->status==null) 
				<td>Belum di TL</td>	
			@elseif($el->status==1)
				<td>Belum Sesuai</td>	
			@elseif($el->status==2)
				<td>Belum Sesuai</td>
			@elseif($el->status==3)
				<td>Sesuai</td>
			@endif
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
