<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_warga');
            $table->foreign('id_warga')->references('id')->on('wargas')->onDelete('cascade');
            $table->integer('tahun');
            $table->decimal('jumlah_tagihan', 10, 2);
            $table->enum('status', ['belum dibayar', 'lunas'])->default('belum dibayar');
            $table->date('tanggal_bayar')->nullable();
            $table->integer('bulan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
