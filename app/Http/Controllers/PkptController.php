<?php

namespace App\Http\Controllers;

use App\Models\Pkpt;
use App\Models\HeaderPkpt;
use ConvertApi\ConvertApi;
use App\Imports\PkptImport;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PkptController extends Controller
{
    public function index()
    {
        $headermenu = 'Perencanaan';
        $menu = 'Penyusunan PKPT';
        $nopkpt=HeaderPkpt::all();
        return view('pkpt.index', compact('headermenu', 'menu','nopkpt'));
    }

    public function getdata(Request $request)
    {
        error_reporting(0);
        $data = Pkpt::where('jenis', detail_pkpt())->orderBy('id', 'desc')->get();
        
        return Datatables::of($data)
            ->addColumn('id', function ($data) {
                return  $data['id'];
            })
            // ->addColumn('jenis', function ($data) {
            //     return $data['jenis'];
            // })
            ->addColumn('area_pengawasan', function ($data) {
                return $data['area_pengawasan'];
            })
            ->addColumn('jenis_pengawasan', function ($data) {
                return $data['jenis_pengawasan'];
            })
            ->addColumn('opd', function ($data) {
                return $data['opd'];
            })
            ->addColumn('rmp', function ($data) {
                return $data['rmp'];
            })
            ->addColumn('rpl', function ($data) {
                return $data['rpl'];
            })
            ->addColumn('sarana_prasarana', function ($data) {
                return $data['sarana_prasarana'];
            })
            ->addColumn('tingkat_resiko', function ($data) {
                return $data['tingkat_resiko'];
            })
            ->addColumn('keterangan', function ($data) {
                return $data['keterangan'];
            })
            ->addColumn('tujuan', function ($data) {
                return $data['tujuan'];
            })
            ->addColumn('koorwas', function ($data) {
                return $data['koorwas'];
            })
            ->addColumn('pt', function ($data) {
                return $data['pt'];
            })
            ->addColumn('kt', function ($data) {
                return $data['kt'];
            })
            ->addColumn('at', function ($data) {
                return $data['at'];
            })
            ->addColumn('jumlah', function ($data) {
                return $data['jumlah'];
            })
            ->addColumn('jumlah_laporan', function ($data) {
                return $data['jumlah_laporan'] . ' ' . $data['kategori'];
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function modal(Request $request)
    {
        error_reporting(0);

        $data = HeaderPkpt::all();

        return view('pkpt.modal', compact('data'));
    }

    public function download(Request $request)
    {
        $data=HeaderPkpt::where('nomor_pkpt',$request->nomor_pkpt)->first();
        return $data->file;
    }

    public function import(Request $request)
    {

        if ($request->id > 0) {
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx',
                'nomor_pkpt' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx',
            ]);
        }



        $filess = $request->file('file');
        $tahun = date('Y');
        $nama_file = rand() . $filess->getClientOriginalName();
        $filess->move('public/file_excel', $nama_file);
        
        $cek = HeaderPkpt::where('getClientOriginalName',$filess->getClientOriginalName())->count();
        if ($cek>0) {
            $mst = HeaderPkpt::where('getClientOriginalName',$filess->getClientOriginalName())->first();
            $data = HeaderPkpt::where('getClientOriginalName',$filess->getClientOriginalName())->update([
                'file' => $nama_file,
                'getClientOriginalName' => $filess->getClientOriginalName(),
            ]);
            $jenis = $mst->nomor_pkpt;
            $hapus = Pkpt::where('jenis', $jenis)->delete();
            Excel::import(new PkptImport($tahun, $jenis), public_path('/file_excel/' . $nama_file));

            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Diimport',
            ]);
        } else {

            $jenis = nomor_pkpt();
            $data = HeaderPkpt::create([
                'nomor_pkpt' => $jenis,
                'file' => $nama_file,
                'getClientOriginalName' => $filess->getClientOriginalName(),
            ]);

            Excel::import(new PkptImport($tahun, $jenis), public_path('/file_excel/' . $nama_file));

            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Diimport',
            ]);
        }

        
    }

    public function destroy(Request $request)
    {
        $data = Pkpt::where('id', $request->id)->first();
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Dihapus'
        ]);
    }
}
