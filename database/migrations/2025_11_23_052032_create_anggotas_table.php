<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('img')->nullable(); // path gambar anggota
            $table->string('nama');
            $table->string('posisi');
            $table->text('quote');
            $table->text('pengalaman_prestasi');
            $table->string('masa_bakti');
            $table->string('status')->default('aktif'); // aktif, alumni
            $table->foreignId('bidang_id')->constrained('bidangs')->onDelete('set null'); // jika bidang dihapus, anggota tetap ada
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggotas');
    }
};