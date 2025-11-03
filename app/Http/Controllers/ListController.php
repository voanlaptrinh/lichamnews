<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{
    public function XemNgayTots()
    {
        return view('tools.list.list-xem-ngay-totxau');
    }
}
