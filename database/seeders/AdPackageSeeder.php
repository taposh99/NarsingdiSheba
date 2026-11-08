<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdPackage;
use App\Models\Advertisement;

class AdPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'সিলভার প্যাকেজ (স্ট্যান্ডার্ড)',
                'price' => 1200.00,
                'duration' => '৩০ দিন',
                'badge' => 'বাজেট ফ্রেন্ডলি',
                'features' => "সাইডবার বা নির্দিষ্ট ক্যাটাগরি পেজে বিজ্ঞাপন ব্যানার\nমাসে ১টি সামাজিক যোগাযোগ মাধ্যমে স্পন্সরড পোস্ট\nসরাসরি গ্রাহকের কল ও হোয়াটসঅ্যাপ বাটন\nবিজ্ঞাপনের পারফরম্যান্স রিপোর্ট",
                'is_active' => true,
            ],
            [
                'name' => 'গোল্ড প্যাকেজ (জনপ্রিয়)',
                'price' => 2800.00,
                'duration' => '৩০ দিন',
                'badge' => 'সবচেয়ে জনপ্রিয়',
                'features' => "হোমপেজের মূল প্রিমিয়াম সেকশনে ব্যানার প্রদর্শন\nরক্ত ব্যাংক ও জরুরি সেবা পেজে হাইলাইট ব্যানার\nফেসবুক পেজে ২টি ডেডিকেটেড পোস্ট ও বুস্টিং\nসরাসরি কল, গুগল ম্যাপ ও ওয়েবসাইটের লিঙ্ক\nঅগ্রাধিকার কাস্টমার সাপোর্ট",
                'is_active' => true,
            ],
            [
                'name' => 'প্ল্যাটিনাম ভিআইপি (মেগা ব্র্যান্ডিং)',
                'price' => 5500.00,
                'duration' => '৩০ দিন',
                'badge' => 'ভিআইপি ব্র্যান্ডিং',
                'features' => "হোমপেজের একদম শীর্ষে মেগা ব্যানার পজিশন\nসর্বোচ্চ ভিউ এবং সকল পেজের হেডারে ডিসপ্লে\nব্রেকিং নিউজ টিকারে স্পেশাল স্পন্সরড টিকার\nফেসবুক পেজে প্রতি সপ্তাহে বিশেষ প্রমোশনাল পোস্ট\nভিআইপি ভেরিফাইড শপ/বিজনেস ব্যাজ",
                'is_active' => true,
            ],
        ];

        foreach ($packages as $pkg) {
            $createdPkg = AdPackage::create($pkg);

            // Add demo active ad for Gold Package
            if ($pkg['name'] === 'গোল্ড প্যাকেজ (জনপ্রিয়)') {
                Advertisement::create([
                    'package_id' => $createdPkg->id,
                    'business_name' => 'নরসিংদী ড্রিম ফ্যাশন ও শাড়ি মেলা',
                    'client_name' => 'মোঃ মোস্তফা কামাল',
                    'phone' => '01712998877',
                    'placement' => 'top_banner',
                    'title' => 'বাবুরহাটের পাইকারি মূল্যে খাঁটি সুতি শাড়ি ও থ্রি-পিস',
                    'description' => 'পাইকারি ও খুচরা কেনাকাটায় বিশেষ ২০% মূল্যছাড়! সরাসরি বাবুরহাটের শোরুম থেকে সংগ্রহ করুন।',
                    'target_url' => 'http://127.0.0.1:8000/shop?category=baburhat',
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays(30),
                ]);
            }
        }
    }
}

