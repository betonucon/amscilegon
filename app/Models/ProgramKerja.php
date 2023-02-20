<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    use HasFactory;

    protected $table = 'program_kerja';
    protected $guarded = ['id'];
    public $timestamps = false;
    public function pkpt()
    {
        return $this->belongsTo('App\Models\Pkpt', 'id_pkpt', 'id');
    }
}
