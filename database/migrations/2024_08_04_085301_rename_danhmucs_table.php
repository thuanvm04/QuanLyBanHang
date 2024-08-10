<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDanhmucsTable extends Migration
{
    public function up()
    {
        Schema::rename('danhmucs', 'danh_mucs');
    }

    public function down()
    {
        Schema::rename('danh_mucs', 'danhmucs');
    }
}