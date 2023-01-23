<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;
    protected $table = 'tindak_lanjut';
    protected $guarded = ['id'];

    public $timestamps = false;
}
