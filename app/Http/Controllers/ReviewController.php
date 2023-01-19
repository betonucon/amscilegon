<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\Role;
use App\Models\Lhpdoc;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use App\Models\Status;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $headermenu = 'Pelaporan';
        $menu = 'Laporan Hasil Pemeriksaan';
        return view('review.index', compact('headermenu', 'menu'));
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
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                        ';
                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function tampil_detail(Request $request)
    {
        error_reporting(0);
        $data = Pkpt::where('id', $request->id)->first();
        $id = $data->id;
        return view('kertaskerja.table', compact('data', 'id'));
    }

    public function getJenisPengawasan(Request $request)
    {
        $data = Pkpt::where('id', $request->id)->first();
        $e = $data->jenisPengawasan->jenis;
        return response()->json([
            'status' => 'success',
            'data' => $e
        ]);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data = Pkpt::where('id', $request->id)->first();
        return view('review.create', compact('headermenu', 'menu', 'data'));
    }

    public function modal(Request $request)
    {
        error_reporting(0);
        $status = M_Status_Lhp::all();
        $pkpt = Pkpt::where('id', $request->id)->first();
        $sp = ProgramKerja::where('id_pkpt', $request->id_pkpt)->first();
        $lhp = Lhp::where('id', $request->id)->first();

        return view('review.modal', compact('status', 'pkpt', 'lhp', 'sp'));
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
        if ($request->id > 0) {
            Lhp::where('id', $request->id)->update([
                'no_sp' => $request->no_sp,
                'id_pkpt' => $request->id_pkpt,
                'uraian_temuan' => $request->uraian_temuan,
                'uraian_penyebab' => $request->uraian_penyebab,
                'uraian_rekomendasi' => $request->uraian_rekomendasi,
                'status' => 1,
            ]);
        } else {
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
            ->addColumn('action', function ($row) {
                $crud = '
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="edit(' . $row['id'] . ')">Edit</span>';
                return $crud;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
