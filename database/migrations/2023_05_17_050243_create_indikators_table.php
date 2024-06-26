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
        Schema::create('indikators', function (Blueprint $table) {
            $table->string('kode', 6)->primary();
            $table->string('strategi');
            $table->string('indikator_kinerja');
            $table->string('satuan');
            // $table->enum('keterangan', ['kumulatif', 'nominal', 'rasio'])->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('indikators');
    }
};
