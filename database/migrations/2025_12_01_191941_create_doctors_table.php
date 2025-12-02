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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->longText('bio')->nullable();
            $table->string('phone')->unique();
            $table->integer('price');
            $table->string('hospital_name');
            $table->json('loction')->nullable();
            $table->integer('exp_years');
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();

            $table->foreignId('specialty_id')->constrained('specialties')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
