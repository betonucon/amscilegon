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

    public function index()
    {
        $menu = 'Dashboard';
        $pkpt = Pkpt::all();
        return view('dashboard.index', compact('menu', 'pkpt'));
    }

    public function json()
    {
        $all = RekomendasiModel::count();
        $sesuai = RekomendasiModel::where('status', 3)->count();
        $belumSesuai  = RekomendasiModel::where('status', 1)->count();
        $a = RekomendasiModel::where('status', null)->count();
        $pkpt = PKPT::count();
        $programkerja = ProgramKerja::count();
        $kertaskerja = ProgramKerja::where('file_kkp', '!=', null)->count();
        $calc = ($sesuai / $all) * 100;
        $calc2 = ($belumSesuai / $all) * 100;
        $calc3 = ($a / $all) * 100;
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
                'Program Kerja',
                'Kertas Kerja',

            ]

        ];
        return json_encode($data);
    }
}
