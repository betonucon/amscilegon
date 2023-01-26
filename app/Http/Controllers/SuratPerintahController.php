<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Pkpt;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use App\Models\SuratPerintah;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class SuratPerintahController extends Controller
{
    public function index()
    {
        $headermenu = 'Perencanaan';
        $menu = 'Penerbitan Surat Perintah';
        return view('suratperintah.index', compact('headermenu', 'menu'));
    }

    public function modal(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('suratperintah.modal', compact('data'));
    }

    public function download(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->get();
        $pdf = PDF::loadView('suratperintah.pdf', compact('data'));
        $pdf->set_option('isRemoteEnabled', true);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        return $pdf->stream();
    }

    public function getdata(Request $request)
    {
        error_reporting(0);
        $roles =  Auth::user()->role_id;
        $group= Auth::user()->roles->sts;
        if($roles >= 12 && $roles <= 15){
            $data='';
        }elseif($roles >= 12 && $roles <= 15){
            $data= ProgramKerja::where('role_id', Auth::user()['id'])->where('grouping',  $group)->where('status', 3)->get();
        }elseif($roles >= 8 && $roles <= 11){
            $data = ProgramKerja::where('grouping',  $group)->get();
        }else if($roles >= 4 && $roles <= 7){
            $data= ProgramKerja::where('grouping',  $group)->where('status', 3)->get();
        }else{
            $data = ProgramKerja::orderBy('id', 'desc')->get();
        }

        return Datatables::of($data)
            ->addColumn('area_pengawasannya', function ($data) {
                return '<a href="javascript:;" onclick="tampil(`' . $data->id_pkpt . '`)">' . substr($data->pkpt->area_pengawasan, 0, 50) . '...</a>';
            })
            ->addColumn('jenis', function ($data) {
                $pkpt = Pkpt::where('id', $data->id_pkpt)->first();
                return $pkpt['jenis_pengawasan'];
            })
            ->addColumn('pkp', function ($data) {
                $pkp = '<span class="btn btn-icon-only btn-outline-warning btn-sm mb-1" onclick="buka_file(`' . $data['pkp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $pkp;
            })
            ->addColumn('nota_dinas', function ($data) {
                $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mb-1" onclick="buka_file(`' . $data['nota_dinas'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                return $notaDinas;
            })
            ->addColumn('no_sp', function ($data) {
                if ($data->file_sp == null) {
                    $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mb-1" onclick="tampil_sp(`' . $data['id'] . '`)"><center>Upload</center></span>';
                } else {
                    $notaDinas = '<span class="btn btn-icon-only btn-outline-warning btn-sm mb-1" onclick="buka_file(`' . $data['file_sp'] . '`)"><center><img src="' . asset('public/img/pdf-file.png') . '" width="10px" height="10px"></center></span>';
                }

                return $notaDinas;
            })
            ->rawColumns(['no_sp', 'action', 'pkp', 'nota_dinas', 'area_pengawasannya'])
            ->make(true);
    }

    function tampiltable(Request $request)
    {
        $id = $request->id;
        $data = Pkpt::where('id', $id)->first();
        return view('programkerja.table', compact('data', 'id'));
    }

    public function store(Request $request)
    {
        error_reporting(0);

        // if ($request->id == null) {

        $request->validate([
            'id_program_kerja' => 'required',
        ]);

        $data = [
            'id_program_kerja' => $request->id_program_kerja,
            'id_pkpt' => $request->id_pkpt,
            'jenis' => $request->jenis,
            'pkp' => $request->pkp,
            'nota_dinas' => $request->nota_dinas,
        ];

        if ($files = $request->file('surat_perintah')) {
            $namapkp = 'SP' . date('YmdHis');
            $destinationPath = 'public/file_upload/'; // upload path
            $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $ext = explode('.', $profileImage);
            // if($ext[1]=='xlsx'){
            //     $data['pkp'] = "$namapkp.pdf";
            //     // ProgramKerja::create($data);
            //     $result = ConvertApi::convert('pdf', ['File' =>'public/file_upload/'.$namapkp.'.xlsx']);
            //     $pdf=$result->getFile()->save('public/file_upload/'.$namapkp.'.pdf');
            // }else{
            $data['surat_perintah'] = $profileImage;
            // ProgramKerja::create($data);
            // }
        }

        SuratPerintah::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);
        // } else {
        //     $data = SuratPerintah::where('id', $request->id)->first();
        //     $data->update([
        //         'id_pkpt' => $request->id_pkpt,
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data Berhasil Diupdate'
        //     ]);
        // }
    }
    public function update(Request $request)
    {
        error_reporting(0);

        // if ($request->id == null) {

        // $request->validate([
        //     'id_program_kerja' => 'required',
        // ]);

        $data = [
            // 'id_program_kerja' => $request->id_program_kerja,
            'id_pkpt' => $request->id_pkpt,
            // 'jenis' => $request->jenis,
            'pkp' => $request->pkp,
            'nota_dinas' => $request->nota_dinas,
        ];

        if ($files = $request->file('surat_perintah')) {
            $namapkp = 'SP' . date('YmdHis');
            $destinationPath = 'public/file_upload/'; // upload path
            $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $ext = explode('.', $profileImage);
            // if($ext[1]=='xlsx'){
            //     $data['pkp'] = "$namapkp.pdf";
            //     // ProgramKerja::create($data);
            //     $result = ConvertApi::convert('pdf', ['File' =>'public/file_upload/'.$namapkp.'.xlsx']);
            //     $pdf=$result->getFile()->save('public/file_upload/'.$namapkp.'.pdf');
            // }else{
            $data['surat_perintah'] = $profileImage;
            // ProgramKerja::create($data);
            // }
        }

        ProgramKerja::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);
        // } else {
        //     $data = SuratPerintah::where('id', $request->id)->first();
        //     $data->update([
        //         'id_pkpt' => $request->id_pkpt,
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data Berhasil Diupdate'
        //     ]);
        // }
    }

    function tampilSp(Request $request)
    {
        $data = ProgramKerja::where('id', $request->id)->first();
        return view('suratperintah.modal_sp', compact('data'));
    }

    function uploadSp(Request $request)
    {
        $request->validate([
            'no_sp' => 'required',
            'tanggal' => 'required',
            'file_sp' => 'required|mimes:pdf',
        ]);

        $data = [
            'no_sp' => $request->no_sp,
            'tanggal' => $request->tanggal,
        ];

        if ($files = $request->file('file_sp')) {
            $namapkp = 'SP' . date('YmdHis');
            $destinationPath = 'public/file_upload/'; // upload path
            $profileImage = $namapkp . "." . $files->getClientOriginalExtension();
            $files->move(public_path('/file_upload'), $profileImage);
            $data['file_sp'] = $profileImage;
        }

        ProgramKerja::where('id', $request->id)->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Disimpan'
        ]);
    }
}
