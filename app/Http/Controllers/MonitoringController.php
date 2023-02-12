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
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->where('status_tindak_lanjut', 1)->get();
        } else if ($roles >= 8 && $roles <= 11) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->where('status_tindak_lanjut', 2)->get();
        } else if ($roles >= 1 && $roles <= 3 || $roles >= 12 && $roles <= 15) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('status_tindak_lanjut', 2)->get();
        } else {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('id_pkpt', $pkpt->id)->get();
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

    public function getTable(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_program_kerja', $request->id_program_kerja)->orderBy('parent_id', 'Asc')->get();

        return Datatables::of($data)
            ->addColumn('file_lhp', function ($data) {
                $fileLhp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_lhp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $fileLhp;
            })
            ->addColumn('uraian_temuan', function ($data) {
                return  $data->uraian_temuan;
            })
            ->addColumn('uraian_penyebab', function ($data) {
                return   $data->uraian_penyebab;
            })
            ->addColumn('uraian_rekomendasi', function ($data) {
                $cek = Lhp::where('uraian_temuan', $data['uraian_temuan'])->where('uraian_penyebab', $data['uraian_penyebab'])->count();
                if ($cek > 0) {
                    $get = Lhp::where('uraian_temuan', $data['uraian_temuan'])->where('uraian_penyebab', $data['uraian_penyebab'])->get();
                    foreach ($get as $g) {
                        $btn = '-' . $g->uraian_rekomendasi;
                    }
                }
                $btn = $data->uraian_rekomendasi . ' ' . '<span class="btn btn-ghost-success waves-effect waves-light" onclick="modalrekom(' . $data['id_rekom'] . ')"><i class="mdi mdi-plus-circle-outline"></i></span>';
                return $btn;
            })
            ->addColumn('uraian_jawaban', function ($data) {
                $cek = Lhp::where('uraian_rekomendasi', $data['uraian_rekomendasi'])->count();
                if ($cek > 0) {
                    $get = Lhp::where('uraian_rekomendasi', $data['uraian_rekomendasi'])->get();
                    foreach ($get as $g) {
                        $btn = '-' . $g->uraian_jawaban;
                    }
                }
                $btn = $data->uraian_jawaban . ' ' . '<span class="btn btn-ghost-success waves-effect waves-light" onclick="modalrekom(' . $data['id_rekom'] . ')"><i class="mdi mdi-plus-circle-outline"></i></span>';
                return $btn;
            })

            ->addColumn('action', function ($row) {
                $btn = '
                    <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modalLhp(' . $row['uraian_temuan'] . ')">Edit</span>';
                return $btn;
            })
            ->rawColumns(['uraian_rekomendasi', 'action', 'file_lhp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $id = $request->id;
        $data = ProgramKerja::where('id', $request->id)->first();
        $get = Lhp::where('id_program_kerja', $data->id)->whereNotNull('file_lhp')->get();
        $count = Lhp::where('id_program_kerja', $data->id)->count();
        $output = [];
        $no = 1;
        foreach ($get as $k) {
            $output[] = [
                $no++,
                $k->file_lhp,
                $k->uraian_temuan,
                $k->uraian_penyebab,
                $k->uraian_rekomendasi,
                $k->id_rekom,
                $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modalLhp(' . $k->id_rekom . ')">Edit</span>'

            ];
        }
        return view('tindak_lanjut.create', compact('headermenu', 'menu', 'data', 'output', 'count', 'get'));
    }

    public function modalrekom(Request $request)
    {
        error_reporting(0);
        $id_rekom = $request->parent_id;
        $data = Lhp::where('id_rekom', $request->id_rekom)->first();
        return view('tindak_lanjut.modalrekomendasi', compact('data', 'id_rekom'));
    }

    public function hapusrekom(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_rekom', $request->id_rekom)->delete();
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
