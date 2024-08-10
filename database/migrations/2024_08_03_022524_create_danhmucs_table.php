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
        Schema::create('danhmucs', function (Blueprint $table) {
            $table->id();
            $table->string('hinh_anh')->nullable();
            $table->string('ten_danh_muc');
            $table->boolean('trang_thai')->nullable()->defaultTrue();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhmucs');
    }
};
