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
        Schema::create('realisasis', function (Blueprint $table) {

            $table->string('kode', 10)->primary();
            $table->string('strategi');
            $table->string('indikator_kinerja');
            $table->string('satuan');
            $table->enum('keterangan', ['Komulatif', 'Nominal', 'Rasio'])->nullable()->default(null);
            $table->text('definisi');
            $table->text('cara_perhitungan');
            $table->string('target');
            // $table->string('departemen');
            $table->float('nilai');
            $table->enum('status', ['Tidak Tercapai', 'Tercapai', 'Melampaui Target']);
            $table->float('nilaireal');
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
        Schema::dropIfExists('realisasis');
    }
};