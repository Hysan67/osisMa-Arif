<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            if (Schema::hasColumn('aspirasis', 'no_whatsapp')) {
                $table->dropColumn('no_whatsapp');
            }
            
            // Tambah kolom untuk email tracking
            $table->string('status')->default('menunggu')->after('balasan');
            $table->boolean('email_sent')->default(false)->after('admin_id');
            $table->timestamp('email_sent_at')->nullable()->after('email_sent');
        });
    }

    public function down()
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_id', 'email_sent', 'email_sent_at']);
            // Tambah kembali jika rollback
            $table->string('no_whatsapp')->nullable();
        });
    }
};