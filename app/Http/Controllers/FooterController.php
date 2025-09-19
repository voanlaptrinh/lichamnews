<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function lienHe(){
        return view('layout.footercontent.lien-hecontent');
    }
    public function dieuKhoan(){
        return view('layout.footercontent.dieu-khoan');
    }
    public function chinhSach(){
        return view('layout.footercontent.chinh-sach');
    }
}
