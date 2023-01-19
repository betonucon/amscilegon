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
                            <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Proses</span>
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                        ';
                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function getTable(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_program_kerja', $request->id_program_kerja)->orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('file_lhp', function ($data) {
                $fileLhp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_lhp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $fileLhp;
            })
            ->addColumn('uraian_temuan', function ($data) {
                $data->uraian_temuan;
            })
            ->addColumn('uraian_penyebab', function ($data) {
                $data->uraian_penyebab;
            })
            ->addColumn('uraian_rekomendasi', function ($data) {
                $data->uraian_rekomendasi;
            })

            ->addColumn('action', function ($row) {
                $btn = '
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Edit</span>
                        ';
                return $btn;
            })
            ->rawColumns(['action', 'file_lhp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.create', compact('headermenu', 'menu', 'data'));
    }

    public function modal(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.modal', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_program_kerja' => 'required',
            'uraian_temuan' => 'required',
            'uraian_penyebab' => 'required',
            'uraian_rekomendasi' => 'required',
            'file_lhp' => 'required|mimes:pdf|max:2048',
        ]);

        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'uraian_temuan' => $request->uraian_temuan,
            'uraian_penyebab' => $request->uraian_penyebab,
            'uraian_rekomendasi' => $request->uraian_rekomendasi,
            'status' => 1,
        ];

        if ($request->hasFile('file_lhp')) {
            $file = $request->file('file_lhp');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file_lhp'), $name);
            $data['file_lhp'] = $name;
        }

        Lhp::create($data);

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }
}
