<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\Role;
use App\Models\Status;
use App\Models\M_Status_Lhp;
use App\Models\ProgramKerja;
use App\Models\TindakLanjut;
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
        if ($roles >= 4 && $roles <=7) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->where('status_tindak_lanjut','>=',1)->get();
        }elseif ($roles >= 8 && $roles <= 11) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('grouping', Auth::user()->roles->sts)->where('status_tindak_lanjut','>=', 2)->get();
        }elseif ($roles >= 12 && $roles <= 15) {
            $data = ProgramKerja::where('status_lhp', 4)->orderBy('id', 'desc')->where('status_tindak_lanjut', 2)->get();
        }else {
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
            // ->addColumn('pkp', function ($data) {
            //     $pkp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['pkp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
            //     return $pkp;
            // })
            // ->addColumn('nota_dinas', function ($data) {
            //     $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['nota_dinas'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
            //     return $notaDinas;
            // })
            ->addColumn('file_sp', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_sp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()->role_id;
                if ($roles >= 4 && $roles<=7) {
                    if ($row['status_tindak_lanjut'] == 1) {
                        $btn = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span>
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                    ';
                    }elseif ($row['status_tindak_lanjut'] == 2) {
                        $btn = 'Disposisi Dalnis';
                    }else{
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span>'.'-'.'Selesai';
                    }
                } elseif ($roles >= 8 && $roles<=11) {
                    if ($row['status_tindak_lanjut'] == 1) {
                        $btn = 'Disposisi Ketua Team';
                    }elseif ($row['status_tindak_lanjut'] == 2) {
                        $btn = '
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span>
                        <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="modal_approved(' . $row['id'] . ')">Terima</span>
                        <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="modal_refused(' . $row['id'] . ')">Tolak</span>
                    ';
                    }else{
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span>'.'-'.'Selesai';
                    }
                } else {
                    if ($row['status_tindak_lanjut'] == null) {
                        $btn =
                            '<span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Proses</span>';
                    } elseif ($row['status_tindak_lanjut'] == 1) {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span> - Disposisi Ketua Team';
                    } elseif ($row['status_tindak_lanjut'] == 2) {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span> - Disposisi Dalnis';
                    } else {
                        $btn = '<span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Detail</span>'.'-'.'Selesai';
                    }
                }

                return $btn;
            })
            ->rawColumns(['action', 'pkp', 'nota_dinas', 'file_sp', 'id_pkpt'])
            ->make(true);
    }

    public function datacreate(Request $request)
    {
        error_reporting(0);
        $get = ProgramKerja::where('id', $request->id)->first();
        $data = Lhp::where('id_program_kerja', $get->id)->whereNotNull('file_lhp')->get();
        return Datatables::of($data)
            ->addColumn('id', function ($data) {
                return '';
            })
            ->addColumn('file_lhp', function ($data) {
                $pdf = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`' . $data['file_lhp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $pdf;
            })
            ->addColumn('kondisi', function ($data) {
                return $data['kondisi'];
            })
            ->addColumn('kriteria', function ($data) {
                return $data['kriteria'];
            })
            ->addColumn('penyebab', function ($data) {
                return $data['penyebab'];
            })
            ->addColumn('akibat', function ($data) {
                return $data['akibat'];
            })
            ->addColumn('jawaban', function ($data) {
                $tindak=TindakLanjut::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
                $table='<ul>';
                foreach ($tindak as $l) {
                    $table.='<li>'.$l['uraian_jawaban'].'</li>';
                }
                $table.='<ul>';
                return $table;
            })
            ->addColumn('rekom', function ($data) {
                // $tindak=TindakLanjut::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
                $lhp=Lhp::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
                // $table=$data['uraian_rekomendasi'];
                // foreach ($tindak as $t) {
                //     $table.='<li>'.$t['uraian_jawaban'].'</li>';
                // }
                // $table.='<td>'.$data['uraian_rekomendasi'].'</td>';
                $table='';
                foreach ($lhp as $l) {
                    $table.=$l['uraian_rekomendasi'];
                }
                // $table.='</tr>';
                return $table;
            })

            ->addColumn('parent_rekom', function ($data) {
                // $tindak=TindakLanjut::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
                $lhp=Lhp::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
                $table='';
                // foreach ($tindak as $t) {
                //     $table.='<li>'.$t['uraian_jawaban'].'</li>';
                // }
                // $table.='<td>'.$data['uraian_rekomendasi'].'</td>';
                foreach ($lhp as $l) {
                    $table.='<tr><td>'.$l['uraian_rekomendasi'].'</td></tr>';
                }
                $table.='';
                return $table;
            })

            // ->addColumn('parent_rekom', function ($data) {
            //     // $group=TindakLanjut::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
            //     $child=Lhp::where('grouping', $data->grouping)->where('parent_id', $data->id_rekom)->get();
            //     foreach ($child as $key) {
            //         $table='<td>'.$key['uraian_rekomendasi'].'</td><td><tr><ul>';
            //         $table.='<li>'.$key['uraian_jawaban'].'</li>';
            //     }
            //     return $table;
            // })




            ->rawColumns(['file_lhp', 'rekomedasi','jawaban','parent_rekom'])
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
        $id_tindak = $request->id_tindak_lanjut;
        $lhp = Lhp::where('id_rekom', $request->id_rekom)->first();
        $data = TindakLanjut::where('parent_id', $request->id_rekom)->first();

        return view('tindak_lanjut.modalrekomendasi', compact('data', 'id_rekom','lhp'));
    }
    
    public function modaleditrekom(Request $request)
    {
        error_reporting(0);
        $parent_id = $request->parent_id;
        $id_tindak = $request->id_tindak_lanjut;
        $data = TindakLanjut::where('id_tindak_lanjut', $request->id_tindak_lanjut)->first();
        $lhp = Lhp::where('id_rekom', $data->parent_id)->first();
        return view('tindak_lanjut.modaleditrekomendasi', compact('data', 'id_tindak','parent_id','lhp'));
    }

    public function hapusrekom(Request $request)
    {
        error_reporting(0);
        $data = TindakLanjut::where('id_tindak_lanjut', $request->id_tindak_lanjut)->delete();
    }

    function selesai(Request $request)
    {

        ProgramKerja::where('id', $request->id)->update([
            'status_tindak_lanjut' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
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
        if ($data->status_tindak_lanjut == 1) {
            $data->update([
                'pesan_tindak_lanjut' => $request->pesan_tindak_lanjut,
                'status_tindak_lanjut' => 2,
            ]);
        } else if ($data->status_tindak_lanjut == 2) {
            $data->update([
                'pesan_tindak_lanjut' => $request->pesan_lhp,
                'status_tindak_lanjut' => 3,
            ]);
        }


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

    public function carijawaban(Request $request)
    {
        $data= TindakLanjut::where('id_tindak_lanjut', $request->id_tindak_lanjut)->first();
        echo $data->uraian_jawaban;
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            // 'id_program_kerja' => 'required',
            // 'rekomendasi_id' => 'required',
            'uraian_jawaban' => 'required',
            // 'file_lhp' => 'required|mimes:pdf|max:2048',
        ]);

        $role = Auth::user()['role_id'];
        $roles = Role::where('id', $role)->first();
        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'uraian_jawaban' => $request->uraian_jawaban,
            'parent_id' => $request->uraian_rekomendasi,
            'grouping' => $request->grouping,
        ];

        if ($request->hasFile('file_lhp')) {
            $file = $request->file('file_lhp');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file_lhp'), $name);
            $data['file_lhp'] = $name;
        }
        if ($request->id_tindak_lanjut > 0) {
            TindakLanjut::where('id_tindak_lanjut',$request->id_tindak_lanjut)->update($data);
        }else{
            TindakLanjut::create($data);
        }

        return response()->json([
            'status' => 'success',
            'success' => 'Data berhasil disimpan.'
        ]);
    }
}
