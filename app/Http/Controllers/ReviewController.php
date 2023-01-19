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
        $data = ProgramKerja::where('status','>=', 5)->orderBy('id', 'desc')->get();

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
                $roles =  Auth::user()->role_id;
                $status = $row['status'];
                if ($status==5) {
                    if ($roles==2) {
                        if ($row['file_sp']!==null) {
                            $aproval = '
                                <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row->pkpt['id'] . ')">Proses</span>';
                            // return $crud;
                        }
                    }else{                   
                        return 'none';
                    }
                }elseif ($status==6) {
                    if ($roles==3) {
                        $aproval = '
                            <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                        ';

                    }
                }elseif ($status==7) {
                    if ($roles==4) {
                        $aproval = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                    ';
                    }
                }elseif ($status==8) {
                    if ($roles==5) {
                        $aproval = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                    ';
                    }
                }elseif ($status==9) {
                    if ($roles==6) {
                        $aproval = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                    ';
                    }
                }
                return $aproval;
            })
            // ->addColumn('selesai', function ($data) {
            //     $selesai = Lhp::where('id_pkpt', $data->id)->where('status', 'S')->count();
            //     return $selesai;
            // })
            // ->addColumn('belum_selesai', function ($data) {
            //     $belum_selesai = Lhp::where('id_pkpt', $data->id)->where('status', 'BS')->count();
            //     return $belum_selesai;
            // })
            // ->addColumn('belum_tindak', function ($data) {
            //     $belum_tindak = Lhp::where('id_pkpt', $data->id)->where('status', 'BT')->count();
            //     return $belum_tindak;
            // })
            // ->addColumn('tidak_lanjut', function ($data) {
            //     $tidak_lanjut = Lhp::where('id_pkpt', $data->id)->where('status', 'TT')->count();
            //     return $tidak_lanjut;
            // })
            // ->addColumn('file', function ($data) {
            //     $files = Lhpdoc::where('id_pkpt', $data->id)->first();
            //     return $files->file;
            // })
            ->addColumn('status', function ($data) {
                if ($data['status']==6) {
                    $status='Pending';
                    return $status;
                }else{
                    $status='Menunggu Approval';
                    return $status;
                }
                // $sts = Status::where('id', $data->status)->first();
                // $status = '<span class="' . $sts->text . '">' . $sts->status . '</span>';

                // return $status;
            })

            ->rawColumns(['status', 'action', 'pkp', 'nota_dinas', 'area_pengawasannya'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $data=Pkpt::where('id', $request->id)->first();
        return view('review.create', compact('headermenu', 'menu','data'));
    }

    public function modal(Request $request)
    {
        error_reporting(0);
        $status = M_Status_Lhp::all();
        $pkpt = Pkpt::where('id', $request->id)->first();
        $sp= ProgramKerja::where('id_pkpt', $request->id_pkpt)->first();
        $lhp=Lhp::where('id', $request->id)->first();

        return view('review.modal', compact('status', 'pkpt','lhp','sp'));
    }

    public function store(Request $request)
    {
        error_reporting(0);

        // if ($request->id == null) {

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
                'status' => 1,
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
        // } else {

        //     $data = [
        //         'id_pkpt' => $request->id_pkpt,
        //         'uraian_temuan' => $request->uraian_temuan,
        //         'uraian_penyebab' => $request->uraian_penyebab,
        //         'uraian_rekomendasi' => $request->uraian_rekomendasi,
        //         'uraian_tindak_lanjut' => $request->uraian_tindak_lanjut,
        //         'nilai_rekomendasi' => $request->nilai_rekomendasi,
        //         'nilai_tindak_lanjut' => $request->nilai_tindak_lanjut,
        //         'status_nilai' => $request->status_nilai,
        //         'status' => $request->status,
        //     ];

        //     Lhp::where('id', $request->id)->update($data);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data Berhasil Diupdate'
        //     ]);
        // }
    }

    public function getTable(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_pkpt', $request->id_pkpt)->get();

        return Datatables::of($data)
            // ->addColumn('id_pkpt', function ($data) {
            //     return  $data['id_pkpt'];
            // })
            ->addColumn('uraian_temuan', function ($data) {
                return $data['uraian_temuan'];
            })
            ->addColumn('uraian_penyebab', function ($data) {
                return $data['uraian_penyebab'];
            })
            ->addColumn('uraian_rekomendasi', function ($data) {
                return $data['uraian_rekomendasi'];
            })
            // ->addColumn('uraian_tindak_lanjut', function ($data) {
            //     return $data['uraian_tindak_lanjut'];
            // })
            // ->addColumn('nilai_rekomendasi', function ($data) {
            //     return $data['nilai_rekomendasi'];
            // })
            // ->addColumn('nilai_tindak_lanjut', function ($data) {
            //     return $data['nilai_tindak_lanjut'];
            // })
            // ->addColumn('status_nilai', function ($data) {
            //     return $data['status_nilai'];
            // })
            // ->addColumn('status', function ($data) {
            //     return $data['status'];
            // })
            ->addColumn('action', function ($row) {
                $crud = '
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="edit(' . $row['id'] . ')">Edit</span>';
                return $crud;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
