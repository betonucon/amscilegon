<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualbookController extends Controller
{
    public function index(){
        $headermenu='Manual Book';
        $menu='Preview';
        return view('manualbook.index', compact('menu','headermenu'));
    }
}
