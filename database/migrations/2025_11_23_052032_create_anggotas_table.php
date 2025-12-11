<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('nama');
            $table->string('posisi');
            $table->string('kelas');
            $table->text('pengalaman_prestasi')->nullable();
            $table->string('status')->default('aktif');
            $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggotas');
    }
};