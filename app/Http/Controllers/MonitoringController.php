<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\ProgramKerja;
use App\Models\RekomendasiModel;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;


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
        $opd =  Auth::user()->name;
        $roles =  Auth::user()->role_id;
        $pkpt = Pkpt::where('opd', $opd)->first();
        if ($roles >= 4 && $roles <= 7) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->get();
        } elseif ($roles >= 8 && $roles <= 11) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->get();
        } elseif ($roles >= 12 && $roles <= 15) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->get();
        } elseif ($roles == 2 || $roles == 3) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->get();
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
            ->addColumn('file_sp', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_sp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('action', function ($row) {
                $btn = '
                <span class="btn btn-primary btn-sm" onclick="viewUraian(' . $row['id'] . ')">Lihat Uraian</span>';

                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function viewUraian(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Tindak Lanjut';
        $data = ProgramKerja::where('id', $request->id)->first();

        return view('tindak_lanjut.view', compact('headermenu', 'menu', 'data'));
    }

    public function getTable(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_program_kerja', $request->id_program_kerja)->get();
        return Datatables::of($data)
            ->addColumn('kondisi', function ($data) {
                return $data->kondisi;
            })
            ->addColumn('kriteria', function ($data) {
                return   $data->kriteria;
            })
            ->addColumn('penyebab', function ($data) {
                return   $data->penyebab;
            })
            ->addColumn('akibat', function ($data) {
                return   $data->akibat;
            })
            ->addColumn('action', function ($row) {
                $btn = '
                <center>
                <span class="btn btn-success btn-sm" onclick="rekomendasi(' . $row->id . ')">Lihat Rekomendasi</span>
                </center>
                ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function viewRekomendasi(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Tindak Lanjut';
        $data = Lhp::where('id', $request->id)->first();

        return view('tindak_lanjut.view_rekomendasi', compact('headermenu', 'menu', 'data'));
    }

    public function getRekomendasi(Request $request)
    {
        error_reporting(0);
        $data = RekomendasiModel::where('id_lhp', $request->id_lhp)->get();
        return Datatables::of($data)
            ->addColumn('rekomendasi', function ($data) {
                return $data->rekomendasi;
            })
            ->addColumn('jawaban', function ($data) {
                return   $data->jawaban;
            })
            ->addColumn('file_jawaban', function ($data) {
                if ($data->file_jawaban == null) {
                    $fileJawaban = 'Belum Di Upload';
                } else {
                    $fileJawaban = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_jawaban'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                }
                return $fileJawaban;
            })
            ->addColumn('pesan', function ($data) {
                return   $data->pesan;
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()->role_id;
                if ($roles >= 16 && $roles <= 100) {
                    if ($row->status == null) {
                        $btn = '
                        <center>
                        <span class="btn btn-success btn-sm" onclick="jawaban(' . $row->id . ')">Jawaban</span>
                        <span class="btn btn-primary btn-sm" onclick="kirim(' . $row->id . ')">Kirim</span>
                        </center>
                        ';
                    } else  if ($row->status == 1) {
                        $btn = 'Disposisi Ketua Tim';
                    } else  if ($row->status == 2) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($row->status == 3) {
                        $btn = 'Selesai';
                    }
                } else  if ($roles >= 4 && $roles <= 7) {
                    if ($row->status == 1) {
                        $btn = '
                        <center>
                        <span class="btn btn-success btn-sm" onclick="terima(' . $row->id . ')">Terima</span>
                        <span class="btn btn-danger btn-sm" onclick="tolak(' . $row->id . ')">Tolak</span>
                        </center>
                        ';
                    } else  if ($row->status == 2) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($row->status == 3) {
                        $btn = 'Selesai';
                    } else {
                        $btn = 'Belum di Proses OPD';
                    }
                } else  if ($roles >= 8 && $roles <= 11) {
                    if ($row->status == 1) {
                        $btn = 'Disposisi Ketua Tim';
                    } else  if ($row->status == 2) {
                        $btn = '
                        <center>
                        <span class="btn btn-success btn-sm" onclick="terima(' . $row->id . ')">Terima</span>
                        <span class="btn btn-danger btn-sm" onclick="tolak(' . $row->id . ')">Tolak</span>
                        </center>
                        ';
                    } else  if ($row->status == 3) {
                        $btn = 'Selesai';
                    } else {
                        $btn = 'Belum di Proses OPD';
                    }
                } else  if ($roles == 2 || $roles == 3) {
                    if ($row->status == 1) {
                        $btn = 'Disposisi Ketua Tim';
                    } else  if ($row->status == 2) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($row->status == 3) {
                        $btn = 'Selesai';
                    } else {
                        $btn = 'Belum di Proses OPD';
                    }
                }
                return $btn;
            })
            ->rawColumns(['action', 'file_jawaban'])
            ->make(true);
    }

    public function modalJawaban(Request $request)
    {

        $data = RekomendasiModel::where('id', $request->id)->first();

        return view('tindak_lanjut.modal_jawaban', compact('data'));
    }

    public function storeJawaban(Request $request)
    {
        if ($request->hidden_file == null) {


            $this->validate($request, [
                'jawaban' => 'required',
                'file_jawaban' => 'required',
            ]);

            $data = [
                'jawaban' => $request->jawaban,

            ];

            if ($files = $request->file('file_jawaban')) {
                $namapkp = 'JAWABAN' . date('YmdHis');
                $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
                $files->move(public_path('/file_upload'), $profileImage);
                $data['file_jawaban'] = $profileImage;
            }


            $a =  RekomendasiModel::where('id', $request->id)->first();
            $a->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ]);
        } else {
            $this->validate($request, [
                'jawaban' => 'required',
            ]);

            $data = [
                'jawaban' => $request->jawaban,

            ];

            if ($files = $request->file('file_jawaban')) {
                $namapkp = 'JAWABAN' . date('YmdHis');
                $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
                $files->move(public_path('/file_upload'), $profileImage);
                $data['file_jawaban'] = $profileImage;
            }


            $a =  RekomendasiModel::where('id', $request->id)->first();
            $a->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ]);
        }
    }

    function kirim(Request $request)
    {
        $data = RekomendasiModel::where('id', $request->id)->first();
        $data->update([
            'status' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    function modalApprove(Request $request)
    {
        $data = RekomendasiModel::where('id', $request->id)->first();
        return view('tindak_lanjut.modalApprove', compact('data'));
    }

    function modalRefused(Request $request)
    {
        $data = RekomendasiModel::where('id', $request->id)->first();
        return view('tindak_lanjut.modalRefused', compact('data'));
    }

    function storeApprove(Request $request)
    {
        $data = RekomendasiModel::where('id', $request->id)->first();

        if ($data->status == 1) {
            $data->update([
                'pesan' => $request->pesan,
                'status' => 2,
            ]);
        } elseif ($data->status == 2) {
            $data->update([
                'pesan' => $request->pesan,
                'status' => 3,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    function storeRefused(Request $request)
    {
        $data = RekomendasiModel::where('id', $request->id)->first();

        if ($data->status == 1) {
            $data->update([
                'pesan' => $request->pesan,
                'status' => null,
            ]);
        } elseif ($data->status == 2) {
            $data->update([
                'pesan' => $request->pesan,
                'status' => 1,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function cetak(Request $request)
    {
        $data = Lhp::all();

        $pdf = PDF::loadview('tindak_lanjut.cetak', ['data' => $data]);
        return $pdf->stream('laporan-pegawai-pdf');
    }
}
