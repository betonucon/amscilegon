<?php

namespace App\Http\Controllers;

use App\Models\Pkpt;
use App\Models\Role;
use App\Models\Button;
use App\Models\Status;
use App\Models\HeaderPkpt;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use App\Models\ViewprogramKerja;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use ConvertApi\ConvertApi;
class ProgramKerjaController extends Controller
{
    public function index()
    {
        $headermenu = 'Perencanaan';
        $menu = 'Penyusunan Program Kerja Pengawasan';
        return view('programkerja.index', compact('headermenu', 'menu'));
    }

    public function getTable(Request $request)
    {
        $count=HeaderPkpt::count();
        $get= HeaderPkpt::where('id', $count)->first();
        $data = Pkpt::where('jenis', $get->nomor_pkpt)->get();

        return Datatables::of($data)
            ->addColumn('id', function ($data) {
                return  $data['id'];
            })
            // ->addColumn('jenis', function ($data) {
            //     return $data['jenis'];
            // })
            ->addColumn('area_pengawasan', function ($data) {
                return $data['area_pengawasan'];
            })
            ->addColumn('jenis_pengawasan', function ($data) {
                return $data['jenis_pengawasan'];
            })
            ->addColumn('opd', function ($data) {
                return $data['opd'];
            })
            ->addColumn('rmp', function ($data) {
                return $data['rmp'];
            })
            ->addColumn('rpl', function ($data) {
                return $data['rpl'];
            })
            ->addColumn('sarana_prasarana', function ($data) {
                return $data['sarana_prasarana'];
            })
            ->addColumn('tingkat_resiko', function ($data) {
                return $data['tingkat_resiko'];
            })
            ->addColumn('keterangan', function ($data) {
                return $data['keterangan'];
            })
            ->addColumn('tujuan', function ($data) {
                return $data['tujuan'];
            })
            ->addColumn('koorwas', function ($data) {
                return $data['koorwas'];
            })
            ->addColumn('pt', function ($data) {
                return $data['pt'];
            })
            ->addColumn('kt', function ($data) {
                return $data['kt'];
            })
            ->addColumn('at', function ($data) {
                return $data['at'];
            })
            ->addColumn('jumlah', function ($data) {
                return $data['jumlah'];
            })
            ->addColumn('jumlah_laporan', function ($data) {
                return $data['jumlah_laporan'] . ' ' . $data['kategori'];
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        error_reporting(0);
        $headermenu = 'Perencanaan';
        $menu = 'Penyusunan Program Kerja Pengawasan';

        $jenisPkpt = HeaderPkpt::all();
        $data = ProgramKerja::where('id', $request->id)->first();

        return view('programkerja.create', compact('jenisPkpt', 'menu', 'headermenu', 'data'));
    }

    public function getdata(Request $request)
    {
        error_reporting(0);
        $roles =  Auth::user()->role_id;
        $data = ProgramKerja::orderBy('id', 'desc')->get();
        return Datatables::of($data)
            ->addColumn('id_pkpt', function ($data) {
                return $data['id_pkpt'];
            })
            ->addColumn('area_pengawasannya', function ($data) {
                return '<a href="javascript:;" onclick="tampil(`'.$data->id_pkpt.'`)">'.substr($data->pkpt->area_pengawasan,0,50).'...</a>';
            })
            ->addColumn('jenis', function ($data) {
                return $data['jenis'];
            })
            ->addColumn('pkp', function ($data) {
                $pkp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`'.$data['pkp'].'`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $pkp;
            })
            ->addColumn('nota_dinas', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mt-2" onclick="buka_file(`'.$data['nota_dinas'].'`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('status', function ($data) {
                $roles =  Auth::user()->role_id;
                $sts= Status::where('id',$data->status)->first();
                $status='<span class="'.$sts->text.'">'.$sts->status.'</span>';

                return $status;
            })
            ->addColumn('action', function ($row) {
                $roles =  Auth::user()->role_id;
                $status = $row['status'];
                $sts= Status::where('id',$row->status)->first();
                $role= Role::where('id',$roles)->first();
                $crud ='
                    <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="tambah(' . $row['id'] . ')">Edit</span>
                    <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="hapus(' . $row['id'] . ')">Delete</span>
                ';
                $selesai = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                $aproval = '
                    <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                    <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                ';
                if ($status==$role->sts) {
                    if($roles==2){
                        $btn=$crud;
                    }else{
                        $btn=$aproval;
                    }
                }else{
                    $btn=$selesai;
                }
                return $btn;
            })
            ->addColumn('pesan', function ($data) {
                return $data->pesan;
            })
            ->rawColumns(['status', 'action', 'pkp', 'nota_dinas','area_pengawasannya'])
            ->make(true);
                // if ($roles == 2) {
                //     if ($status == 0 || $status == 1) {
                //         $btn ='
                //     <span class="btn btn-ghost-warning waves-effect waves-light btn-sm" onclick="edit(' . $row['id'] . ')">Edit</span>
                //     <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="hapus(' . $row['id'] . ')">Delete</span>
                // ';
                //     } else {
                //         $btn = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                //     }
                // } else  if ($roles == 3) {
                //     if ($status == 1) {
                //         $btn = '
                //     <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                //     <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                // ';
                //     } else {
                //         $btn = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                //     }
                // } else  if ($roles == 4) {
                //     if ($status == 2) {
                //         $btn = '
                //     <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                //     <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                // ';
                //     } else {
                //         $btn = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                //     }
                // } else  if ($roles == 5) {
                //     if ($status == 3) {
                //         $btn = '
                //     <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                //     <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                // ';
                //     } else {
                //         $btn = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                //     }
                // } else  if ($roles == 6) {
                //     if ($status == 4) {
                //         $btn = '
                //     <span class="btn btn-ghost-success waves-effect waves-light btn-sm" onclick="approved(' . $row['id'] . ')">Approved</span>
                //     <span class="btn btn-ghost-danger waves-effect waves-light btn-sm"  onclick="refused(' . $row['id'] . ')">Refused</span>
                // ';
                //     } else {
                //         $btn = '<span class="'.$sts->text.'"><i class="fa fa-check"></i> '.$sts->sts_keterangan.'</span>';
                //     }
                // }
                
    }

    function tampiltable(Request $request){
        $id=$request->id;
        $data=Pkpt::where('id', $id)->first();
        return view('programkerja.table', compact('data','id'));
    }

    public function store(Request $request)
    {
        error_reporting(0);
        ConvertApi::setApiSecret('8hHtmz5CYPolhdvq');
        // if ($request->id == null) {

        $request->validate([
            'id_pkpt' => 'required',
            'pkp' => 'required|mimes:pdf,xlsx|max:2048',
            'nota_dinas' => 'required|mimes:pdf,xlsx|max:2048',
        ]);
        $count=HeaderPkpt::count();
        $get= HeaderPkpt::where('id', $count)->first();
        $data = [
            'id_pkpt' => $request->id_pkpt,
            'jenis' =>$get->nomor_pkpt,
            'status' => 2,
        ];

        if ($files = $request->file('pkp')) {
            $namapkp='PKP' . date('YmdHis');
            $destinationPath = 'public/file_upload/'; // upload path
            $profileImage =$namapkp. "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $ext=explode('.',$profileImage);
            if($ext[1]=='xlsx'){
                $data['pkp'] = "$namapkp.pdf";
                // ProgramKerja::create($data);
                $result = ConvertApi::convert('pdf', ['File' =>'public/file_upload/'.$namapkp.'.xlsx']);
                $pdf=$result->getFile()->save('public/file_upload/'.$namapkp.'.pdf');
            }else{
                $data['pkp'] = $profileImage;
                // ProgramKerja::create($data);
            }
        }

        if ($files = $request->file('nota_dinas')) {
            $namanot='NotaDinas' . date('YmdHis');
            $destinationPath = 'public/file_upload/'; // upload path
            $profileImage = $namanot. "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $ext=explode('.',$profileImage);
            if($ext[1]=='xlsx'){
                $data['nota_dinas'] = "$namanot.pdf";
                // ProgramKerja::create($data);
                $result = ConvertApi::convert('pdf', ['File' =>'public/file_upload/'.$namanot.'.xlsx']);
                $pdf=$result->getFile()->save('public/file_upload/'.$namanot.'.pdf');
            }else{
                $data['nota_dinas'] = $profileImage;
                // ProgramKerja::create($data);
            }

            // $result = ConvertApi::convert('pdf', ['File' => $files]);
            // $result->getFile()->save('public/file_upload/'.$namapkp.'.pdf');
        }

        ProgramKerja::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);
        // } else {
        //     $data = ProgramKerja::where('id', $request->id)->first();
        //     $data->update([
        //         'id_pkpt' => $request->id_pkpt,
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data Berhasil Diupdate'
        //     ]);
        // }
    }

    public function destroy(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    public function modal(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('programKerja.modal', compact('data'));
    }

    public function modalRefused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('programKerja.modal_refused', compact('data'));
    }

    public function approved(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        if ($data->status == 1) {
            $data->update([
                'pesan'=>$request->pesan,
                'status' => 2,
            ]);
        } else if ($data->status == 2) {
            $data->update([
                'pesan'=>$request->pesan,
                'status' => 3,
            ]);
        } else if ($data->status == 3) {
            $data->update([
                'pesan'=>$request->pesan,
                'status' => 4,
            ]);
        } else if ($data->status == 4) {
            $data->update([
                'pesan'=>$request->pesan,
                'status' => 5,
            ]);
        }else{
            $data->update([
                'pesan'=>$request->pesan,
                'status' => 1,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disetujui'
        ]);
    }

    public function refused(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        $data->update([
            'pesan'=>$request->pesan,
            'status' => 1,
        ]);
        // if ($data->status == 2) {
        //     $data->update([
        //         'status' => 0,
        //     ]);
        // } else if ($data->status == 3) {
        //     $data->update([
        //         'status' => 2,
        //     ]);
        // } else if ($data->status == 4) {
        //     $data->update([
        //         'status' => 3,
        //     ]);
        // }
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Ditolak'
        ]);
    }
}
