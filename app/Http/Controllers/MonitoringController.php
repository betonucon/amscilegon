<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use App\Models\Status;
use App\Models\TindakLanjut;
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
        $role =  Auth::user()->role_id;
        $roles =  Auth::user()->roles->nama;
        $pkpt = Pkpt::where('opd', $roles)->first();
        if ($roles >= 4 && $roles <= 7) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping',Auth::user()->roles->sts)->where('status_tindak_lanjut', null)->get();
        }else if ($roles >= 8 && $roles <= 11) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping',Auth::user()->roles->sts)->where('status_tindak_lanjut', 1)->get();
        }else if ($roles >= 12 && $roles <= 15) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping',Auth::user()->roles->sts)->where('status_tindak_lanjut', 2)->get();
        }else if ($roles >= 1 && $roles <= 3) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('status_tindak_lanjut', 2)->get();
        }else{
            $data = ProgramKerja::where('status_lhp', 4)->where('status_tindak_lanjut', 2)->orderBy('id', 'desc')->where('id_pkpt', $pkpt->id)->get();
        }

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

                if ($roles == 2) {
                    if ($row['status_tindak_lanjut'] == 2) {
                        $btn = 'Selesai';
                    } else {
                        $btn = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                    ';
                    }
                } else {
                    if ($row['status_tindak_lanjut'] == null) {
                        $btn =
                            '<span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Proses</span>';
                    } else   if ($row['status_tindak_lanjut'] == 1) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'Selesai';
                    }
                }

                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function modal(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();

        return view('tindak_lanjut.modal', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_program_kerja' => 'required',
            'uraian_tindak_lanjut' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'uraian_tindak_lanjut' => $request->uraian_tindak_lanjut,
        ];

        if ($files = $request->file('file')) {
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $data['file'] = "$profileImage";
        }

        TindakLanjut::create($data);

        ProgramKerja::where('id', $request->id_program_kerja)
            ->update([
                'status_tindak_lanjut' => 1
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);
    }

    function modalApprove(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('tindak_lanjut.modalApprove', compact('data'));
    }

    function modalRefused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('tindak_lanjut.modalRefused', compact('data'));
    }

    function storeApprove(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        $data->update([
            'pesan_tindak_lanjut' => $request->pesan_tindak_lanjut,
            'status_tindak_lanjut' => 2,
        ]);


        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }

    function storeRefused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        $data->update([
            'pesan_tindak_lanjut' => $request->pesan_tindak_lanjut,
            'status_tindak_lanjut' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }
}
