<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('la_so_luan_giai', function (Blueprint $table) {
            $table->id();
            $table->string('laso_id')->unique()->comment('ID duy nhất của lá số (hash từ thông tin cá nhân)');
            $table->string('ho_ten')->nullable()->comment('Họ tên người xem');
            $table->date('ngay_sinh')->nullable()->comment('Ngày sinh');
            $table->string('gio_sinh')->nullable()->comment('Giờ sinh');
            $table->string('gioi_tinh')->nullable()->comment('Giới tính');
            $table->integer('nam_xem')->nullable()->comment('Năm xem');
            $table->longText('luan_giai_content')->comment('Nội dung luận giải');
            $table->json('api_response')->nullable()->comment('Response nguyên bản từ API');
            $table->timestamps();

            $table->index(['laso_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('la_so_luan_giai');
    }
};
