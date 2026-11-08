@extends('layouts.app')

@section('title', 'নরসিংদী সেবা (Narsingdi Sheba) — সকল সেবা এক ঠিকানায়')

@section('content')

<!-- 1. Hero Section -->
<section class="relative bg-gradient-to-b from-emerald-800 to-emerald-950 text-white pt-10 pb-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-emerald-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-teal-500/20 blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-emerald-700/60 border border-emerald-500/40 text-emerald-200 text-xs md:text-sm font-semibold px-4 py-1.5 rounded-full mb-4 backdrop-blur-xs">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            নরসিংদী জেলার ডিজিটাল নাগরিক সেবা পোর্টাল
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
            নরসিংদীর সকল সেবা <br class="hidden sm:inline"> <span class="text-emerald-300">এখন আপনার হাতের মুঠোয়</span>
        </h1>
        <p class="text-sm sm:text-base text-emerald-100 max-w-2xl mx-auto mb-8 leading-relaxed">
            রক্তদাতা, জরুরি অ্যাম্বুলেন্স, পুলিশ, বিশেষজ্ঞ ডাক্তার, বাবুরহাটের পাইকারি শপ, ঘরের খাবার ও স্থানীয় চাকরির সব তথ্য এক ক্লিকে।
        </p>

        <!-- Upazila Filter Tabs -->
        <div class="flex items-center justify-center flex-wrap gap-2 mb-8">
            <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ !$selectedUpazila ? 'bg-white text-emerald-900 shadow-md' : 'bg-emerald-800/80 hover:bg-emerald-700 text-emerald-100' }}">
                সব উপজেলা
            </a>
            @foreach($upazilas as $u)
                <a href="{{ route('home', ['upazila' => $u->slug]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ $selectedUpazila == $u->slug ? 'bg-emerald-400 text-emerald-950 shadow-md' : 'bg-emerald-800/80 hover:bg-emerald-700 text-emerald-100' }}">
                    {{ $u->name_bn }}
                </a>
            @endforeach
        </div>

        <!-- Big Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('search') }}" method="GET" class="relative flex items-center shadow-2xl rounded-2xl overflow-hidden bg-white p-1.5">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-lg ml-3.5 mr-2"></i>
                <input type="text" name="q" placeholder="আজ আপনি কী খুঁজছেন? যেমন: রক্তদাতা, সদর হাসপাতাল, ডাক্তার..." 
                       class="w-full bg-transparent text-slate-800 text-sm md:text-base py-2.5 px-2 outline-none placeholder:text-slate-400">
                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition duration-150 shrink-0">
                    খুঁজুন
                </button>
            </form>
            <div class="flex items-center justify-center flex-wrap gap-2 text-xs text-emerald-200 mt-3">
                <span class="text-emerald-300 font-medium">জনপ্রিয় সন্ধান:</span>
                <a href="{{ route('blood') }}" class="hover:underline">রক্তদাতা</a> •
                <a href="{{ route('emergency', ['category' => 'ambulance']) }}" class="hover:underline">অ্যাম্বুলেন্স</a> •
                <a href="{{ route('doctors') }}" class="hover:underline">মেডিসিন ডাক্তার</a> •
                <a href="{{ route('shop', ['category' => 'baburhat']) }}" class="hover:underline">বাবুরহাট শাড়ি</a> •
                <a href="{{ route('prices') }}" class="hover:underline">বাজারদর</a>
            </div>
        </div>

        <!-- Live Statistics Counter -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 pt-8 border-t border-emerald-700/60 max-w-4xl mx-auto">
            <div class="bg-emerald-800/40 backdrop-blur-xs p-3.5 rounded-xl border border-emerald-600/30">
                <div class="text-2xl font-black text-white">{{ $stats['donors'] }}+</div>
                <div class="text-xs text-emerald-200 font-medium">নিবন্ধিত রক্তদাতা</div>
            </div>
            <div class="bg-emerald-800/40 backdrop-blur-xs p-3.5 rounded-xl border border-emerald-600/30">
                <div class="text-2xl font-black text-white">{{ $stats['doctors'] }}+</div>
                <div class="text-xs text-emerald-200 font-medium">অভিজ্ঞ ডাক্তার</div>
            </div>
            <div class="bg-emerald-800/40 backdrop-blur-xs p-3.5 rounded-xl border border-emerald-600/30">
                <div class="text-2xl font-black text-white">{{ $stats['emergency'] }}+</div>
                <div class="text-xs text-emerald-200 font-medium">জরুরি হেল্পলাইন</div>
            </div>
            <div class="bg-emerald-800/40 backdrop-blur-xs p-3.5 rounded-xl border border-emerald-600/30">
                <div class="text-2xl font-black text-white">{{ $stats['products'] }}+</div>
                <div class="text-xs text-emerald-200 font-medium">পণ্য ও দেশি খাবার</div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Services Grid (আজ কী খুঁজছেন?) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-slate-800">আজ কী খুঁজছেন?</h2>
                <p class="text-xs md:text-sm text-slate-500">প্রয়োজনীয় নাগরিক সেবা নির্বাচন করুন</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
            
            <!-- Item 1: Blood -->
            <a href="{{ route('blood') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-red-200 bg-red-50/40 hover:bg-red-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-droplet"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-red-600">রক্ত ব্যাংক</span>
                <span class="text-[11px] text-slate-500">জরুরি রক্তদাতা খুঁজুন</span>
            </a>

            <!-- Item 2: Emergency -->
            <a href="{{ route('emergency') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-kit-medical"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-emerald-700">জরুরি সেবা</span>
                <span class="text-[11px] text-slate-500">অ্যাম্বুলেন্স, পুলিশ, ফায়ার</span>
            </a>

            <!-- Item 3: Doctors -->
            <a href="{{ route('doctors') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-blue-200 bg-blue-50/40 hover:bg-blue-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-blue-600">ডাক্তার ও চেম্বার</span>
                <span class="text-[11px] text-slate-500">বিশেষজ্ঞ ও সিরিয়াল</span>
            </a>

            <!-- Item 4: Baburhat Shop -->
            <a href="{{ route('shop', ['category' => 'baburhat']) }}" class="group p-4 rounded-xl border border-slate-100 hover:border-amber-200 bg-amber-50/40 hover:bg-amber-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-store"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-amber-700">বাবুরহাট বস্ত্র শপ</span>
                <span class="text-[11px] text-slate-500">তাঁতের শাড়ি ও থ্রি-পিস</span>
            </a>

            <!-- Item 5: Homemade Food -->
            <a href="{{ route('shop', ['category' => 'homemade']) }}" class="group p-4 rounded-xl border border-slate-100 hover:border-orange-200 bg-orange-50/40 hover:bg-orange-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-orange-600">ঘরের খাবার</span>
                <span class="text-[11px] text-slate-500">মায়ের হাতের রান্না</span>
            </a>

            <!-- Item 6: Labor / Technicians -->
            <a href="{{ route('workers') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-indigo-200 bg-indigo-50/40 hover:bg-indigo-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-indigo-600">কাজের লোক</span>
                <span class="text-[11px] text-slate-500">ইলেকট্রিশিয়ান, মিস্ত্রি</span>
            </a>

            <!-- Item 7: Jobs -->
            <a href="{{ route('jobs') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-purple-200 bg-purple-50/40 hover:bg-purple-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-purple-600">চাকরির খবর</span>
                <span class="text-[11px] text-slate-500">স্থানীয় নিয়োগ বিজ্ঞপ্তি</span>
            </a>

            <!-- Item 8: Market Price -->
            <a href="{{ route('prices') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-teal-200 bg-teal-50/40 hover:bg-teal-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-teal-700">আজকের বাজারদর</span>
                <span class="text-[11px] text-slate-500">নিত্যপণ্যের দাম</span>
            </a>

            <!-- Item 9: Tourist Places -->
            <a href="{{ route('places') }}" class="group p-4 rounded-xl border border-slate-100 hover:border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-emerald-800">দর্শনীয় স্থান</span>
                <span class="text-[11px] text-slate-500">উয়ারী-বটেশ্বর, পার্ক</span>
            </a>

            <!-- Item 10: Register Donor -->
            <a href="{{ route('blood') }}#register-donor" class="group p-4 rounded-xl border border-slate-100 hover:border-rose-200 bg-rose-50/40 hover:bg-rose-50 transition duration-150 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-2.5 group-hover:scale-110 transition">
                    <i class="fa-solid fa-hand-holding-medical"></i>
                </div>
                <span class="font-bold text-sm text-slate-800 group-hover:text-rose-600">রক্তদাতা হোন</span>
                <span class="text-[11px] text-slate-500">নাম নিবন্ধন করুন</span>
            </a>

        </div>
    </div>
