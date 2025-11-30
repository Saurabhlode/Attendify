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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // assumes users table exists
            $table->string('roll_no')->nullable()->index();
            $table->year('enrollment_year')->nullable();
            $table->string('program')->nullable();
            $table->string('class')->nullable(); // optional, e.g. "FYCS"
            $table->json('meta')->nullable(); // any extra data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
