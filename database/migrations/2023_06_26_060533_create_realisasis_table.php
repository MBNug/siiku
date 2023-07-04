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
            $table->string('keterangan')->nullable()->default(null);
            $table->text('definisi');
            $table->text('cara_perhitungan');
            $table->string('target');
            $table->float('nilai')->nullable()->default(null);
            $table->string('bukti1')->nullable()->default(null);
            $table->string('bukti2')->nullable()->default(null);
            $table->string('bukti3')->nullable()->default(null);
            $table->string('bukti4')->nullable()->default(null);
            $table->string('bukti5')->nullable()->default(null);
            $table->enum('status', ['Tidak Tercapai', 'Tercapai', 'Melampaui Target'])->nullable()->default(null);
            $table->float('nilaireal')->nullable()->default(null);
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
