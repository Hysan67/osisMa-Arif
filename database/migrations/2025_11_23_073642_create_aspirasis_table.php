<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('nama')->nullable(); // nama pengirim aspirasi
            $table->string('kelas')->nullable();
            $table->string('email')->nullable();
            $table->string('judul'); // subjek aspirasi
            $table->text('pesan'); // isi aspirasi
            $table->text('balasan')->nullable(); // balasan dari admin
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // jika admin dihapus, aspirasi tetap ada
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('aspirasis');
    }
};