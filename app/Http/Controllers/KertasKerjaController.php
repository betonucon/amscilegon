<?php

namespace App\Http\Controllers;

use App\Models\Pkpt;
use App\Models\Status;
use App\Models\KertasKerja;
use App\Models\ProgramKerja;
use App\Models\Viewkertaskerja;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use ConvertApi\ConvertApi;

class KertasKerjaController extends Controller
{
    public function index()
    {
        $headermenu = 'Perencanaan';
        $menu = 'Kertas Kerja Pemeriksaan';
        return view('kertaskerja.index', compact('headermenu', 'menu'));
    }

    public function modal(Request $request)
    {
        error_reporting(0);
        $pkpt = Pkpt::all();
        $data = KertasKerja::where('id', $request->id)->first();
        return view('kertaskerja.modal', compact('pkpt', 'data'));
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

    public function modalApprove(Request $request)
    {
        $data = KertasKerja::where('id', $request->id)->first();
        return view('kertaskerja.modalApprove', compact('data'));
    }

    public function modalRefused(Request $request)
    {
        $data = KertasKerja::where('id', $request->id)->first();
        return view('kertaskerja.modalRefused', compact('data'));
    }

    public function getdata(Request $request)
    {
        error_reporting(0);
        $data = ProgramKerja::where('file_sp', '!=', null)->orderBy('id', 'desc')->get();

        return Datatables::of($data)
            ->addColumn('id_pkpt', function ($data) {
                $pkpt = Pkpt::where('id', $data->id_pkpt)->first();
                return '<a href="javascript:;" onclick="tampil(' . $pkpt->id . ')">' . substr($pkpt->area_pengawasan, 0, 50) . '...</a>';
            })
            ->addColumn('text_area_pengawasan', function ($data) {
                return '<a href="javascript:;" onclick="tampil_detail(`' . $data->jenis . '`)">[PKPT' . $data['id_pkpt'] . ']' . substr($data->area_pengawasan, 0, 70) . '...</a>';
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
            ->addColumn('status', function ($data) {
                $sts = Status::where('id', $data->status)->first();
                $status = '<span class="' . $sts->text . '">' . $sts->status . '</span>';
                return $status;
            })
            ->addColumn('pesan', function ($data) {
                $roles =  Auth::user()->role_id;
                $pesan = $data['pesan'];
                return $pesan;
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()->role_id;
                $status = $row['status'];
                $sts = Status::where('id', $row->status)->first();
                if ($roles == 1) {
                    if ($status == 1) {
                        $btn = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Edit</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="hapus(' . $row['id'] . ')">Delete</span>
                    ';
                    }
                } elseif ($roles == 2) {
                    if ($status == 1) {
                        $btn = '
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                        ';
                    } else {
                        $btn = '<span class="' . $sts->text . '"><i class="fa fa-check"></i>Selesai</span>';
                    }
                } else {
                    $btn = '<span class="' . $sts->text . '"><i class="fa fa-check"></i> ' . $sts->sts_keterangan . '</span>';
                }
                return $btn;
            })
            ->rawColumns(['status', 'action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function store(Request $request)
    {
        error_reporting(0);
        ConvertApi::setApiSecret('8hHtmz5CYPolhdvq');
        if ($request->id == null) {

            $request->validate([
                'id_pkpt' => 'required',
                'file' => 'required||mimes:pdf,xlsx,xls|max:2048',
            ]);

            $data = [
                'id_pkpt' => $request->id_pkpt,
                'status' => 1,
            ];

            if ($files = $request->file('file')) {
                $namapkp = date('YmdHis');
                $destinationPath = 'public/file_upload/'; // upload path
                $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
                $files->move(public_path('/file_upload'), $profileImage);
                $ext = explode('.', $profileImage);
                // dd($ext);
                $data['file'] = $profileImage;
                $data['ext'] = $ext[1];
                KertasKerja::create($data);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan'
            ]);
        } else {
            $data = KertasKerja::where('id', $request->id)->first();
            $data->update([
                'id_pkpt' => $request->id_pkpt,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Diupdate'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $data = KertasKerja::where('id', $request->id)->first();
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    public function approved(Request $request)
    {
        $data = KertasKerja::where('id', $request->id)->first();
        $data->update([
            'status' => 2,
            'pesan' => $request->pesan,
        ]);

        echo 'ok';
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data Berhasil Diapproved'
        // ]);
    }

    public function refused(Request $request)
    {
        $data = KertasKerja::where('id', $request->id)->first();
        $data->update([
            'status' => 1,
            'pesan' => $request->pesan,
        ]);

        echo 'ok';
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data Berhasil Direfused'
        // ]);
    }
}
