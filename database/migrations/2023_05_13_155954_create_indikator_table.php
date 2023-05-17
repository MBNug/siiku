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
        Schema::create('indikator', function (Blueprint $table) {
            $table->string('kode', 4)->primary();
            $table->string('indikator_kinerja');
            $table->string('satuan');
            $table->enum('keterangan', ['Komulatif', 'Nominal', 'Rasio'])->nullable();
            $table->text('definisi');
            $table->text('cara_perhitungan');
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
        Schema::dropIfExists('indikator');
    }
};
