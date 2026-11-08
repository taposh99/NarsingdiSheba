<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'নরসিংদী সেবা (Narsingdi Sheba) — সকল সেবা এক ঠিকানায়')</title>
    <meta name="description" content="নরসিংদী জেলার সবচেয়ে বড় ডিজিটাল সেবা প্ল্যাটফর্ম। রক্ত ব্যাংক, ডাক্তার, জরুরি সেবা, অনলাইন শপ, কাজের লোক, চাকরি, বাজারদর — সকল তথ্য এক সাথে।">
    <meta name="keywords" content="নরসিংদী সেবা, নরসিংদী, Narsingdi Sheba, রক্ত ব্যাংক নরসিংদী, ডাক্তার নরসিংদী, বাবুরহাট, পলাশ, শিবপুর, রায়পুরা, বেলাব, মনোহরদী">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌿</text></svg>">

    <!-- Fonts & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome 6 Free CDN for rich icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Mobile webview helper */
        html.in-app #mainHeader, html.in-app #newsTicker, html.in-app footer { display: none !important; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased pb-20 md:pb-0" x-data="{ mobileMenu: false, searchModal: false }">

    <!-- 1. Top Breaking News Ticker (Just like Lakshmipur Seba) -->
    @php
        $tickers = \App\Models\NewsTicker::where('is_active', true)->get();
    @endphp
    @if($tickers->count() > 0)
    <div id="newsTicker" class="bg-emerald-900 text-white text-xs md:text-sm py-2 px-4 shadow-sm border-b border-emerald-800 flex items-center overflow-hidden">
        <div class="flex items-center gap-1.5 font-bold shrink-0 bg-red-600 text-white px-2.5 py-0.5 rounded text-xs mr-3 animate-pulse">
            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
            সর্বশেষ
        </div>
        <div class="ticker-wrap flex-1">
            <div class="ticker-move flex items-center gap-8">
                @foreach($tickers as $ticker)
                    <span class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-circle text-[6px] text-emerald-400"></i>
                        {{ $ticker->title }}
                    </span>
                @endforeach
                @foreach($tickers as $ticker)
                    <span class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-circle text-[6px] text-emerald-400"></i>
                        {{ $ticker->title }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 2. Main Desktop & Mobile Header -->
    <header id="mainHeader" class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20 gap-4">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-gradient-to-tr from-emerald-700 to-emerald-500 flex items-center justify-center text-white text-xl md:text-2xl shadow-md">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <div>
                        <span class="text-xl md:text-2xl font-black text-emerald-800 tracking-tight block leading-tight">নরসিংদী সেবা</span>
                        <span class="text-[11px] md:text-xs text-slate-500 font-medium">সকল নাগরিক সেবা এক ঠিকানায়</span>
                    </div>
                </a>

                <!-- Search Input Bar (Desktop) -->
                <form action="{{ route('search') }}" method="GET" class="hidden md:flex flex-1 max-w-md mx-6">
                    <div class="relative w-full">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="ডাক্তার, রক্ত, জরুরি সেবা বা প্রয়োজনীয় তথ্য খুঁজুন..." 
                               class="w-full bg-slate-100 border border-slate-200 focus:border-emerald-600 focus:bg-white text-slate-800 pl-10 pr-4 py-2.5 rounded-full text-sm outline-none transition duration-150">
                        <button type="submit" class="absolute left-3.5 top-3 text-slate-400 hover:text-emerald-700">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2 md:gap-3">
                    <!-- Quick Search Icon (Mobile) -->
                    <button @click="searchModal = true" class="md:hidden w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <!-- Emergency Helpline 999 Badge -->
                    <a href="tel:999" class="hidden sm:inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs md:text-sm font-bold px-3 py-1.5 rounded-full transition">
                        <i class="fa-solid fa-phone-volume animate-bounce text-red-600"></i>
                        জরুরি হেল্প: ৯৯৯
                    </a>

                    <!-- Blood Donors Quick Button -->
                    <a href="{{ route('blood') }}" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs md:text-sm font-semibold px-3.5 py-2 rounded-full shadow-sm transition">
                        <i class="fa-solid fa-droplet text-red-300"></i>
                        <span class="hidden sm:inline">রক্তদাতা</span> খুঁজুন
                    </a>

                    <!-- Mobile Drawer Toggle -->
                    <button @click="mobileMenu = true" class="md:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Desktop Secondary Navigation Menu -->
            <nav class="hidden md:flex items-center gap-1 py-2.5 border-t border-slate-100 text-sm font-medium overflow-x-auto text-slate-700">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('home') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-house-chimney text-xs mr-1 text-emerald-600"></i> হোম
                </a>
                <a href="{{ route('emergency') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('emergency') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-kit-medical text-xs mr-1 text-red-500"></i> জরুরি সেবা
                </a>
                <a href="{{ route('blood') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('blood') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-droplet text-xs mr-1 text-red-500"></i> রক্ত ব্যাংক
                </a>
                <a href="{{ route('doctors') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('doctors') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-user-doctor text-xs mr-1 text-emerald-600"></i> ডাক্তার ও চেম্বার
                </a>
                <a href="{{ route('shop') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('shop') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-bag-shopping text-xs mr-1 text-amber-600"></i> শপ ও ঘরের খাবার
                </a>
                <a href="{{ route('workers') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('workers') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-toolbox text-xs mr-1 text-blue-600"></i> কাজের লোক
                </a>
                <a href="{{ route('jobs') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('jobs') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-briefcase text-xs mr-1 text-purple-600"></i> চাকরি
                </a>
                <a href="{{ route('prices') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('prices') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-scale-balanced text-xs mr-1 text-teal-600"></i> আজকের বাজারদর
                </a>
                <a href="{{ route('places') }}" class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-emerald-50 {{ request()->routeIs('places') ? 'text-emerald-700 bg-emerald-50 font-bold' : '' }}">
                    <i class="fa-solid fa-mountain-sun text-xs mr-1 text-emerald-600"></i> দর্শনীয় স্থান
                </a>
            </nav>
        </div>
    </header>

    <!-- Success & Alert Banners -->
    @if(session('success'))
    <div class="max-w-4xl mx-auto px-4 mt-4">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 text-sm shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Main Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-16 md:pb-12 mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-800">
                
                <!-- Col 1: About -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">নরসিংদী সেবা</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        নরসিংদী জেলার সকল নাগরিককে এক ডিজিটাল প্ল্যাটফর্মে সংযুক্ত করতে এবং জরুরি সেবা দ্রুত পৌঁছে দেওয়ার একটি উন্মুক্ত নাগরিক উদ্যোগ।
                    </p>
                    <div class="flex items-center gap-3 text-lg text-slate-400">
                        <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition"><i class="fa-brands fa-youtube"></i></a>
                        <a href="tel:01700000000" class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition"><i class="fa-solid fa-phone"></i></a>
                    </div>
                </div>

                <!-- Col 2: Upazilas -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-emerald-400"></i> উপজেলাভিত্তিক তথ্য
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('home', ['upazila' => 'narsingdi-sadar']) }}" class="hover:text-emerald-400 transition">নরসিংদী সদর</a></li>
                        <li><a href="{{ route('home', ['upazila' => 'palash']) }}" class="hover:text-emerald-400 transition">পলাশ উপজেলা</a></li>
                        <li><a href="{{ route('home', ['upazila' => 'shibpur']) }}" class="hover:text-emerald-400 transition">শিবপুর উপজেলা</a></li>
                        <li><a href="{{ route('home', ['upazila' => 'raipura']) }}" class="hover:text-emerald-400 transition">রায়পুরা উপজেলা</a></li>
                        <li><a href="{{ route('home', ['upazila' => 'belabo']) }}" class="hover:text-emerald-400 transition">বেলাব উপজেলা</a></li>
                        <li><a href="{{ route('home', ['upazila' => 'monohardi']) }}" class="hover:text-emerald-400 transition">মনোহরদী উপজেলা</a></li>
                    </ul>
                </div>

                <!-- Col 3: Key Links -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-link text-emerald-400"></i> দ্রুত লিঙ্ক
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('emergency') }}" class="hover:text-emerald-400 transition">জরুরি হেল্পলাইন নম্বর</a></li>
                        <li><a href="{{ route('blood') }}" class="hover:text-emerald-400 transition">রক্তদাতা খুঁজুন ও নিবন্ধন</a></li>
                        <li><a href="{{ route('doctors') }}" class="hover:text-emerald-400 transition">ডাক্তারদের চেম্বার ও সিরিয়াল</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:text-emerald-400 transition">বাবুরহাট শপ ও ঘরের খাবার</a></li>
                        <li><a href="{{ route('workers') }}" class="hover:text-emerald-400 transition">কারিগর ও কাজের লোক</a></li>
                        <li><a href="{{ route('jobs') }}" class="hover:text-emerald-400 transition">চাকরির বিজ্ঞপ্তি প্রকাশ</a></li>
                    </ul>
                </div>

                <!-- Col 4: Emergency Contacts -->
                <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700/60">
                    <h3 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-red-400"></i> জরুরি সহায়তা
                    </h3>
                    <div class="space-y-2 text-xs text-slate-300">
                        <div class="flex justify-between items-center py-1 border-b border-slate-700">
                            <span>জাতীয় জরুরি সেবা</span>
                            <a href="tel:999" class="font-bold text-red-400 hover:underline">৯৯৯</a>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-700">
                            <span>পুলিশ কন্ট্রোল রুম</span>
                            <a href="tel:01320092285" class="font-bold text-emerald-400 hover:underline">01320092285</a>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-700">
                            <span>ফায়ার সার্ভিস স্টেশন</span>
                            <a href="tel:01715383561" class="font-bold text-emerald-400 hover:underline">01715383561</a>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span>রেড ক্রিসেন্ট এম্বুলেন্স</span>
                            <a href="tel:01711234567" class="font-bold text-emerald-400 hover:underline">01711234567</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
                <p>© {{ date('Y') }} নরসিংদী সেবা। সকল স্বত্ব সংরক্ষিত।</p>
                <p>লক্ষ্মীপুর সেবা প্যাটার্নে নরসিংদী জেলাবাসীর জন্য নির্মিত।</p>
            </div>
        </div>
    </footer>

    <!-- 3. Mobile Sticky Bottom Navigation (App-like UX) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-200 z-50 px-2 py-1.5 shadow-lg">
        <div class="grid grid-cols-5 text-center text-[10px] font-medium text-slate-600">
            <a href="{{ route('home') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('home') ? 'text-emerald-700 font-bold' : '' }}">
                <i class="fa-solid fa-house-chimney text-base mb-0.5"></i>
                <span>হোম</span>
            </a>
            <a href="{{ route('emergency') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('emergency') ? 'text-emerald-700 font-bold' : '' }}">
                <i class="fa-solid fa-kit-medical text-base mb-0.5 text-red-500"></i>
                <span>জরুরি</span>
            </a>
            <a href="{{ route('blood') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('blood') ? 'text-emerald-700 font-bold' : '' }}">
                <i class="fa-solid fa-droplet text-base mb-0.5 text-red-600"></i>
                <span>রক্ত</span>
            </a>
            <a href="{{ route('shop') }}" class="flex flex-col items-center py-1 {{ request()->routeIs('shop') ? 'text-emerald-700 font-bold' : '' }}">
                <i class="fa-solid fa-bag-shopping text-base mb-0.5 text-amber-600"></i>
                <span>শপ</span>
            </a>
            <button @click="mobileMenu = true" class="flex flex-col items-center py-1">
                <i class="fa-solid fa-bars text-base mb-0.5"></i>
                <span>মেনু</span>
            </button>
        </div>
    </nav>

    <!-- 4. Mobile Drawer Menu -->
    <div x-show="mobileMenu" x-cloak class="relative z-50 md:hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div x-show="mobileMenu" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>
        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="mobileMenu" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-xs bg-white shadow-2xl flex flex-col">
                        
                        <!-- Drawer Header -->
                        <div class="p-4 bg-emerald-800 text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                                <span class="font-bold text-base">নরসিংদী সেবা মেনু</span>
                            </div>
                            <button @click="mobileMenu = false" class="text-white/80 hover:text-white p-1">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <!-- Drawer Links -->
                        <div class="p-4 flex-1 overflow-y-auto space-y-1 text-sm font-medium text-slate-700">
                            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-house-chimney text-emerald-600 w-5"></i> হোম
                            </a>
                            <a href="{{ route('emergency') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-kit-medical text-red-500 w-5"></i> জরুরি সেবা ডিরেক্টরি
                            </a>
                            <a href="{{ route('blood') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-droplet text-red-600 w-5"></i> রক্ত ব্যাংক ও রক্তদাতা
                            </a>
                            <a href="{{ route('doctors') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-user-doctor text-emerald-600 w-5"></i> ডাক্তার ও চেম্বার
                            </a>
                            <a href="{{ route('shop') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-bag-shopping text-amber-600 w-5"></i> বাবুরহাট শপ ও ঘরের খাবার
                            </a>
                            <a href="{{ route('workers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-toolbox text-blue-600 w-5"></i> কারিগর ও কাজের লোক
                            </a>
                            <a href="{{ route('jobs') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-briefcase text-purple-600 w-5"></i> চাকরির খবর ও বিজ্ঞপ্তি
                            </a>
                            <a href="{{ route('prices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-scale-balanced text-teal-600 w-5"></i> আজকের বাজারদর
                            </a>
                            <a href="{{ route('places') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100">
                                <i class="fa-solid fa-mountain-sun text-emerald-600 w-5"></i> দর্শনীয় স্থান ও ভ্রমণ
                            </a>

                            <div class="pt-4 border-t border-slate-100 mt-4">
                                <p class="text-xs font-bold text-slate-400 px-3 uppercase tracking-wider mb-2">উপজেলাসমূহ</p>
                                <div class="grid grid-cols-2 gap-1.5 text-xs">
                                    <a href="{{ route('home', ['upazila' => 'narsingdi-sadar']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">নরসিংদী সদর</a>
                                    <a href="{{ route('home', ['upazila' => 'palash']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">পলাশ</a>
                                    <a href="{{ route('home', ['upazila' => 'shibpur']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">শিবপুর</a>
                                    <a href="{{ route('home', ['upazila' => 'raipura']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">রায়পুরা</a>
                                    <a href="{{ route('home', ['upazila' => 'belabo']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">বেলাব</a>
                                    <a href="{{ route('home', ['upazila' => 'monohardi']) }}" class="p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700">মনোহরদী</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Search Modal (Mobile) -->
    <div x-show="searchModal" x-cloak class="relative z-50" role="dialog" aria-modal="true">
        <div x-show="searchModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
            <div x-show="searchModal" x-transition class="mx-auto max-w-xl transform rounded-2xl bg-white p-4 shadow-2xl transition-all">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="কী খুঁজতে চান? লিখুন..." class="w-full bg-slate-100 border border-slate-200 pl-10 pr-10 py-3 rounded-xl text-base outline-none focus:border-emerald-600 focus:bg-white text-slate-800" autofocus>
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-4 text-slate-400"></i>
                    <button type="button" @click="searchModal = false" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-circle-xmark text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

