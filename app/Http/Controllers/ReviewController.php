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

        $roles =  Auth::user()['role_id'];
        
        if($roles >= 4 && $roles <= 7){
            $data= ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status','>=', 5)->where('status_lhp', '>=',0)->orWhere('status_lhp', null)->get();
        }else if($roles >= 8 && $roles <= 11){
            $data = ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status','>=', 5)->where('status_lhp', 1)->get();
        }else if($roles >= 12 && $roles <= 15){
            $data = ProgramKerja::where('grouping', Auth::user()->roles->sts)->where('status','>=', 5)->where('status_lhp', 2)->get();
        }else{
            $data = ProgramKerja::where('status', 5)->get();
        }

        // if ($role == 3) {
        //     $data = ProgramKerja::where('file_sp', '!=', null)->where('status_lhp', 1)->orderBy('id', 'desc')->get();
        // } else if ($role == 4) {
        //     $data = ProgramKerja::where('file_sp', '!=', null)->where('status_lhp', 2)->orderBy('id', 'desc')->get();
        // } else if ($role == 5) {
        //     $data = ProgramKerja::where('file_sp', '!=', null)->where('status_lhp', 3)->orderBy('id', 'desc')->get();
        // } else {
        //     $data = ProgramKerja::where('file_sp', '!=', null)->orderBy('id', 'desc')->get();
        // }


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
                $el = ProgramKerja::where('id', $row['id'])->first();

                if ($roles >= 4 && $roles <= 7) {
                    if ($el->status_lhp == null) {
                        $btn = '
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Proses</span>';
                    } else  if ($el->status_lhp == 1) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($el->status_lhp == 2) {
                        $btn = 'Disposisi Irban';
                    } else  if ($el->status_lhp == 3) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'selesai';
                    }
                } else if ($roles >= 8 && $roles <= 11) {
                    if ($el->status_lhp == 1) {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>';
                    } else  if ($el->status_lhp == 1) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($el->status_lhp == 2) {
                        $btn = 'Disposisi Irban';
                    } else  if ($el->status_lhp == 3) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'selesai';
                    }
                } else if ($roles >= 12 && $roles <= 15) {
                    if ($el->status_lhp == 2) {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>';
                    } else  if ($el->status_lhp == 1) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($el->status_lhp == 2) {
                        $btn = 'Disposisi Irban';
                    } else  if ($el->status_lhp == 3) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'selesai';
                    }
                }else if ($roles == 2){
                    if ($el->status_lhp == 3) {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                            <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>';
                    } else  if ($el->status_lhp == 1) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($el->status_lhp == 2) {
                        $btn = 'Disposisi Irban';
                    } else  if ($el->status_lhp == 3) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'selesai';
                    }
                }else{
                    if ($el->status_lhp == 1) {
                        $btn = 'Disposisi Dalnis';
                    } else  if ($el->status_lhp == 2) {
                        $btn = 'Disposisi Irban';
                    } else  if ($el->status_lhp == 3) {
                        $btn = 'Disposisi Inspektur';
                    } else {
                        $btn = 'selesai';
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
                $cek=Lhp::where('uraian_temuan', $data['uraian_temuan'])->where('uraian_penyebab',$data['uraian_penyebab'])->count();
                if ($cek > 0) {
                    $get=Lhp::where('uraian_temuan', $data['uraian_temuan'])->where('uraian_penyebab',$data['uraian_penyebab'])->get();
                    foreach ($get as $g) {
                        $btn='-'.$g->uraian_rekomendasi;
                    }
                }
                $btn=$data->uraian_rekomendasi.' '.'<span class="btn btn-ghost-success waves-effect waves-light" onclick="modalrekom(' . $data['id_rekom'] . ')"><i class="mdi mdi-plus-circle-outline"></i></span>';
                return $btn;
            })

            ->addColumn('action', function ($row) {
                $btn = '
                    <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modalLhp(' . $row['uraian_temuan'] . ')">Edit</span>';
                return $btn;
            })
            ->rawColumns(['uraian_rekomendasi','action', 'file_lhp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $headermenu = 'Pelaporan';
        $menu = 'Reviu';
        $id=$request->id;
        $data = ProgramKerja::where('id', $request->id)->first();
        $get = Lhp::where('id_program_kerja', $data->id)->orderBy('parent_id','Asc')->distinct()->count('uraian_penyebab')->get();

        return view('review.create', compact('headermenu', 'menu', 'data','get'));
    }

    public function modal(Request $request)
    {
        error_reporting(0);

        $program = ProgramKerja::where('id', $request->id)->first();
        $data = Lhp::where('id_rekom', $request->id_rekom)->first();
        return view('review.modal', compact('data','program'));
    }

    public function modalrekom(Request $request)
    {
        error_reporting(0);
        $data = Lhp::where('id_rekom', $request->id_rekom)->first();
        return view('review.modalrekomendasi', compact('data'));
    }

    public function modalLhp(Request $request)
    {
        $data = Lhp::where('uraian_temuan', $request->id)->first();
        return view('review.modalLhp', compact('data'));
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

        $role=Auth::user()['role_id'];
        $roles=Role::where('id',$role)->first();
        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'uraian_temuan' => $request->uraian_temuan,
            'uraian_penyebab' => $request->uraian_penyebab,
            'uraian_rekomendasi' => $request->uraian_rekomendasi,
            'status' => 1,
            'parent_id' => 0,
            'grouping' =>$roles->sts,
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

    public function storeRekom(Request $request)
    {
        $this->validate($request, [
            'id_program_kerja' => 'required',
            'uraian_temuan' => 'required',
            'uraian_penyebab' => 'required',
            'uraian_rekomendasi' => 'required',
            // 'file_lhp' => 'required|mimes:pdf|max:2048',
        ]);

        $role=Auth::user()['role_id'];
        $roles=Role::where('id',$role)->first();

        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'uraian_temuan' => $request->uraian_temuan,
            'uraian_penyebab' => $request->uraian_penyebab,
            'uraian_rekomendasi' => $request->uraian_rekomendasi,
            'status' => 1,
            'parent_id' => $request->id_rekom,
            'grouping' => $roles->sts,
        ];


        Lhp::create($data);

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }

    function selesai(Request $request)
    {

        ProgramKerja::where('id', $request->id)->update([
            'status_lhp' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
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
        } else if ($data->status_lhp == 4) {
            $data->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 5,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disetujui'
        ]);
        // $role = Auth::user()->role_id;

        // if ($role == 12 && $role==15) {
        //     ProgramKerja::where('id', $request->id)->update([
        //         'pesan_lhp' => $request->pesan_lhp,
        //         'status_lhp' => 3,
        //     ]);
        // } else if ($role == 12 && $role==15) {
        //     ProgramKerja::where('id', $request->id)->update([
        //         'pesan_lhp' => $request->pesan_lhp,
        //         'status_lhp' => 3,
        //     ]);
        // } else if ($role == 5) {
        //     ProgramKerja::where('id', $request->id)->update([
        //         'pesan_lhp' => $request->pesan_lhp,
        //         'status_lhp' => 4,
        //     ]);
        // }

        // return response()->json([
        //     'status' => 'success',
        //     'success' => 'Data berhasil disimpan.'
        // ]);
    }

    function storeRefused(Request $request)
    {
        $role = Auth::user()->role_id;

        if ($role == 3) {
            ProgramKerja::where('id', $request->id)->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 0,
            ]);
        } else if ($role == 4) {
            ProgramKerja::where('id', $request->id)->update([
                'pesan_lhp' => $request->pesan_lhp,
                'status_lhp' => 1,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }
}
