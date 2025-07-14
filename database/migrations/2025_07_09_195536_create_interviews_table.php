<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_application_id')->constrained()->onDelete('cascade');
            $table->dateTime('interview_time');
            $table->string('interview_link')->nullable(); // Zoom/Google Meet link
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('interviews');
    }
};
