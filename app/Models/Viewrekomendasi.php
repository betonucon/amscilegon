<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewrekomendasi extends Model
{
    use HasFactory;

    protected $table = 'view_rekomendasi';
    protected $guarded = ['id'];
    public $timestamps = false;
}
