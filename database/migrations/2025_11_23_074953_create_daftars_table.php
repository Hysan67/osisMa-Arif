<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daftars', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('nama');
            $table->string('foto'); // path foto
            $table->string('kelas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('asal_sekolah');
            $table->string('nama_ortu_wali');
            $table->text('pengalaman_prestasi')->nullable();
            $table->text('penyakit_diderita')->nullable();
            $table->text('rutinitas_menghambat')->nullable();
            $table->text('tujuan');
            $table->text('harapan');
            $table->date('tanggal_ortu_wali');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // siapa yang approve
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('daftars');
    }
};