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
        Schema::create('targets', function (Blueprint $table) {
            $table->string('kode', 10)->primary();
            $table->string('strategi');
            $table->string('indikator_kinerja');
            $table->string('satuan');
            $table->enum('keterangan', ['Komulatif', 'Nominal', 'Rasio'])->nullable()->default(null);
            $table->text('definisi');
            $table->text('cara_perhitungan');
            $table->string('target');
            $table->string('status', 1)->default('0');
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
        Schema::dropIfExists('targets');
    }
};
