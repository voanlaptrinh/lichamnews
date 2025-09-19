<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $metaTitle;
    public $metaDescription;

    function __construct()
    {
        $this->metaTitle = 'Lịch Âm - Lịch Vạn Niên | Xem Ngày Tốt Xấu, Tử Vi & Phong thủy';
        $this->metaDescription = ' Xem lịch âm dương, lịch vạn niên, lịch ngày tốt. Tra cứu ngày hoàng đạo, tiết khí, đổi ngày âm dương, xem tử vi, phong thủy và ngày tốt xấu chính xác.';


        // Share data với tất cả views
        view()->share('metaTitle', $this->metaTitle);
        view()->share('metaDescription', $this->metaDescription);
    }
}
