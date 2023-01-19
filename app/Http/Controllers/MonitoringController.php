<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data = ProgramKerja::where('file_sp', '!=', null)->orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('id_pkpt', function ($data) {
                $pkpt = Pkpt::where('id', $data->id_pkpt)->first();
                return $pkpt->area_pengawasan;
            })
            ->addColumn('jenis', function ($data) {
                $pkpt = Pkpt::where('id', $data->id_pkpt)->first();
                return $pkpt['jenis_pengawasan'];
            })
            ->addColumn('opd', function ($data) {
                $pkpt = Pkpt::where('id', $data->id_pkpt)->first();
                return $pkpt['opd'];
            })
            ->addColumn('pkp', function ($data) {
                $pkp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['pkp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $pkp;
            })
            ->addColumn('nota_dinas', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['nota_dinas'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('file_sp', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_sp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()->role_id;
                $status = $row['status'];
                $sts = Status::where('id', $row->status)->first();

                $btn = '
                            <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Proses</span>
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                        ';
                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }
}
