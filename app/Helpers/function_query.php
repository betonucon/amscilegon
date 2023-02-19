<?php

use App\Models\Lhp;
use App\Models\Role;
use App\Models\TindakLanjut;

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

function countrekomedasi($group,$id)
{
    $data = TindakLanjut::where('grouping', $group)->where('parent_id', $id)->count();
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
