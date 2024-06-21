<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('alamat', 200);
            $table->string('no_telp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('id_rt');
            $table->foreign('id_rt')->references('id')->on('rts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};