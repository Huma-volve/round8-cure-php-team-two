<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->json('location')->nullable()->change();
        $table->date('bir_of_date')->nullable()->change();
        $table->boolean('status')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->json('location')->nullable(false)->change();
        $table->date('bir_of_date')->nullable(false)->change();
        $table->boolean('status')->nullable(false)->change();

        });
    }
};