</section>

<!-- 3. Featured Emergency Services (এক ক্লিকে জরুরি কল) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 text-red-600 text-xs font-bold tracking-wider uppercase mb-1">
                <i class="fa-solid fa-triangle-exclamation"></i> জরুরি যোগাযোগ
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">জরুরি সেবা হেল্পলাইন</h2>
        </div>
        <a href="{{ route('emergency') }}" class="text-xs md:text-sm font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1">
            সকল জরুরি নম্বর <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($featuredEmergency as $service)
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold 
                            {{ $service->category == 'police' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $service->category == 'fire' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $service->category == 'ambulance' ? 'bg-rose-100 text-rose-700' : '' }}
                            {{ $service->category == 'electricity' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $service->category == 'oxygen' ? 'bg-teal-100 text-teal-700' : '' }}">
                            @if($service->category == 'police') থানা / পুলিশ
                            @elseif($service->category == 'fire') ফায়ার সার্ভিস
                            @elseif($service->category == 'ambulance') অ্যাম্বুলেন্স
                            @elseif($service->category == 'electricity') পল্লী বিদ্যুৎ
                            @else জরুরি সেবা
                            @endif
                        </span>
                        @if($service->upazila)
                            <span class="text-xs text-slate-500 font-medium"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $service->upazila->name_bn }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">{{ $service->title }}</h3>
                    @if($service->address)
                        <p class="text-xs text-slate-500 mb-2">{{ $service->address }}</p>
                    @endif
                    @if($service->details)
                        <p class="text-xs text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md mb-3">{{ $service->details }}</p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-sm font-bold text-slate-700">{{ $service->phone }}</span>
                    <a href="tel:{{ $service->phone }}" class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-phone"></i> কল করুন
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 4. Doctors Section (আজ চিকিৎসা কোথায় পাবেন) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 text-blue-600 text-xs font-bold tracking-wider uppercase mb-1">
                <i class="fa-solid fa-stethoscope"></i> স্বাস্থ্য সেবা
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">আজ চিকিৎসা কোথায় পাবেন</h2>
        </div>
        <a href="{{ route('doctors') }}" class="text-xs md:text-sm font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1">
            সকল ডাক্তার তালিকা <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($doctors as $doc)
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition">
                <div class="flex items-start gap-3.5 mb-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $doc->name }}</h3>
                        <p class="text-xs text-blue-700 font-semibold mt-0.5">{{ $doc->specialty }}</p>
                        <p class="text-[11px] text-slate-500 leading-snug">{{ $doc->degree }}</p>
                    </div>
                </div>

                <div class="space-y-1.5 text-xs text-slate-600 mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-hospital text-slate-400 w-4 text-center"></i>
                        <span class="font-medium text-slate-800">{{ $doc->hospital_chamber }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-clock text-slate-400 w-4 text-center"></i>
                        <span>{{ $doc->visiting_time }}</span>
                    </div>
                    @if($doc->fee)
                    <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                        <i class="fa-solid fa-tag text-emerald-500 w-4 text-center"></i>
                        <span>ফি: {{ $doc->fee }}</span>
                    </div>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-xs text-slate-500">{{ $doc->upazila->name_bn ?? '' }}</span>
                    <a href="tel:{{ $doc->serial_phone }}" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-3.5 py-1.5 rounded-lg shadow-xs transition">
                        <i class="fa-solid fa-calendar-check"></i> সিরিয়াল দিন
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 5. Shop & Homemade Food (অনলাইন শপ ও ঘরের খাবার) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 text-amber-600 text-xs font-bold tracking-wider uppercase mb-1">
                <i class="fa-solid fa-bag-shopping"></i> কেনাকাটা
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">নরসিংদীর শপ ও ঘরের খাবার</h2>
        </div>
        <a href="{{ route('shop') }}" class="text-xs md:text-sm font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1">
            সব পণ্য দেখুন <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($products as $prod)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div class="p-5">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold 
                            {{ $prod->category == 'homemade' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $prod->category == 'baburhat' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $prod->category == 'grocery' ? 'bg-green-100 text-green-700' : '' }}">
                            @if($prod->category == 'homemade') 🍲 ঘরের খাবার
                            @elseif($prod->category == 'baburhat') 🧵 বাবুরহাট বস্ত্র
                            @else 🍎 ফল ও ফলন
                            @endif
                        </span>
                        <span class="text-xs text-slate-500 font-medium">{{ $prod->upazila->name_bn ?? '' }}</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-1.5 hover:text-emerald-700 transition">
                        {{ $prod->title }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed line-clamp-2">
                        {{ $prod->description }}
                    </p>

                    <div class="text-xs text-slate-600 space-y-1 mb-4">
                        <p><i class="fa-solid fa-shop text-slate-400 mr-1.5"></i>বিক্রেতা: <span class="font-semibold text-slate-800">{{ $prod->seller_name }}</span></p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="text-lg font-black text-emerald-800">
                            ৳ {{ number_format($prod->discount_price ?? $prod->price, 0) }}
                            <span class="text-[11px] font-normal text-slate-500">/ {{ $prod->unit }}</span>
                        </div>
                        @if($prod->discount_price)
                            <div class="text-xs text-slate-400 line-through">৳ {{ number_format($prod->price, 0) }}</div>
                        @endif
                    </div>

                    <a href="tel:{{ $prod->seller_phone }}" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-phone"></i> অর্ডার কল
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 6. Skilled Workers (কাজের লোক ও কারিগর) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 text-blue-600 text-xs font-bold tracking-wider uppercase mb-1">
                <i class="fa-solid fa-screwdriver-wrench"></i> কারিগর ও সেবা
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">কাজের লোক ও দক্ষ কারিগর</h2>
        </div>
        <a href="{{ route('workers') }}" class="text-xs md:text-sm font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1">
            সব কারিগর <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($workers as $w)
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-blue-50 text-blue-700 text-[11px] font-bold px-2 py-0.5 rounded-md">
                            {{ $w->category }}
                        </span>
                        <span class="text-[11px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check text-[9px] mr-1"></i>উপলব্ধ</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">{{ $w->name }}</h3>
                    <p class="text-xs text-slate-500 mb-1"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $w->upazila->name_bn ?? '' }}</p>
                    @if($w->experience)
                        <p class="text-xs text-slate-600 mb-2"><i class="fa-solid fa-briefcase text-slate-400 mr-1"></i>{{ $w->experience }}</p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">{{ $w->rate_info }}</span>
                    <a href="tel:{{ $w->phone }}" class="inline-flex items-center gap-1 bg-slate-900 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition">
                        <i class="fa-solid fa-phone text-[10px]"></i> কল
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 7. Today's Market Prices (আজকের বাজারদর) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
    <div class="bg-gradient-to-r from-teal-900 to-emerald-900 text-white rounded-3xl p-6 md:p-8 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <span class="bg-teal-700/80 text-teal-200 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                    দৈনিক বাজার পরিস্থিতি
                </span>
                <h2 class="text-2xl md:text-3xl font-black mt-2">আজকের বাজারদর (নরসিংদী)</h2>
                <p class="text-teal-200 text-xs md:text-sm">নরসিংদীর প্রধান বাজারসমূহের খুচরা ও পাইকারি দরদাম</p>
            </div>
            <a href="{{ route('prices') }}" class="inline-flex items-center gap-2 bg-white text-emerald-900 hover:bg-emerald-50 font-bold text-xs md:text-sm px-4 py-2.5 rounded-xl transition shadow-sm self-start sm:self-auto">
                <i class="fa-solid fa-scale-balanced"></i> সম্পূর্ণ তালিকা দেখুন
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($dailyPrices as $item)
                <div class="bg-white/10 backdrop-blur-xs p-3.5 rounded-xl border border-white/10 text-center">
                    <span class="text-xs text-teal-200 block mb-1 font-medium">{{ $item->item_name }}</span>
                    <div class="text-xl font-black text-white">৳ {{ $item->price }}</div>
                    <div class="text-[10px] text-teal-300">প্রতি {{ $item->unit }}</div>
                    <div class="mt-2 inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full
                        {{ $item->trend == 'বাড়ছে' ? 'bg-red-500/20 text-red-300' : '' }}
                        {{ $item->trend == 'কমছে' ? 'bg-emerald-500/20 text-emerald-300' : '' }}
                        {{ $item->trend == 'স্থির' ? 'bg-slate-500/20 text-slate-300' : '' }}">
                        @if($item->trend == 'বাড়ছে') <i class="fa-solid fa-arrow-trend-up"></i>
                        @elseif($item->trend == 'কমছে') <i class="fa-solid fa-arrow-trend-down"></i>
                        @else <i class="fa-solid fa-minus"></i>
                        @endif
                        {{ $item->trend }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 8. Tourism & Heritage (ঘুরে দেখুন নরসিংদী) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14">
    <div class="flex items-center justify-between mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 text-emerald-700 text-xs font-bold tracking-wider uppercase mb-1">
                <i class="fa-solid fa-landmark"></i> ঐতিহ্য ও ভ্রমণ
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">ঘুরে দেখুন নরসিংদী</h2>
        </div>
        <a href="{{ route('places') }}" class="text-xs md:text-sm font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1">
            সব দর্শনীয় স্থান <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($places as $place)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition overflow-hidden">
                <div class="h-32 bg-gradient-to-tr from-emerald-800 to-teal-600 flex items-center justify-center text-white text-3xl">
                    <i class="fa-solid fa-monument"></i>
                </div>
                <div class="p-4">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 mb-1 inline-block">
                        {{ $place->category }}
                    </span>
                    <h3 class="font-bold text-slate-900 text-sm mb-1 leading-snug">{{ $place->name }}</h3>
                    <p class="text-xs text-slate-500 mb-2"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $place->location }}</p>
                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $place->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 9. Community Join / Contribution CTA -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-8">
    <div class="bg-emerald-800 text-white rounded-3xl p-8 md:p-12 text-center relative overflow-hidden shadow-xl">
        <div class="max-w-2xl mx-auto relative z-10">
            <h2 class="text-2xl md:text-4xl font-black mb-3">নরসিংদীকে গড়ি একসাথে</h2>
            <p class="text-sm md:text-base text-emerald-100 mb-8 leading-relaxed">
                আপনি কি একজন রক্তদাতা? অথবা আপনার কোনো স্থানীয় দোকান বা হোমমেড কিচেন আছে? নরসিংদী সেবা প্ল্যাটফর্মে বিনামূল্যে আপনার তথ্য যুক্ত করুন।
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('blood') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-droplet"></i> রক্তদাতা হিসেবে যোগ দিন
                </a>
                <a href="{{ route('jobs') }}" class="bg-white hover:bg-emerald-50 text-emerald-900 font-bold text-sm px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> চাকরির বিজ্ঞপ্তি পোস্ট করুন
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
