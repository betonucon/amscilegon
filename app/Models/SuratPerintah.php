<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerintah extends Model
{
    use HasFactory;

    protected $table = 'surat_perintah';
    protected $guarded = ['id'];
    public $timestamps = false;
}
