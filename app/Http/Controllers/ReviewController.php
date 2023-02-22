<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\Role;
use App\Models\Lhpdoc;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use App\Models\RekomendasiModel;
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

        $roles =  Auth::user()->role_id;
        if ($roles == 1) {
            $data = ProgramKerja::where('status', '>=', 4)->get();
        } else if ($roles == 2 || $roles == 3) {
            $data = ProgramKerja::where('status', '>=', 4)->get();
        } elseif ($roles >= 4 && $roles <= 7) {
            $data = ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status', '>=', 4)->get();
        } elseif ($roles >= 8 && $roles <= 11) {
            $data = ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status', '>=', 4)->get();
        } elseif ($roles >= 12 && $roles <= 15) {
            $data = ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status', '>=', 4)->get();
        } else {
            $data = [];
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
            ->addColumn('file_lhp', function ($data) {
                $roles =  Auth::user()['role_id'];
                if ($data->file_lhp == null) {
                    if ($roles >= 4 && $roles <= 7) {
                        $lhp = '
                        <span class="btn btn-warning btn-sm" onclick="upload(' . $data['id'] . ')">Upload</span>
                        ';
                    } else {
                        $lhp = 'Belum di Upload';
                    }
                } else {
                    $lhp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_lhp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                }

                return $lhp;
            })
            ->addColumn('pesan_lhp', function ($data) {
                return $data->pesan_lhp;
            })
            ->addColumn('disposisi', function ($data) {
                if ($data['status_lhp'] == 1) {
                    return 'Disposisi Dalnis';
                } else  if ($data['status_lhp'] == 2) {
                    return 'Disposisi Irban';
                } else  if ($data['status_lhp'] == 3) {
                    return 'Disposisi Inspektur';
                } else  if ($data['status_lhp'] == 4) {
                    return 'Tahap Tindak Lanjut';
                }
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()['role_id'];
                if ($roles >= 4 && $roles <= 7) {
                    if ($row['status_lhp'] == 0) {
                        $btn = '
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="proses(' . $row['id'] . ')">Proses</span>';
                    } else {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        ';
                    }
                } else if ($roles >= 8 && $roles <= 11) {
                    if ($row['status_lhp'] == 1) {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        <span class="btn btn-warning btn-sm" onclick="terima(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-danger btn-sm" onclick="tolak(' . $row['id'] . ')">Tolak</span>
                        ';
                    } else {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        ';
                    }
                } else if ($roles >= 12 && $roles <= 15) {
                    if ($row['status_lhp'] == 2) {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        <span class="btn btn-warning btn-sm" onclick="terima(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-danger btn-sm" onclick="tolak(' . $row['id'] . ')">Tolak</span>
                        ';
                    } else {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        ';
                    }
                } else if ($roles == 2) {
                    if ($row['status_lhp'] == 3) {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        <span class="btn btn-warning btn-sm" onclick="terima(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-danger btn-sm" onclick="tolak(' . $row['id'] . ')">Tolak</span>
                        ';
                    } else {
                        $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        ';
                    }
                } else if ($roles == 3) {
                    $btn = '
                        <span class="btn btn-info btn-sm" onclick="view(' . $row['id'] . ')">Lihat Uraian</span>
                        ';
                }


                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'file_lhp', 'id_pkpt'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.create', compact('headermenu', 'menu', 'data'));
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
                <span class="btn btn-success btn-sm" onclick="rekomendasi(' . $row->id . ')">Lihat Rekomendasi</span>
                <span class="btn btn-warning btn-sm" onclick="editUraian(' . $row->id . ')">Edit</span>
                <span class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ')">Hapus</span>
                    ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function modalTambahUraian(Request $request)
    {
        error_reporting(0);
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.modal_tambah_uraian', compact('data'));
    }

    public function modalEditUraian(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id', $request->id)->first();
        return view('review.modal_edit_uraian', compact('data'));
    }

    public function storeUraian(Request $request)
    {
        if ($request->id == null) {

            $this->validate($request, [
                'id_program_kerja' => 'required',
                'kondisi' => 'required',
                'kriteria' => 'required',
                'penyebab' => 'required',
                'akibat' => 'required',
            ]);

            $data = [
                'id_program_kerja' => $request->id_program_kerja,
                'kondisi' => $request->kondisi,
                'kriteria' => $request->kriteria,
                'penyebab' => $request->penyebab,
                'akibat' => $request->akibat,
            ];

            Lhp::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ]);
        } else {

            $this->validate($request, [
                'kondisi' => 'required',
                'kriteria' => 'required',
                'penyebab' => 'required',
                'akibat' => 'required',
            ]);

            $data = [
                'kondisi' => $request->kondisi,
                'kriteria' => $request->kriteria,
                'penyebab' => $request->penyebab,
                'akibat' => $request->akibat,
            ];

            $a = Lhp::where('id', $request->id)->first();
            $a->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ]);
        }
    }

    public function destroyUraian(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id', $request->id)->first();
        $data->delete();
        $rekomendasi = RekomendasiModel::where('id_lhp', $data->id)->get();
        $rekomendasi->each->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function createRekomendasi(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data = Lhp::where('id', $request->id)->first();
        return view('review.create_rekomendasi', compact('headermenu', 'menu', 'data'));
    }

    public function getRekomendasi(Request $request)
    {
        error_reporting(0);
        $data = RekomendasiModel::where('id_lhp', $request->id_lhp)->get();
        return Datatables::of($data)
            ->addColumn('rekomendasi', function ($data) {
                return $data->rekomendasi;
            })
            ->addColumn('action', function ($row) {
                $btn = '
                <span class="btn btn-warning btn-sm" onclick="editRekomendasi(' . $row->id . ')">Edit</span>
                <span class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ')">Hapus</span>
                    ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function modalTambahRekomendasi(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id', $request->id)->first();
        return view('review.modal_tambah_rekomendasi', compact('data'));
    }

    public function modalEditRekomendasi(Request $request)
    {
        error_reporting(0);
        $data = RekomendasiModel::where('id', $request->id)->first();
        return view('review.modal_edit_rekomendasi', compact('data'));
    }

    public function storeRekomendasi(Request $request)
    {
        if ($request->id == null) {

            $this->validate($request, [
                'id_lhp' => 'required',
                'rekomendasi' => 'required',
            ]);

            $data = [
                'id_lhp' => $request->id_lhp,
                'rekomendasi' => $request->rekomendasi,
            ];

            RekomendasiModel::create($data);
            $get = RekomendasiModel::where('id_lhp', $request->id_lhp)->get();
            foreach ($get as $no => $o) {
                $updt = RekomendasiModel::where('id', $o->id)->update([
                    'urut' => ($no + 1),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ]);
        } else {

            $this->validate($request, [
                'rekomendasi' => 'required',
            ]);

            $data = [
                'rekomendasi' => $request->rekomendasi,
            ];

            $a = RekomendasiModel::where('id', $request->id)->first();
            $a->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ]);
        }
    }

    public function destroyRekomendasi(Request $request)
    {
        error_reporting(0);
        $data = RekomendasiModel::where('id', $request->id)->first();
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function kirim(Request $request)
    {
        error_reporting(0);
        $data = ProgramKerja::where('id', $request->id)->first();
        $data->update([
            "status_lhp" => 1,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dikirim'
        ]);
    }

    public function view(Request $request)
    {
        error_reporting(0);
        $headermenu = 'Pelaporan';
        $menu = 'Laporan Hasil Pemeriksaan';
        $data = Lhp::where('id_program_kerja', $request->id)->get();
        return view('review.view', compact('headermenu', 'menu', 'data'));
    }

    public function viewRekomendasi(Request $request)
    {
        error_reporting(0);
        $headermenu = 'Pelaporan';
        $menu = 'Laporan Hasil Pemeriksaan';
        $data = RekomendasiModel::where('id_lhp', $request->id)->get();
        return view('review.view_rekomendasi', compact('headermenu', 'menu', 'data'));
    }

    function modalApprove(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.modalApprove', compact('data'));
    }

    function modalRefused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.modalRefused', compact('data'));
    }

    function storeApprove(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        if ($data->status_lhp == 1) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 2,
            ]);
        } else if ($data->status_lhp == 2) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 3,
            ]);
        } else if ($data->status_lhp == 3) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 4,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    function storeRefused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();

        if ($data->status_lhp == 1) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => null,
            ]);
        } elseif ($data->status_lhp == 2) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 1,
            ]);
        } elseif ($data->status_lhp == 3) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 2,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    function modalUpload(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('review.modalUpload', compact('data'));
    }

    function upload(Request $request)
    {
        $request->validate([
            'file_lhp' => 'required|mimes:pdf',
        ]);

        if ($files = $request->file('file_lhp')) {
            $namapkp = 'LHP' . date('YmdHis');
            $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $data['file_lhp'] = $profileImage;
        }

        $data = ProgramKerja::where('id', $request->id)->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan.'
        ]);
    }
}
