<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });

        DB::table('blogs')->whereIn('status', ['1', 'true'])->update(['status' => 'active']);
        DB::table('blogs')->whereIn('status', ['0', 'false'])->update(['status' => 'inactive']);
    }

    public function down(): void
    {
        // Preserve string statuses used by the application and the original migration.
    }
};
