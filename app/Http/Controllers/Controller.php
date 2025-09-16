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
        $this->metaTitle = 'Lịch Âm Hôm Nay - Âm Lịch Hôm Nay - Xem Lịch Âm';
        $this->metaDescription = 'Lịch âm ' . date('Y') . ' ngày âm lịch hôm nay. Lịch vạn niên & xem ngày tốt xấu, ngày hoàng đạo. Ngày lễ âm lịch, dương lịch hôm nay. Chính xác nhất!';


        // Share data với tất cả views
        view()->share('metaTitle', $this->metaTitle);
        view()->share('metaDescription', $this->metaDescription);
    }
}
