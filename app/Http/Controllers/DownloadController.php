<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index($number)
    {
        $numLength = Str::length($number);
        
        if ($numLength == 6) return view('download');

        return redirect('/login');
    }
}
