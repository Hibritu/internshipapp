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
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['remote', 'on-site'])->default('remote');
            $table->text('cover_letter');
            $table->string('category')->after('user_id');
            $table->string('telegram_username');
            $table->string('portfolio_link');
            $table->string('cv_path');
            $table->enum('status', [
                'pending',
                'under_review',
                'interview_scheduled',
                'offer_sent',
                'accepted',
                'rejected',
                 'completed'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
         $table->dropColumn('category');
    }
};
