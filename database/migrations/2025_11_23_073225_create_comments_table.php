<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('nama'); // nama pengirim komentar
            $table->text('pesan'); // isi komentar
            $table->foreignId('artikel_id')->constrained('artikels')->onDelete('cascade');
           $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};