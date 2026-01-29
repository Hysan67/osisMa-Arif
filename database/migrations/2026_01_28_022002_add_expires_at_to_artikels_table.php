<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // migration file
    public function up()
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('jenis_artikel');
        });
    }

    public function down()
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};
