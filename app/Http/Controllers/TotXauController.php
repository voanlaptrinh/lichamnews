<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TotXauController extends Controller
{
     public function showForm()
    {
        // Không cần truyền dateRanges nữa
        return view('tools.tot-xau.index');
    }
}
