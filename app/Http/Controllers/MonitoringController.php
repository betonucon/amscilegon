<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class MonitoringController extends Controller
{
    public function index()
    {
        $headermenu = 'Pelaporan';
        $menu = 'Tindak Lanjut';
        return view('tindak_lanjut.index', compact('headermenu', 'menu'));
    }

    public function getdata(Request $request)
    {
        error_reporting(0);
        $data = ProgramKerja::where('status','>=', 6)->orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('area_pengawasan', function ($data) {
                return $data->pkpt['area_pengawasan'];
            })
            ->addColumn('jenis_pengawasan', function ($data) {
                return $data->pkpt['jenis_pengawasan'];
            })
            ->addColumn('opd', function ($data) {
                return $data->pkpt['opd'];
            })
            ->addColumn('action', function ($row) {
                if ($row['status']==6) {
                    $crud = '
                        <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row->pkpt['id'] . ')">Proses</span>';
                    return $crud;
                }else{
                    
                    return 'none';
                }
            })
            ->addColumn('status', function ($data) {
                if ($data['status']==7) {
                    $status='Pending';
                    return $status;
                }else{
                    $status='Menunggu Approval';
                    return $status;
                }
            })

            ->rawColumns(['status', 'action', 'pkp', 'nota_dinas', 'area_pengawasannya'])
            ->make(true);
            
    }
    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data=Pkpt::where('id', $request->id)->first();
        return view('tindak_lanjut.create', compact('headermenu', 'menu','data'));
    }

    public function modal(Request $request)
    {
        error_reporting(0);
        $status = M_Status_Lhp::all();
        $pkpt = Pkpt::where('id', $request->id)->first();
        $sp= ProgramKerja::where('id_pkpt', $request->id_pkpt)->first();
        $lhp=Lhp::where('id', $request->id)->first();

        return view('tindak_lanjut.modal', compact('status', 'pkpt','lhp','sp'));
    }
    public function store(Request $request)
    {
        error_reporting(0);

        $request->validate([
            'id_pkpt' => 'required',
            'uraian_temuan' => 'required',
            'uraian_penyebab' => 'required',
            'uraian_rekomendasi' => 'required',
        ]);
        if($request->id>0){
            Lhp::where('id', $request->id)->update([
                'no_sp' => $request->no_sp,
                'id_pkpt' => $request->id_pkpt,
                'uraian_temuan' => $request->uraian_temuan,
                'uraian_penyebab' => $request->uraian_penyebab,
                'uraian_rekomendasi' => $request->uraian_rekomendasi,
                'uraian_tindak_lanjut' => $request->uraian_tindak_lanjut,
                'nilai_rekomendasi' => $request->nilai_rekomendasi,
                'nilai_tindak_lanjut' => $request->nilai_tindak_lanjut,
                'status_nilai' => $request->status_nilai,
            ]);
        }else{
            Lhp::create([
                'no_sp' => $request->no_sp,
                'id_pkpt' => $request->id_pkpt,
                'uraian_temuan' => $request->uraian_temuan,
                'uraian_penyebab' => $request->uraian_penyebab,
                'uraian_rekomendasi' => $request->uraian_rekomendasi,
                'status' => 1,
    
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);

    }

    public function getTable(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_pkpt', $request->id_pkpt)->get();

        return Datatables::of($data)
            ->addColumn('uraian_temuan', function ($data) {
                return $data['uraian_temuan'];
            })
            ->addColumn('uraian_penyebab', function ($data) {
                return $data['uraian_penyebab'];
            })
            ->addColumn('uraian_rekomendasi', function ($data) {
                return $data['uraian_rekomendasi'];
            })
            ->addColumn('uraian_tindak_lanjut', function ($data) {
                return $data['uraian_tindak_lanjut'];
            })
            ->addColumn('nilai_rekomendasi', function ($data) {
                return $data['nilai_rekomendasi'];
            })
            ->addColumn('nilai_tindak_lanjut', function ($data) {
                return $data['nilai_tindak_lanjut'];
            })
            ->addColumn('status_nilai', function ($data) {
                return $data['status_nilai'];
            })
            ->addColumn('action', function ($row) {
                $crud = '
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="edit(' . $row['id'] . ')">Tindak Lanjut</span>';
                return $crud;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
