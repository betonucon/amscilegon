<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lhp extends Model
{
    use HasFactory;
    protected $table = 'lhp';
    protected $guarded = ['id'];

    public $timestamps = false;
}
