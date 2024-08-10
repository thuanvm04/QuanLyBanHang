<?php

use App\Models\Danhmuc;
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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ma_san_pham')->unique();
            $table->string('ten_san_pham');
            $table->string('hinh_anh')->nullable();
            $table->double('gia_san_pham');
            $table->double('gia_khuyen_mai');
            $table->string('mo_ta_ngan')->nullable();; 
            $table->text('noi_dung');
            $table->unsignedInteger('so_luong');
            $table->unsignedBigInteger('luot_xem')->default(0);
            $table->date('ngay_nhap');
            $table->foreignIdFor(DanhMuc::class)->constrained();
            $table->boolean('is_type')->default(true);
            $table->string('is_new')->default(true);
            $table->string('is_hot')->default(true);
            $table->string('is_hot_deal')->default(true);
            $table->string('is_show_home')->default(true);
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
