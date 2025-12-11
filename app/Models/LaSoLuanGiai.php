<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LaSoLuanGiai extends Model
{
    use HasFactory;

    protected $table = 'la_so_luan_giai';

    protected $fillable = [
        'laso_id',
        'ho_ten',
        'ngay_sinh',
        'gio_sinh',
        'gioi_tinh',
        'nam_xem',
        'luan_giai_content',
        'api_response',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'nam_xem' => 'integer',
        'api_response' => 'array',
    ];

    /**
     * Generate unique ID for laso based on birth info only (no name)
     */
    public static function generateLasoId($ngaySinh, $gioSinh, $gioiTinh, $namXem)
    {
        // Chỉ dựa vào thông tin sinh để tạo ID (không có tên)
        $dataString = "{$ngaySinh}-{$gioSinh}-{$gioiTinh}-{$namXem}";
        return 'laso_' . abs(crc32($dataString));
    }


    /**
     * Find cached luan giai by laso_id
     */
    public static function findByLasoId($lasoId)
    {
        return static::where('laso_id', $lasoId)->first();
    }


    /**
     * Create or update luan giai cache
     */
    public static function createOrUpdateCache($data)
    {
        return static::updateOrCreate(
            ['laso_id' => $data['laso_id']],
            $data
        );
    }

    /**
     * Check if cache is still valid (optional - for future expiration logic)
     */
    public function isValid($hoursValid = 24)
    {
        return $this->created_at->diffInHours(now()) < $hoursValid;
    }
}
