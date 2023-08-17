<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->string('status', 1); #1 aktif, 0 tidak aktif,  2 sudah aktif 3 sedang aktif tapi tidak aktif
            $table->string('statusterakhir', 1);
            $table->string('triwulanterakhir', 1);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
};
