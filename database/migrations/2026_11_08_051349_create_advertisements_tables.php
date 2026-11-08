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
        Schema::create('ad_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // সিলভার প্যাকেজ, গোল্ড প্যাকেজ, প্ল্যাটিনাম ভিআইপি
            $table->decimal('price', 10, 2);
            $table->string('duration')->default('৩০ দিন');
            $table->text('features'); // bullet points
            $table->string('badge')->nullable(); // যেমন: জনপ্রিয়, সেরা ডিল
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained('ad_packages')->nullOnDelete();
            $table->string('business_name');
            $table->string('client_name');
            $table->string('phone');
            $table->string('placement')->default('top_banner'); // top_banner, sidebar, feed
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('target_url')->nullable();
            $table->string('status')->default('pending'); // pending, active, expired, rejected
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('ad_packages');
    }
};
