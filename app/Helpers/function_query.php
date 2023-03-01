<?php

use App\Models\Lhp;
use App\Models\Role;
use App\Models\ProgramKerja;
use App\Models\TindakLanjut;
use App\Models\RekomendasiModel;
use Illuminate\Support\Facades\Auth;


function notification(){
    $user = Auth::user()->Roles->sts;
    if (Auth::user()['role_id']>= 8 && Auth::user()['role_id']<= 11) {
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 0)->count();
        $dalnis1 = ProgramKerja::where('grouping', $user)->where('status_lhp', 1)->count();
        $dalnis2 = Lhp::where('grouping', $user)->where('status', 2)->count();
        $data= $dalnis+$dalnis1+$dalnis2;
        return $data;
    }elseif(Auth::user()['role_id']>= 12 && Auth::user()['role_id']<= 15){
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 1)->count();
        $dalnis1 = ProgramKerja::where('grouping', $user)->where('status_lhp', 2)->count();
        $data= $dalnis+$dalnis1;
        return $data;
    }elseif(Auth::user()['role_id']>= 4 && Auth::user()['role_id']<= 7){
        $program = ProgramKerja::where('grouping', $user)->where('status', 4)->first();
        $lhp = Lhp::where('id_program_kerja', $program->id)->get();
        foreach ($lhp as $k) {
            $data = RekomendasiModel::where('id_lhp', $k->id)->where('status', 1)->count();
            return $data;
        }

    }elseif(Auth::user()['role_id']== 2){
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 2)->count();
        $dalnis1 = ProgramKerja::where('grouping', $user)->where('status_lhp', 3)->count();
        $data= $dalnis+$dalnis1;
        return $data;

    }
}

function ProgramKerja(){
    error_reporting(0);

    $user = Auth::user()->Roles->sts;
    if (Auth::user()['role_id']>= 8 && Auth::user()['role_id']<= 11) {
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 0)->get();
        return $dalnis;
    }elseif(Auth::user()['role_id']>= 12 && Auth::user()['role_id']<= 15){
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 1)->get();
        return $dalnis;
    }elseif(Auth::user()['role_id']== 2){
        $dalnis = ProgramKerja::where('status', 2)->get();
        return $dalnis;
    }
}

function kkp(){
    error_reporting(0);

    $user = Auth::user()->Roles->sts;
    if (Auth::user()['role_id']>= 4 && Auth::user()['role_id']<= 7) {
        $dalnis = ProgramKerja::where('grouping', $user)->where('status', 4)->get();
        return $dalnis;
    }
}

function lhp(){
    error_reporting(0);

    $user = Auth::user()->Roles->sts;
    if (Auth::user()['role_id']>= 8 && Auth::user()['role_id']<= 11) {
        $dalnis = ProgramKerja::where('grouping', $user)->where('status_lhp', 1)->get();
        return $dalnis;
    }elseif(Auth::user()['role_id']>= 12 && Auth::user()['role_id']<= 15){
        $dalnis = ProgramKerja::where('grouping', $user)->where('status_lhp', 2)->get();
        return $dalnis;
    }elseif(Auth::user()['role_id']== 2){
        $dalnis = ProgramKerja::where('status_lhp', 3)->get();
        return $dalnis;
    }
}

function tl(){
    error_reporting(0);

    $user = Auth::user()->Roles->sts;
    if (Auth::user()['role_id'] >= 4 && Auth::user()['role_id'] <= 7) {
        $program = ProgramKerja::where('grouping', $user)->where('status', 4)->first();
        $lhp = Lhp::where('id_program_kerja', $program->id)->get();
        foreach ($lhp as $k) {
            $data = RekomendasiModel::where('id_lhp', $k->id)->where('status', 1)->get();
            return $data;
        }
    }elseif (Auth::user()['role_id'] >= 8 && Auth::user()['role_id'] <= 11) {
        $program = ProgramKerja::where('grouping', $user)->where('status', 4)->first();
        $lhp = Lhp::where('id_program_kerja', $program->id)->get();
        foreach ($lhp as $k) {
            $data = RekomendasiModel::where('id_lhp', $k->id)->where('status', 2)->get();
            return $data;
        }
    }
}

function NamaRole($role)
{
    $data = Role::where('id', $role)->first();
    return $data;
}


function cekstatus($pkpt,$status)
{
    $data = Lhp::where('id_pkpt', $pkpt)->where('status', $status)->count();
    return $data;
}

function group($group,$parent)
{
    $data = Lhp::where('grouping', $group)->where('parent_id', $parent)->get();
    return $data;
}

function checkgroup($group,$parent)
{
    $data = Lhp::where('grouping', $group)->where('parent_id', $parent)->count();
    return $data;
}

function rekomedasi($group,$id)
{
    $data = Lhp::where('grouping', $group)->where('parent_id', $id)->get();
    return $data;
}

function childrekomedasi($group,$id)
{
    $data = TindakLanjut::where('grouping', $group)->where('parent_id', $id)->get();
    return $data;
}

function nomor_pkpt()
{

    $cek = App\Models\HeaderPkpt::count();
    if ($cek > 0) {
        $mst = App\Models\HeaderPkpt::orderBy('nomor_pkpt', 'Desc')->firstOrfail();
        $urutan = (int) substr($mst['nomor_pkpt'], 4, 2);
        $urutan++;
        $nomor = 'PKPT' . sprintf("%02s",  $urutan);
    } else {
        $nomor = 'PKPT' . sprintf("%02s",  1);
    }
    return $nomor;
}

function  detail_pkpt()
{
    $cek = App\Models\HeaderPkpt::orderBy('id', 'desc')->count();

    if ($cek > 0) {
        $data = App\Models\HeaderPkpt::orderBy('id', 'desc')->firstOrfail();
        return $data->nomor_pkpt;
    } else {
        return 0;
    }
}
