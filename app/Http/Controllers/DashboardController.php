<?php

namespace App\Http\Controllers;

use App\Models\KertasKerja;
use App\Models\Lhp;
use App\Models\Pkpt;
use App\Models\ProgramKerja;
use App\Models\RekomendasiModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        if ($request->opd == "" || $request->tahun == "") {
            $pkpt = PKPT::all();
            $menu = 'Dashboard';
            $all = RekomendasiModel::count();
            $sesuai = RekomendasiModel::where('status', 3)->count();
            $belumSesuai  = RekomendasiModel::where('status', 1)->count();
            $a = RekomendasiModel::where('status', null)->count();
            $pkpt2 = PKPT::count();
            $programkerja = ProgramKerja::where('status', 4)->count();
            $kertaskerja = ProgramKerja::where('file_sp', '!=', null)->count();
            $calc = $sesuai;
            $calc2 = $belumSesuai;
            $calc3 = $a;
            $opd = "-- PILIH OPD --";
        } else {

            $pkpt = PKPT::all();
            $menu = 'Dashboard';
            $all = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->count();

            $sesuai = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', 3)->count();

            $belumSesuai  = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', 1)->count();

            $a = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', null)->count();

            $pkpt2 = PKPT::where('opd', $request->opd)->where('tahun', $request->tahun)->count();
            $programkerja = ProgramKerja::join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('program_kerja.status', 4)->count();
            $kertaskerja = ProgramKerja::join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('program_kerja.file_kkp', '!=', null)->count();
            $calc = $sesuai;
            $calc2 = $belumSesuai;
            $calc3 = $a;
            $opd = $request->opd;
        }
        return view('dashboard.index', compact('menu', 'pkpt', 'all', 'calc', 'calc2', 'calc3', 'pkpt2', 'programkerja', 'kertaskerja', 'opd'));
    }

    public function json(Request $request)
    {
        $opd = Pkpt::where('opd', $request->opd)->first();

        if ($request->opd == "" || $request->tahun == "") {
            $all = RekomendasiModel::count();
            $sesuai = RekomendasiModel::where('status', 3)->count();
            $belumSesuai  = RekomendasiModel::where('status', 1)->count();
            $a = RekomendasiModel::where('status', null)->count();
            $pkpt = PKPT::count();
            $programkerja = ProgramKerja::where('status', 4)->count();
            $kertaskerja = ProgramKerja::where('file_sp', '!=', null)->count();
            $calc = $sesuai;
            $calc2 = $belumSesuai;
            $calc3 = $a;
        } else {
            $all = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->count();

            $sesuai = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', 3)->count();

            $belumSesuai  = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', 1)->count();

            $a = RekomendasiModel::join('lhp', 'uraian_rekomendasi.id_lhp', '=', 'lhp.id')->join('program_kerja', 'lhp.id_program_kerja', '=', 'program_kerja.id')->join('pkpt', 'program_kerja.id_pkpt', '=', 'pkpt.id')->where('pkpt.opd', $request->opd)->where('pkpt.tahun', $request->tahun)->where('uraian_rekomendasi.status', null)->count();

            $pkpt = PKPT::where('opd', $request->opd)->where('tahun', $request->tahun)->count();
            $programkerja = ProgramKerja::where('id_pkpt', $opd->id)->count();
            $kertaskerja = ProgramKerja::where('id_pkpt', $opd->id)->where('file_kkp', '!=', null)->count();
            $calc = $sesuai;
            $calc2 = $belumSesuai;
            $calc3 = $a;
        }

        $data = [
            "xValues" => ['Jumlah Rekomendasi', "Sesuai", "Belum Sesuai", "Belum ditindak lanjuti"],
            "donut" => [
                $pkpt,
                $programkerja,
                $kertaskerja,

            ],
            "yValues" => [
                $all,
                $calc,
                $calc2,
                $calc3
            ],
            "barColors" => [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',

            ],
            "donutColors" => [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'

            ],
            "labels" => [
                'PKPT',
                'Surat Perintah',
                'LHP',

            ]

        ];
        return json_encode($data);
    }
}
