<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Upazila;
use App\Models\EmergencyService;
use App\Models\BloodDonor;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Product;
use App\Models\Worker;
use App\Models\JobPost;
use App\Models\TouristPlace;
use App\Models\DailyPrice;
use App\Models\NewsTicker;

class NarsingdiShebaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Upazilas
        $upazilasData = [
            ['name_bn' => 'নরসিংদী সদর', 'name_en' => 'Narsingdi Sadar', 'slug' => 'narsingdi-sadar'],
            ['name_bn' => 'পলাশ', 'name_en' => 'Palash', 'slug' => 'palash'],
            ['name_bn' => 'শিবপুর', 'name_en' => 'Shibpur', 'slug' => 'shibpur'],
            ['name_bn' => 'রায়পুরা', 'name_en' => 'Raipura', 'slug' => 'raipura'],
            ['name_bn' => 'বেলাব', 'name_en' => 'Belabo', 'slug' => 'belabo'],
            ['name_bn' => 'মনোহরদী', 'name_en' => 'Monohardi', 'slug' => 'monohardi'],
        ];

        $upazilas = [];
        foreach ($upazilasData as $u) {
            $upazilas[$u['slug']] = Upazila::firstOrCreate(['slug' => $u['slug']], $u);
        }

        $sadarId = $upazilas['narsingdi-sadar']->id;
        $palashId = $upazilas['palash']->id;
        $shibpurId = $upazilas['shibpur']->id;
        $raipuraId = $upazilas['raipura']->id;
        $belaboId = $upazilas['belabo']->id;
        $monohardiId = $upazilas['monohardi']->id;

        // 2. Breaking News Tickers
        $tickers = [
            ['title' => 'নরসিংদী সেবায় আপনাকে স্বাগতম — সকল জেলাভিত্তিক নাগরিক সেবা এখন এক ঠিকানায়!', 'is_active' => true],
            ['title' => 'বাবুরহাটে চলছে শীতকালীন পাইকারি বস্ত্রমেলা ও কেনাবেচা', 'is_active' => true],
            ['title' => 'জরুরি রক্তের প্রয়োজনে রক্ত ব্যাংক বিভাগে গিয়ে সরাসরি রক্তদাতার সাথে যোগাযোগ করুন', 'is_active' => true],
            ['title' => 'উয়ারী-বটেশ্বর জাদুঘরে দর্শনার্থীদের জন্য বিশেষ আয়োজন', 'is_active' => true],
        ];
        foreach ($tickers as $t) {
            NewsTicker::create($t);
        }

        // 3. Emergency Services
        $emergencyServices = [
            ['category' => 'police', 'title' => 'নরসিংদী সদর মডেল থানা', 'phone' => '01320092285', 'alt_phone' => '029462222', 'address' => 'সদর রোড, নরসিংদী', 'upazila_id' => $sadarId, 'is_featured' => true],
            ['category' => 'police', 'title' => 'পলাশ থানা পুলিশ', 'phone' => '01320092315', 'address' => 'পলাশ বাজার, নরসিংদী', 'upazila_id' => $palashId, 'is_featured' => true],
            ['category' => 'police', 'title' => 'শিবপুর থানা', 'phone' => '01320092345', 'address' => 'শিবপুর উপজেলা চত্বর', 'upazila_id' => $shibpurId, 'is_featured' => true],
            ['category' => 'police', 'title' => 'রায়পুরা থানা', 'phone' => '01320092375', 'address' => 'রায়পুরা বাজার মোড়', 'upazila_id' => $raipuraId, 'is_featured' => true],
            ['category' => 'police', 'title' => 'বেলাব থানা', 'phone' => '01320092405', 'address' => 'বেলাব থানা রোড', 'upazila_id' => $belaboId, 'is_featured' => false],
            ['category' => 'police', 'title' => 'মনোহরদী থানা', 'phone' => '01320092435', 'address' => 'মনোহরদী বাসস্ট্যান্ড রোড', 'upazila_id' => $monohardiId, 'is_featured' => false],

            ['category' => 'fire', 'title' => 'নরসিংদী ফায়ার সার্ভিস ও সিভিল ডিফেন্স স্টেশন', 'phone' => '01715383561', 'alt_phone' => '029462223', 'address' => 'জেলখানা মোড়, নরসিংদী', 'upazila_id' => $sadarId, 'is_featured' => true],
            ['category' => 'fire', 'title' => 'পলাশ ফায়ার সার্ভিস স্টেশন', 'phone' => '01730005888', 'address' => 'ঘোড়াশাল রোড, পলাশ', 'upazila_id' => $palashId, 'is_featured' => true],
            ['category' => 'fire', 'title' => 'শিবপুর ফায়ার সার্ভিস', 'phone' => '01730005891', 'address' => 'শিবপুর বাজার', 'upazila_id' => $shibpurId, 'is_featured' => false],

            ['category' => 'ambulance', 'title' => 'নরসিংদী জেলা রেড ক্রিসেন্ট এম্বুলেন্স', 'phone' => '01711234567', 'alt_phone' => '01911234567', 'address' => 'সদর হাসপাতাল সংলগ্ন, নরসিংদী', 'upazila_id' => $sadarId, 'details' => '২৪ ঘণ্টা সার্বক্ষণিক এসি ও নন-এসি এম্বুলেন্স সেবা', 'is_featured' => true],
            ['category' => 'ambulance', 'title' => 'আলোকিত নরসিংদী ফ্রি এম্বুলেন্স সেবা', 'phone' => '01819876543', 'address' => 'ভেলানগর, নরসিংদী', 'upazila_id' => $sadarId, 'details' => 'দরিদ্র ও জরুরি রোগীদের জন্য বিশেষ অগ্রাধিকার', 'is_featured' => true],
            ['category' => 'ambulance', 'title' => 'পলাশ সেন্ট্রাল এম্বুলেন্স', 'phone' => '01720556677', 'address' => 'ঘোড়াশাল ইউরিয়া সার কারখানা সংলগ্ন', 'upazila_id' => $palashId, 'is_featured' => false],

            ['category' => 'electricity', 'title' => 'নরসিংদী পল্লী বিদ্যুৎ সমিতি-১ (মাধবদী)', 'phone' => '01769400100', 'address' => 'মাধবদী, নরসিংদী', 'upazila_id' => $sadarId, 'details' => 'বিদ্যুৎ বিভ্রাট ও অভিযোগ কেন্দ্র', 'is_featured' => true],
            ['category' => 'electricity', 'title' => 'নরসিংদী পল্লী বিদ্যুৎ সমিতি-২ (শিবপুর)', 'phone' => '01769400200', 'address' => 'শিবপুর, নরসিংদী', 'upazila_id' => $shibpurId, 'details' => 'অভিযোগ কেন্দ্র ও ২৪ ঘণ্টা হেল্পলাইন', 'is_featured' => true],

            ['category' => 'oxygen', 'title' => 'নরসিংদী অক্সিজেন ব্যাংক (রোটারী ক্লাব)', 'phone' => '01815123456', 'address' => 'স্টেডিয়াম রোড, নরসিংদী', 'upazila_id' => $sadarId, 'details' => 'জরুরি মুহূর্তে বিনামূল্যে সিলিন্ডার সরবরাহ', 'is_featured' => true],
        ];
        foreach ($emergencyServices as $es) {
            EmergencyService::create($es);
        }

        // 4. Blood Donors
        $donors = [
            ['name' => 'তানভীর আহমেদ', 'blood_group' => 'A+', 'phone' => '01711001122', 'location' => 'ভেলানগর, নরসিংদী সদর', 'upazila_id' => $sadarId, 'last_donated_at' => now()->subMonths(4)],
            ['name' => 'রাকিবুল হাসান', 'blood_group' => 'O+', 'phone' => '01822334455', 'location' => 'ঘোড়াশাল, পলাশ', 'upazila_id' => $palashId, 'last_donated_at' => now()->subMonths(5)],
            ['name' => 'মাহমুদুল করিম', 'blood_group' => 'B+', 'phone' => '01933445566', 'location' => 'শিবপুর বাসস্ট্যান্ড', 'upazila_id' => $shibpurId, 'last_donated_at' => now()->subMonths(2)],
            ['name' => 'ফাহিম ভূঁইয়া', 'blood_group' => 'AB+', 'phone' => '01644556677', 'location' => 'রায়পুরা বাজার', 'upazila_id' => $raipuraId, 'last_donated_at' => now()->subMonths(6)],
            ['name' => 'আরিফ হোসেন', 'blood_group' => 'O-', 'phone' => '01555667788', 'location' => 'বেলাব বাজার', 'upazila_id' => $belaboId, 'last_donated_at' => now()->subMonths(7)],
            ['name' => 'সাজ্জাদ মোল্লা', 'blood_group' => 'A-', 'phone' => '01766778899', 'location' => 'মনোহরদী কলেজ মোড়', 'upazila_id' => $monohardiId, 'last_donated_at' => now()->subMonths(3)],
            ['name' => 'কামরুল ইসলাম', 'blood_group' => 'B-', 'phone' => '01877889900', 'location' => 'কাউরিয়াপাড়া, নরসিংদী সদর', 'upazila_id' => $sadarId, 'last_donated_at' => now()->subMonths(8)],
            ['name' => 'জাহিদ হাসান', 'blood_group' => 'AB-', 'phone' => '01988990011', 'location' => 'মাধবদী বাজার, নরসিংদী', 'upazila_id' => $sadarId, 'last_donated_at' => now()->subMonths(5)],
            ['name' => 'শামীম ওসমান', 'blood_group' => 'O+', 'phone' => '01799001122', 'location' => 'পাঁচদোনা মোড়, নরসিংদী সদর', 'upazila_id' => $sadarId, 'last_donated_at' => now()->subMonths(1)],
            ['name' => 'মেহেদী হাসান রিয়াদ', 'blood_group' => 'A+', 'phone' => '01811223344', 'location' => 'পলাশ বাজার', 'upazila_id' => $palashId, 'last_donated_at' => now()->subMonths(4)],
        ];
        foreach ($donors as $d) {
            BloodDonor::create($d);
        }

        // 5. Doctors & Chambers
        $doctors = [
            ['name' => 'ডাঃ মোঃ রফিকুল ইসলাম', 'degree' => 'MBBS, FCPS (মেডিসিন), MACP (USA)', 'specialty' => 'মেডিসিন ও ডায়াবেটিস বিশেষজ্ঞ', 'hospital_chamber' => 'নরসিংদী প্রাইম ডায়াগনস্টিক সেন্টার, ভেলানগর', 'visiting_time' => 'প্রতিদিন বিকেল ৪টা - রাত ৯টা (শুক্রবার বন্ধ)', 'serial_phone' => '01712334455', 'fee' => '৳ ৭০০', 'upazila_id' => $sadarId],
            ['name' => 'ডাঃ নাসরিন সুলতানা', 'degree' => 'MBBS, DGO, MCPS (গাইনি ও প্রসূতি)', 'specialty' => 'গাইনি ও স্ত্রী রোগ বিশেষজ্ঞ', 'hospital_chamber' => 'মর্ডান ডায়াগনস্টিক ও হাসপাতাল, নরসিংদী সদর', 'visiting_time' => 'শনি থেকে বৃহস্পতি দুপুর ৩টা - রাত ৮টা', 'serial_phone' => '01823445566', 'fee' => '৳ ৮০০', 'upazila_id' => $sadarId],
            ['name' => 'ডাঃ কাজী তৌহিদুল ইসলাম', 'degree' => 'MBBS, DCH (শিশু), MD (Pediatrics)', 'specialty' => 'শিশু ও নবজাতক রোগ বিশেষজ্ঞ', 'hospital_chamber' => 'পলাশ সেন্ট্রাল হাসপাতাল, ঘোড়াশাল', 'visiting_time' => 'প্রতিদিন সকাল ১০টা - দুপুর ২টা ও বিকেল ৫টা - রাত ৮টা', 'serial_phone' => '01934556677', 'fee' => '৳ ৬০০', 'upazila_id' => $palashId],
            ['name' => 'ডাঃ আহমেদ শাকিল', 'degree' => 'MBBS, MS (অর্থোপেডিক সার্জারি)', 'specialty' => 'হাড়, জোড়া ও ট্রমা বিশেষজ্ঞ সার্জন', 'hospital_chamber' => 'শিবপুর ডিজিটাল হাসপাতাল ও ল্যাব', 'visiting_time' => 'রবি, মঙ্গল, বৃহস্পতি বিকেল ৫টা - রাত ৯টা', 'serial_phone' => '01645667788', 'fee' => '৳ ৭০০', 'upazila_id' => $shibpurId],
            ['name' => 'ডাঃ দেলোয়ার হোসেন', 'degree' => 'MBBS, D-CARD (জাতীয় হৃদরোগ ইনস্টিটিউট)', 'specialty' => 'হৃদরোগ ও রক্তচাপ বিশেষজ্ঞ', 'hospital_chamber' => 'নরসিংদী হার্ট ফাউন্ডেশন হাসপাতাল', 'visiting_time' => 'প্রতিদিন বিকেল ৪টা - রাত ৮টা', 'serial_phone' => '01756778899', 'fee' => '৳ ১০০০', 'upazila_id' => $sadarId],
            ['name' => 'ডাঃ সাবরিনা পারভীন', 'degree' => 'BDS, PGT (Oral & Dental Surgery)', 'specialty' => 'দাঁতের অভিজ্ঞ সার্জন ও ডেন্টাল স্পেশালিস্ট', 'hospital_chamber' => 'ডেন্টাল কেয়ার প্লাস, মনোহরদী', 'visiting_time' => 'প্রতিদিন সকাল ৯টা - দুপুর ১টা ও বিকেল ৪টা - রাত ৮টা', 'serial_phone' => '01867889900', 'fee' => '৳ ৫০০', 'upazila_id' => $monohardiId],
        ];
        foreach ($doctors as $doc) {
            Doctor::create($doc);
        }

        // 6. Hospitals
        $hospitals = [
            ['name' => 'নরসিংদী ১০০ শয্যা বিশিষ্ট জেলা হাসপাতাল', 'type' => 'সরকারি হাসপাতাল', 'phone' => '029462333', 'address' => 'ভেলানগর, নরসিংদী সদর', 'services' => '২৪ ঘণ্টা জরুরি বিভাগ, ইনডোর, আউটডোর, অপারেশন ও ল্যাব', 'upazila_id' => $sadarId],
            ['name' => 'নরসিংদী ডায়াবেটিক সমিতি ও জেনারেল হাসপাতাল', 'type' => 'বিশেষায়িত হাসপাতাল', 'phone' => '01716998877', 'address' => 'বীরপুর, নরসিংদী', 'services' => 'ডায়াবেটিস পরীক্ষা, চক্ষু ও কার্ডিয়াক সেবা', 'upazila_id' => $sadarId],
            ['name' => 'পলাশ উপজেলা স্বাস্থ্য কমপ্লেক্স', 'type' => 'সরকারি হাসপাতাল', 'phone' => '01730324888', 'address' => 'চরসিন্দুর রোড, পলাশ', 'services' => 'জরুরি প্রসূতি সেবা, টিকাদান ও বহির্বিভাগ', 'upazila_id' => $palashId],
            ['name' => 'শিবপুর উপজেলা স্বাস্থ্য কমপ্লেক্স', 'type' => 'সরকারি হাসপাতাল', 'phone' => '01730324889', 'address' => 'শিবপুর সদর, নরসিংদী', 'services' => 'জরুরি চিকিৎসা ও সরকারি এম্বুলেন্স', 'upazila_id' => $shibpurId],
            ['name' => 'রায়পুরা উপজেলা স্বাস্থ্য কমপ্লেক্স', 'type' => 'সরকারি হাসপাতাল', 'phone' => '01730324890', 'address' => 'রায়পুরা, নরসিংদী', 'services' => '২৪ ঘণ্টা জরুরি চিকিৎসা', 'upazila_id' => $raipuraId],
        ];
        foreach ($hospitals as $h) {
            Hospital::create($h);
        }

        // 7. Products (Shop & Homemade Food)
        $products = [
            [
                'title' => 'বাবুরহাটের ঐতিহ্যবাহী খাঁটি সুতি তাঁতের শাড়ি',
                'slug' => 'baburhat-pure-cotton-saree',
                'category' => 'baburhat',
                'seller_name' => 'মেসার্স নরসিংদী টেক্সটাইল, বাবুরহাট',
                'seller_phone' => '01712998811',
                'price' => 1250.00,
                'discount_price' => 1050.00,
                'unit' => 'টি',
                'description' => 'শেখেরচর বাবুরহাটের বিখ্যাত আরামদায়ক সুতি জামদানি ডিজাইনের তাঁতের শাড়ি। ১০০% প্রিমিয়াম সুতা।',
                'upazila_id' => $sadarId,
            ],
            [
                'title' => 'বাবুরহাটের পাইকারি প্রিমিয়াম থ্রি-পিস কালেকশন',
                'slug' => 'baburhat-wholesale-three-piece',
                'category' => 'baburhat',
                'seller_name' => 'রূপালী ফেব্রিক্স, শেখেরচর',
                'seller_phone' => '01819554433',
                'price' => 850.00,
                'discount_price' => 750.00,
                'unit' => 'টি',
                'description' => 'ডিজিটাল প্রিন্ট ও হাতের কাজের সুতি থ্রি-পিস। পাইকারি ও খুচরা উভয় অর্ডারে সরবরাহযোগ্য।',
                'upazila_id' => $sadarId,
            ],
            [
                'title' => 'মনোহরদীর সুমিষ্ট রসালো জিআই লটকন',
                'slug' => 'monohardi-fresh-lotkon-fruit',
                'category' => 'grocery',
                'seller_name' => 'মনোহরদী অরগানিক ফ্রুটস গার্ডেন',
                'seller_phone' => '01912443322',
                'price' => 160.00,
                'discount_price' => 140.00,
                'unit' => 'কেজি',
                'description' => 'মনোহরদীর বাগান থেকে তাজা সংগৃহীত বিখ্যাত অম্ল-মধুর স্বাদের অর্গানিক লটকন।',
                'upazila_id' => $monohardiId,
            ],
            [
                'title' => 'নরসিংদীর ঐতিহ্যবাহী অমৃতসাগর কলা (১ ডজন)',
                'slug' => 'narsingdi-amritoshagor-banana',
                'category' => 'grocery',
                'seller_name' => 'শিবপুর কলা আড়ত',
                'seller_phone' => '01611778899',
                'price' => 150.00,
                'discount_price' => 130.00,
                'unit' => 'ডজন',
                'description' => 'কেমিক্যালমুক্ত সম্পূর্ণ প্রাকৃতিকভাবে পাকা সুস্বাদু নরসিংদীর অমৃতসাগর কলা।',
                'upazila_id' => $shibpurId,
            ],
            [
                'title' => 'ঘরের তৈরি স্পেশাল গরুর কাচ্চি বিরিয়ানি (মায়ের হাতের স্বাদ)',
                'slug' => 'homemade-special-kacchi-biryani',
                'category' => 'homemade',
                'seller_name' => 'রোকেয়া’স কিচেন (হোমমেড শেফ)',
                'seller_phone' => '01755123456',
                'price' => 280.00,
                'discount_price' => 250.00,
                'unit' => 'প্লেট',
                'description' => 'খাঁটি সরিষার তেল ও বাসমতি চালের স্বাস্থ্যকর ঘরে রান্না কাচ্চি বিরিয়ানি। নরসিংদী শহরে দ্রুত হোম ডেলিভারি।',
                'upazila_id' => $sadarId,
            ],
            [
                'title' => 'হোমমেড আমের মিষ্টি আচার ও রসুনের আচার (৪০০ গ্রাম)',
                'slug' => 'homemade-mango-garlic-pickle',
                'category' => 'homemade',
                'seller_name' => 'বনলতা ফুডস, শিবপুর',
                'seller_phone' => '01844998877',
                'price' => 220.00,
                'discount_price' => 190.00,
                'unit' => 'জার',
                'description' => 'কোনোরূপ কৃত্রিম প্রিজারভেটিভ ছাড়া খাঁটি সরিষার তেলে রোদে শুকিয়ে প্রস্তুতকৃত সুস্বাদু আচার।',
                'upazila_id' => $shibpurId,
            ],
        ];
        foreach ($products as $p) {
            Product::create($p);
        }

        // 8. Workers (কাজের লোক ও কারিগর)
        $workers = [
            ['name' => 'মোঃ শাহীন মিয়া', 'category' => 'ইলেকট্রিশিয়ান', 'phone' => '01715887766', 'experience' => '১০ বছরের অভিজ্ঞতা', 'rate_info' => 'কাজ অনুযায়ী আলোচনা সাপেক্ষে', 'upazila_id' => $sadarId],
            ['name' => 'আবুল কালাম', 'category' => 'প্লাম্বার ও স্যানিটারি মিস্ত্রি', 'phone' => '01816776655', 'experience' => '৮ বছরের অভিজ্ঞতা', 'rate_info' => 'প্রতি ভিজিট ৩০০ টাকা', 'upazila_id' => $sadarId],
            ['name' => 'মোসাঃ ফিরোজা বেগম', 'category' => 'রান্নার লোক ও গৃহকর্মী', 'phone' => '01917665544', 'experience' => 'পরিচ্ছন্ন ও অভিজ্ঞ গৃহকর্মী', 'rate_info' => 'মাসিক ভিত্তিতে', 'upazila_id' => $palashId],
            ['name' => 'সুমন চন্দ্র রায়', 'category' => 'এসি ও ফ্রিজ টেকনিশিয়ান', 'phone' => '01618554433', 'experience' => 'ইনভার্টার এসি ও গ্যাস রিফিল বিশেষজ্ঞ', 'rate_info' => 'ভিজিট ৫০০ টাকা', 'upazila_id' => $sadarId],
            ['name' => 'মনির হোসেন', 'category' => 'প্রাইভেট কার ও মাইক্রো ড্রাইভার', 'phone' => '01719443322', 'experience' => '১২ বছরের নিরাপদ ড্রাইভিং রেকর্ড', 'rate_info' => 'দৈনিক বা ট্রিপ চুক্তি', 'upazila_id' => $shibpurId],
        ];
        foreach ($workers as $w) {
            Worker::create($w);
        }

        // 9. Job Posts
        $jobs = [
            [
                'title' => 'শপ ম্যানেজার ও সেলস এক্সিকিউটিভ আবশ্যক',
                'company_name' => 'নরসিংদী ফ্যাশন গ্যালারি',
                'salary' => '৳ ১৫,০০০ - ১৮,০০০',
                'deadline' => '২৫ নভেম্বর ২০২৬',
                'contact_phone' => '01711224466',
                'requirements' => 'এইচএসসি বা স্নাতক পাস। কাস্টমার ডিলিং এ পারদর্শী হতে হবে। কম্পিউটার বিলিং জানার সুবিধা অগ্রাধিকার পাবে।',
                'upazila_id' => $sadarId,
            ],
            [
                'title' => 'ডেলিভারি রাইডার (মোটরসাইকেল বা বাইসাইকেল)',
                'company_name' => 'নরসিংদী এক্সপ্রেস কুরিয়ার',
                'salary' => '৳ ১২,০০০ + কমিশন',
                'deadline' => '৩০ নভেম্বর ২০২৬',
                'contact_phone' => '01822335577',
                'requirements' => 'নরসিংদী সদর ও আশেপাশের এলাকা ভালোভাবে চেনা থাকতে হবে। নিজস্ব স্মার্টফোন আবশ্যক।',
                'upazila_id' => $sadarId,
            ],
            [
                'title' => 'কম্পিউটার অপারেটর ও ডেটা এন্ট্রি',
                'company_name' => 'ঘোড়াশাল পেপার অ্যান্ড বোর্ড মিলস',
                'salary' => '৳ ১৬,০০০ - ২০,০০০',
                'deadline' => '২৮ নভেম্বর ২০২৬',
                'contact_phone' => '01933446688',
                'requirements' => 'এমএস ওয়ার্ড, এক্সেল ও ইন্টারনেট ব্রাউজিং এ দক্ষ হতে হবে। বাংলা ও ইংরেজি টাইপিং স্পিড ভালো থাকতে হবে।',
                'upazila_id' => $palashId,
            ],
        ];
        foreach ($jobs as $j) {
            JobPost::create($j);
        }

        // 10. Tourist Places
        $places = [
            [
                'name' => 'উয়ারী-বটেশ্বর প্রত্নতাত্ত্বিক নিদর্শন ও জাদুঘর',
                'category' => 'ঐতিহাসিক',
                'location' => 'বেলাব ও শিবপুর উপজেলা, নরসিংদী',
                'description' => 'প্রায় আড়াই হাজার বছরের প্রাচীন দুর্গনগরীর স্মৃতিবাহী ঐতিহাসিক প্রত্নতাত্ত্বিক নিদর্শন। প্রাচীন রৌপ্যমুদ্রা ও পুতির জন্য বিশ্বখ্যাত।',
                'upazila_id' => $belaboId,
            ],
            [
                'name' => 'ড্রিম হলিডে পার্ক',
                'category' => 'বিনোদন পার্ক',
                'location' => 'পাঁচদোনা, ঢাকা-সিলেট মহাসড়ক সংলগ্ন, নরসিংদী সদর',
                'description' => 'পরিবার পরিজন নিয়ে আনন্দ ভ্রমণের জন্য বাংলাদেশের অন্যতম বৃহত্তম ওয়াটার পার্ক, রোলার কোস্টার ও আধুনিক রাইড সমৃদ্ধ বিনোদন কেন্দ্র।',
                'upazila_id' => $sadarId,
            ],
            [
                'name' => 'মেঘনা নদীর ভাইগিরচর রিভারভিউ ও সূর্যাস্ত ঘাট',
                'category' => 'প্রাকৃতিক',
                'location' => 'মেঘনা তীরবর্তী, নরসিংদী সদর',
                'description' => 'বিশাল মেঘনা নদীর বুকে নৌকা ভ্রমণ, নির্মল বাতাস এবং মনোমুগ্ধকর সূর্যাস্ত উপভোগের সেরা বিনোদন পয়েন্ট।',
                'upazila_id' => $sadarId,
            ],
            [
                'name' => 'ঐতিহাসিক আশ্রাফপুর মসজিদ ও পীর শাহ ইরানী (রহঃ) মাজার',
                'category' => 'ধর্মীয় ও ঐতিহাসিক',
                'location' => 'শিবপুর, নরসিংদী',
                'description' => 'সুলতানি আমলের প্রাচীন ঐতিহ্যবাহী মসজিদ ও ধর্মীয় তীর্থস্থান।',
                'upazila_id' => $shibpurId,
            ],
        ];
        foreach ($places as $pl) {
            TouristPlace::create($pl);
        }

        // 11. Daily Market Prices (আজকের বাজারদর)
        $prices = [
            ['item_name' => 'মিনিকেট চাল', 'category' => 'চাল', 'price' => '৭২', 'unit' => 'কেজি', 'trend' => 'স্থির'],
            ['item_name' => 'নাজিরশাইল চাল', 'category' => 'চাল', 'price' => '৭৮', 'unit' => 'কেজি', 'trend' => 'স্থির'],
            ['item_name' => 'সয়াবিন তেল (বোতলজাত)', 'category' => 'তেল', 'price' => '১৬৮', 'unit' => 'লিটার', 'trend' => 'কমছে'],
            ['item_name' => 'দেশি পেঁয়াজ', 'category' => 'সবজি', 'price' => '১১০', 'unit' => 'কেজি', 'trend' => 'বাড়ছে'],
            ['item_name' => 'নতুন আলু', 'category' => 'সবজি', 'price' => '৪৫', 'unit' => 'কেজি', 'trend' => 'কমছে'],
            ['item_name' => 'ব্রয়লার মুরগি', 'category' => 'মাছ ও মাংস', 'price' => '১৭৫', 'unit' => 'কেজি', 'trend' => 'স্থির'],
            ['item_name' => 'ফার্মের মুরগির ডিম', 'category' => 'মাছ ও মাংস', 'price' => '১৪৫', 'unit' => 'ডজন', 'trend' => 'কমছে'],
            ['item_name' => 'রুই মাছ (মাঝারি)', 'category' => 'মাছ ও মাংস', 'price' => '৩২০', 'unit' => 'কেজি', 'trend' => 'স্থির'],
            ['item_name' => 'খোলা চিনি', 'category' => 'মুদি', 'price' => '১৩৫', 'unit' => 'কেজি', 'trend' => 'স্থির'],
        ];
        foreach ($prices as $pr) {
            DailyPrice::create($pr);
        }
    }
}
