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
        // 1. Upazilas Table
        Schema::create('upazilas', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Emergency Services Table
        Schema::create('emergency_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category'); // ambulance, police, fire, electricity, oxygen, helpline
            $table->string('title');
            $table->string('phone');
            $table->string('alt_phone')->nullable();
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // 3. Blood Donors Table
        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('blood_group', 5); // A+, A-, B+, B-, O+, O-, AB+, AB-
            $table->string('phone');
            $table->string('location');
            $table->date('last_donated_at')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        // 4. Doctors & Chambers Table
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('degree');
            $table->string('specialty'); // মেডিসিন, হৃদরোগ, গাইনি, শিশু, সার্জারি, নাক-কান-গলা, অর্থোপেডিক
            $table->string('hospital_chamber');
            $table->string('visiting_time');
            $table->string('serial_phone');
            $table->string('fee')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // 5. Hospitals Table
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('হাসপাতাল'); // হাসপাতাল, ডায়াগনস্টিক, ক্লিনিক
            $table->string('phone');
            $table->string('address');
            $table->string('services')->nullable();
            $table->timestamps();
        });

        // 6. Products / Online Shop & Homemade Food Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('category'); // homemade, baburhat, grocery, crafts
            $table->string('seller_name');
            $table->string('seller_phone');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('unit')->default('পিস');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->timestamps();
        });

        // 7. Workers / কাজের লোক ও কারিগর Table
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category'); // ইলেকট্রিশিয়ান, প্লাম্বার, এসি মিস্ত্রি, ড্রাইভার, রাজমিস্ত্রি, রান্নার লোক
            $table->string('phone');
            $table->string('experience')->nullable();
            $table->string('rate_info')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        // 8. Job Posts Table (job_posts)
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('company_name');
            $table->string('salary')->nullable();
            $table->string('deadline')->nullable();
            $table->string('contact_phone');
            $table->text('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 9. Tourist Places Table
        Schema::create('tourist_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category'); // ঐতিহাসিক, বিনোদন পার্ক, প্রাকৃতিক
            $table->string('location');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // 10. Daily Market Prices Table
        Schema::create('daily_prices', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category'); // চাল, তেল, সবজি, মাছ ও মাংস, মসলা
            $table->string('price');
            $table->string('unit');
            $table->string('trend')->default('স্থির'); // বাড়ছে, কমছে, স্থির
            $table->timestamps();
        });

        // 11. News Ticker / ব্রেকিং নিউজ
        Schema::create('news_tickers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tickers');
        Schema::dropIfExists('daily_prices');
        Schema::dropIfExists('tourist_places');
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('workers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('blood_donors');
        Schema::dropIfExists('emergency_services');
        Schema::dropIfExists('upazilas');
    }
};
