<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiModel extends Model
{
    use HasFactory;
    protected $table = 'uraian_rekomendasi';
    protected $guarded = ['id'];

    public $timestamps = false;
}
