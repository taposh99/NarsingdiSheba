@extends('layouts.app')

@section('title', 'আমার ড্যাশবোর্ড — নরসিংদী সেবা')

@section('content')
<div class="bg-emerald-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                    {{ $user->isAdmin() ? 'bg-red-500 text-white' : ($user->isSeller() ? 'bg-amber-500 text-white' : 'bg-emerald-700 text-emerald-100') }}">
                    @if($user->isAdmin()) 👑 সুপার অ্যাডমিন
                    @elseif($user->isSeller()) 🛍️ সেলার / কিচেন
                    @else 👤 নাগরিক অ্যাকাউন্ট
                    @endif
                </span>
                <span class="text-xs text-emerald-200">{{ $user->upazila->name_bn ?? 'নরসিংদী' }}</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black">{{ $user->name }}</h1>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 bg-red-600/90 hover:bg-red-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                <i class="fa-solid fa-right-from-bracket"></i> লগআউট
            </button>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ tab: 'overview' }">
    
    <!-- 1. Super Admin Full Management Dashboard (Visible if Admin) -->
    @if($user->isAdmin())
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden">
        
        <!-- Header -->
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high text-red-600"></i> অ্যাডমিন কন্ট্রোল ও ম্যানেজমেন্ট সেন্টার
                </h2>
                <p class="text-xs text-slate-500">নরসিংদী সেবার যেকোনো তথ্য এখান থেকে সরাসরি পরিচালনা ও পরিবর্তন করুন</p>
            </div>
            <span class="self-start sm:self-auto bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                পূর্ণ নিয়ন্ত্রণ সক্রিয়
            </span>
        </div>

        <!-- Management Navigation Tabs -->
        <div class="flex items-center gap-1 p-2 bg-slate-100/80 border-b border-slate-200 overflow-x-auto text-xs font-bold text-slate-600">
            <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-chart-pie mr-1 text-emerald-600"></i> পরিসংখ্যান ও ওভারভিউ
            </button>
            <button @click="tab = 'tickers'" :class="tab === 'tickers' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-bullhorn mr-1 text-red-600"></i> ব্রেকিং নিউজ টিকার
            </button>
            <button @click="tab = 'prices'" :class="tab === 'prices' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-scale-balanced mr-1 text-teal-600"></i> আজকের বাজারদর
            </button>
            <button @click="tab = 'emergency'" :class="tab === 'emergency' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-kit-medical mr-1 text-rose-600"></i> জরুরি সেবা
            </button>
            <button @click="tab = 'doctors'" :class="tab === 'doctors' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-user-doctor mr-1 text-blue-600"></i> ডাক্তার ও চেম্বার
            </button>
            <button @click="tab = 'products'" :class="tab === 'products' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-bag-shopping mr-1 text-amber-600"></i> শপ পণ্য
            </button>
            <button @click="tab = 'jobs'" :class="tab === 'jobs' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-briefcase mr-1 text-purple-600"></i> চাকরির সার্কুলার
            </button>
            <button @click="tab = 'ads'" :class="tab === 'ads' ? 'bg-white text-emerald-800 shadow-xs' : 'hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-rectangle-ad mr-1 text-amber-500"></i> বিজ্ঞাপন ও প্যাকেজ
            </button>
        </div>

        <div class="p-6">
            
            <!-- TAB 1: OVERVIEW -->
            <div x-show="tab === 'overview'" class="space-y-6">
                @php
                    $dashVisitorStats = \App\Services\VisitorTracker::getStats();
                @endphp

                <!-- Live Traffic & Visitor Analytics Card -->
                <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white p-5 rounded-2xl border border-slate-700 shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-700/80">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-white">ওয়েবসাইট ট্রাফিক ও ভিজিটর লাইভ অ্যানালিটিক্স</h3>
                                <p class="text-[11px] text-slate-400">রিয়েল-টাইম নাগরিক ভিজিটর ট্র্যাকিং ও দৈনিক হিসাব</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-semibold w-fit">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            লাইভ ট্র্যাকিং সক্রিয়
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4">
                        <div class="bg-slate-800/60 p-3.5 rounded-xl border border-slate-700/60">
                            <div class="text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-signal text-emerald-400"></i> অনলাইনে সক্রিয়
                            </div>
                            <div class="text-2xl font-black text-emerald-400 mt-1">{{ $dashVisitorStats['online'] }} জন</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">বিগত ৫ মিনিটে সক্রিয়</div>
                        </div>
                        <div class="bg-slate-800/60 p-3.5 rounded-xl border border-slate-700/60">
                            <div class="text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-day text-teal-400"></i> আজকের ভিজিটর
                            </div>
                            <div class="text-2xl font-black text-white mt-1">{{ number_format($dashVisitorStats['today']) }} জন</div>
                            <div class="text-[10px] text-teal-300 mt-0.5">ইউনিক আইপি ভিজিটর</div>
                        </div>
                        <div class="bg-slate-800/60 p-3.5 rounded-xl border border-slate-700/60">
                            <div class="text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-users text-blue-400"></i> মোট সেবা গ্রহণকারী
                            </div>
                            <div class="text-2xl font-black text-white mt-1">{{ number_format($dashVisitorStats['total']) }}+</div>
                            <div class="text-[10px] text-blue-300 mt-0.5">সর্বমোট নাগরিক ট্রাফিক</div>
                        </div>
                        <div class="bg-slate-800/60 p-3.5 rounded-xl border border-slate-700/60">
                            <div class="text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-eye text-amber-400"></i> মোট পেজ ভিউ
                            </div>
                            <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($dashVisitorStats['total_views']) }}+</div>
                            <div class="text-[10px] text-amber-300 mt-0.5">সর্বমোট পেজ ব্রাউজিং</div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center">
                        <div class="text-3xl font-black text-slate-800">{{ $adminData['total_users'] }}</div>
                        <div class="text-xs text-slate-500 mt-1">নিবন্ধিত নাগরিক</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-2xl border border-red-100 text-center">
                        <div class="text-3xl font-black text-red-700">{{ $adminData['total_donors'] }}</div>
                        <div class="text-xs text-red-600 mt-1">রক্তদাতা সংখ্যা</div>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-2xl border border-amber-100 text-center">
                        <div class="text-3xl font-black text-amber-800">{{ $adminData['total_products'] }}</div>
                        <div class="text-xs text-amber-700 mt-1">লিস্টেড পণ্য ও খাবার</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-2xl border border-purple-100 text-center">
                        <div class="text-3xl font-black text-purple-700">{{ $adminData['total_jobs'] }}</div>
                        <div class="text-xs text-purple-600 mt-1">চাকরির বিজ্ঞপ্তি</div>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm mb-3">সম্প্রতি নিবন্ধিত ব্যবহারকারী</h3>
                    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-600 font-bold uppercase">
                                <tr>
                                    <th class="p-3">নাম</th>
                                    <th class="p-3">মোবাইল</th>
                                    <th class="p-3">ভূমিকা</th>
                                    <th class="p-3">উপজেলা</th>
                                    <th class="p-3">তারিখ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($adminData['recent_users'] as $u)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-3 font-semibold text-slate-800">{{ $u->name }}</td>
                                        <td class="p-3 text-slate-600">{{ $u->phone }}</td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                                {{ $u->role == 'admin' ? 'bg-red-100 text-red-700' : ($u->role == 'seller' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-700') }}">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-slate-600">{{ $u->upazila->name_bn ?? '-' }}</td>
                                        <td class="p-3 text-slate-400">{{ $u->created_at->format('d M, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 2: TICKERS -->
            <div x-show="tab === 'tickers'" class="space-y-6">
                <!-- Add New Ticker Form -->
                <form action="{{ route('admin.tickers.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-800 mb-2">নতুন ব্রেকিং নিউজ টিকার যোগ করুন</h3>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" name="title" required placeholder="খবরের শিরোনাম বা জরুরি ঘোষণা লিখুন..." class="flex-1 bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs outline-none focus:border-red-600">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-5 py-2 rounded-xl transition shrink-0">
                            <i class="fa-solid fa-plus"></i> টিকার যোগ করুন
                        </button>
                    </div>
                </form>

                <!-- Tickers List -->
                <div class="space-y-2">
                    @foreach($adminData['tickers'] as $tk)
                        <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2 flex-1">
                                <span class="w-2.5 h-2.5 rounded-full {{ $tk->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                <span class="{{ $tk->is_active ? 'font-medium text-slate-800' : 'line-through text-slate-400' }}">{{ $tk->title }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.tickers.toggle', $tk->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $tk->is_active ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $tk->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.tickers.delete', $tk->id) }}" method="POST" onsubmit="return confirm('মুছে ফেলতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 3: DAILY MARKET PRICES -->
            <div x-show="tab === 'prices'" class="space-y-6">
                <!-- Add Price Item -->
                <form action="{{ route('admin.prices.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-800 mb-3">নতুন পণ্য বাজারদরে যুক্ত করুন</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 text-xs">
                        <input type="text" name="item_name" required placeholder="পণ্যের নাম (যেমন: দেশি পেঁয়াজ)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="category" required placeholder="ক্যাটাগরি (যেমন: সবজি / চাল)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="price" required placeholder="বর্তমান দাম (যেমন: ৭০)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="unit" required placeholder="একক (যেমন: কেজি / ডজন)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="trend" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            <option value="স্থির">স্থির</option>
                            <option value="বাড়ছে">বাড়ছে</option>
                            <option value="কমছে">কমছে</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i> বাজারদরে সংরক্ষণ করুন
                    </button>
                </form>

                <!-- Prices List & Update Form -->
                <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-600 font-bold uppercase">
                            <tr>
                                <th class="p-3">পণ্যের নাম</th>
                                <th class="p-3">ক্যাটাগরি</th>
                                <th class="p-3">বর্তমান দাম (৳)</th>
                                <th class="p-3">ট্রেন্ড</th>
                                <th class="p-3 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($adminData['prices'] as $pr)
                                <tr class="hover:bg-slate-50">
                                    <td class="p-3 font-bold text-slate-800">{{ $pr->item_name }} ({{ $pr->unit }})</td>
                                    <td class="p-3 text-slate-500">{{ $pr->category }}</td>
                                    <td class="p-3">
                                        <form action="{{ route('admin.prices.update', $pr->id) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <input type="text" name="price" value="{{ $pr->price }}" class="w-16 bg-white border border-slate-300 rounded-lg px-2 py-1 text-xs">
                                            <select name="trend" class="bg-white border border-slate-300 rounded-lg px-2 py-1 text-xs">
                                                <option value="স্থির" {{ $pr->trend == 'স্থির' ? 'selected' : '' }}>স্থির</option>
                                                <option value="বাড়ছে" {{ $pr->trend == 'বাড়ছে' ? 'selected' : '' }}>বাড়ছে</option>
                                                <option value="কমছে" {{ $pr->trend == 'কমছে' ? 'selected' : '' }}>কমছে</option>
                                            </select>
                                            <button type="submit" class="bg-emerald-600 text-white px-2 py-1 rounded-lg text-[10px] font-bold">সেভ</button>
                                        </form>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $pr->trend == 'বাড়ছে' ? 'bg-red-100 text-red-700' : ($pr->trend == 'কমছে' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600') }}">
                                            {{ $pr->trend }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('admin.prices.delete', $pr->id) }}" method="POST" onsubmit="return confirm('মুছতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 4: EMERGENCY SERVICES -->
            <div x-show="tab === 'emergency'" class="space-y-6">
                <!-- Add Emergency Form -->
                <form action="{{ route('admin.emergency.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-800 mb-3">নতুন জরুরি সেবা নম্বর যোগ করুন</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 text-xs">
                        <input type="text" name="title" required placeholder="সেবার নাম (যেমন: বেলাব ফায়ার সার্ভিস)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="category" required class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            <option value="police">থানা / পুলিশ</option>
                            <option value="fire">ফায়ার সার্ভিস</option>
                            <option value="ambulance">অ্যাম্বুলেন্স</option>
                            <option value="electricity">পল্লী বিদ্যুৎ</option>
                            <option value="oxygen">অক্সিজেন</option>
                        </select>
                        <input type="text" name="phone" required placeholder="মোবাইল নম্বর" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="upazila_id" required class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            @foreach($upazilas as $u)
                                <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="mt-3 bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i> নম্বর যোগ করুন
                    </button>
                </form>

                <!-- Emergency List -->
                <div class="space-y-2">
                    @foreach($adminData['emergencies'] as $em)
                        <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $em->title }}</span>
                                <span class="text-slate-400 block">{{ $em->phone }} • {{ $em->upazila->name_bn ?? '' }}</span>
                            </div>
                            <form action="{{ route('admin.emergency.delete', $em->id) }}" method="POST" onsubmit="return confirm('মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 5: DOCTORS -->
            <div x-show="tab === 'doctors'" class="space-y-6">
                <!-- Add Doctor Form -->
                <form action="{{ route('admin.doctors.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-800 mb-3">নতুন বিশেষজ্ঞ ডাক্তার যোগ করুন</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                        <input type="text" name="name" required placeholder="ডাক্তারের নাম" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="specialty" required placeholder="বিশেষজ্ঞ বিভাগ (যেমন: মেডিসিন)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="degree" required placeholder="ডিগ্রি (যেমন: MBBS, FCPS)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="hospital_chamber" required placeholder="হাসপাতাল / চেম্বারের ঠিকানা" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="visiting_time" required placeholder="ভিজিটিং সময় (যেমন: প্রতিদিন বিকাল ৪টা)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="serial_phone" required placeholder="সিরিয়ালের ফোন নম্বর" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="fee" placeholder="ফি (যেমন: ৳ ৭০০)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="upazila_id" required class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            @foreach($upazilas as $u)
                                <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i> ডাক্তার যুক্ত করুন
                    </button>
                </form>

                <!-- Doctors List -->
                <div class="space-y-2">
                    @foreach($adminData['doctors'] as $doc)
                        <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $doc->name }}</span>
                                <span class="text-blue-600 font-semibold block">{{ $doc->specialty }} • {{ $doc->hospital_chamber }}</span>
                            </div>
                            <form action="{{ route('admin.doctors.delete', $doc->id) }}" method="POST" onsubmit="return confirm('মুছতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 6: PRODUCTS -->
            <div x-show="tab === 'products'" class="space-y-6">
                <!-- Add Product Form -->
                <form action="{{ route('admin.products.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    @csrf
                    <h3 class="text-sm font-bold text-slate-800 mb-3">নতুন পণ্য শপে যোগ করুন</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 text-xs">
                        <input type="text" name="title" required placeholder="পণ্যের নাম (যেমন: জামদানি শাড়ি)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="category" required class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            <option value="baburhat">বাবুরহাট বস্ত্র</option>
                            <option value="homemade">ঘরের খাবার</option>
                            <option value="grocery">ফল ও কাঁচাবাজার</option>
                        </select>
                        <input type="text" name="seller_name" required placeholder="দোকান / রাঁধুনির নাম" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="seller_phone" required placeholder="অর্ডারের ফোন নম্বর" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="number" step="0.01" name="price" required placeholder="মূল্য (৳)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="number" step="0.01" name="discount_price" placeholder="ডিসকাউন্ট মূল্য (৳)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <input type="text" name="unit" required placeholder="একক (পিস/কেজি)" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                        <select name="upazila_id" class="bg-white border border-slate-300 rounded-xl px-3 py-2 outline-none">
                            <option value="">উপজেলা (ঐচ্ছিক)</option>
                            @foreach($upazilas as $u)
                                <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="mt-3 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i> পণ্য শপে যুক্ত করুন
                    </button>
                </form>

                <!-- Products List -->
                <div class="space-y-2">
                    @foreach($adminData['products'] as $p)
                        <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $p->title }}</span>
                                <span class="text-emerald-700 font-bold block">৳ {{ number_format($p->price, 0) }} • {{ $p->seller_name }}</span>
                            </div>
                            <form action="{{ route('admin.products.delete', $p->id) }}" method="POST" onsubmit="return confirm('মুছতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 7: JOBS -->
            <div x-show="tab === 'jobs'" class="space-y-4">
                <h3 class="text-sm font-bold text-slate-800 mb-2">ইউজারদের পোস্ট করা চাকরির সার্কুলার</h3>
                <div class="space-y-2">
                    @foreach($adminData['jobs'] as $j)
                        <div class="p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $j->title }}</span>
                                <span class="text-slate-500 block">{{ $j->company_name }} • {{ $j->contact_phone }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.jobs.toggle', $j->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $j->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                        {{ $j->is_active ? 'সক্রিয়' : 'লুকায়িত' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.jobs.delete', $j->id) }}" method="POST" onsubmit="return confirm('মুছতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 8: ADVERTISEMENTS -->
            <div x-show="tab === 'ads'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-200">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">বিজ্ঞাপন ও প্রমোশন ম্যানেজমেন্ট</h3>
                        <p class="text-xs text-slate-500">প্যাকেজভিত্তিক বিজ্ঞাপনের আবেদন রিভিউ, অনুমোদন ও নিয়ন্ত্রণ</p>
                    </div>
                    <a href="{{ route('advertise') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 hover:bg-emerald-100">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> বিজ্ঞাপন পেজ দেখুন
                    </a>
                </div>

                <!-- Active Packages Overview -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($adminData['ad_packages'] as $pkg)
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">{{ $pkg->badge ?? 'প্যাকেজ' }}</span>
                            <h4 class="font-bold text-slate-800 text-sm mt-1">{{ $pkg->name }}</h4>
                            <div class="text-base font-black text-emerald-800 mt-0.5">৳ {{ number_format($pkg->price, 0) }} <span class="text-[11px] font-normal text-slate-500">/ {{ $pkg->duration }}</span></div>
                        </div>
                    @endforeach
                </div>

                <!-- Advertisements List -->
                <div>
                    <h4 class="font-bold text-xs text-slate-700 mb-3">বিজ্ঞাপন আবেদনের তালিকা</h4>
                    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-600 font-bold uppercase">
                                <tr>
                                    <th class="p-3">প্রতিষ্ঠান ও গ্রাহক</th>
                                    <th class="p-3">প্যাকেজ</th>
                                    <th class="p-3">যোগাযোগ</th>
                                    <th class="p-3">স্ট্যাটাস</th>
                                    <th class="p-3">মেয়াদ</th>
                                    <th class="p-3 text-right">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($adminData['ads'] as $ad)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-3">
                                            <span class="font-bold text-slate-800 block">{{ $ad->business_name }}</span>
                                            <span class="text-[11px] text-slate-500">{{ $ad->title ?? $ad->client_name }}</span>
                                        </td>
                                        <td class="p-3">
                                            <span class="font-semibold text-slate-700">{{ $ad->package->name ?? 'কাস্টম' }}</span>
                                        </td>
                                        <td class="p-3 text-slate-600">
                                            <a href="tel:{{ $ad->phone }}" class="text-emerald-700 font-bold hover:underline">{{ $ad->phone }}</a>
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold 
                                                {{ $ad->status == 'active' ? 'bg-emerald-100 text-emerald-800' : ($ad->status == 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">
                                                {{ $ad->status == 'active' ? 'সক্রিয়' : ($ad->status == 'pending' ? 'পেন্ডিং অনুমোদন' : 'মেয়াদোত্তীর্ণ') }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-slate-500 text-[11px]">
                                            {{ $ad->start_date ? $ad->start_date->format('d M') . ' - ' . $ad->end_date->format('d M, Y') : 'শুরু হয়নি' }}
                                        </td>
                                        <td class="p-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <form action="{{ route('admin.ads.toggle', $ad->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $ad->status == 'active' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-600 text-white' }}">
                                                        {{ $ad->status == 'active' ? 'বন্ধ করুন' : 'অনুমোদন ও সক্রিয়' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.ads.delete', $ad->id) }}" method="POST" onsubmit="return confirm('বিজ্ঞাপনটি মুছে ফেলতে চান?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-slate-400 text-xs">
                                            বর্তমানে কোনো বিজ্ঞাপনের আবেদন নেই।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endif

    <!-- 2. Blood Donor Card (If user is registered as blood donor) -->
    @if($donorProfile)
    <div class="bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-3xl p-6 sm:p-8 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-xs">
                    স্বেচ্ছাসেবী রক্তদাতা কার্ড
                </span>
                <span class="text-xs text-rose-200"><i class="fa-solid fa-droplet text-red-200"></i> গ্রুপ: {{ $donorProfile->blood_group }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black mb-1">রক্তদানের স্ট্যাটাস</h2>
            <p class="text-xs sm:text-sm text-rose-100">
                বর্তমানে আপনি: 
                @if($donorProfile->is_available)
                    <strong class="text-white underline">রক্তদানে প্রস্তুত</strong> (নাগরিকরা আপনাকে কল করতে পারবে)
                @else
                    <strong class="text-yellow-200 underline">রক্তদানে অপ্রস্তুত</strong> (তালিকায় লুকায়িত থাকবে)
                @endif
            </p>
        </div>

        <form action="{{ route('dashboard.toggle_donor') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 bg-white text-red-700 hover:bg-rose-50 font-bold text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-md transition">
                <i class="fa-solid fa-arrows-rotate"></i> 
                {{ $donorProfile->is_available ? 'স্ট্যাটাস পরিবর্তন করে অপ্রস্তুত করুন' : 'রক্তদানে প্রস্তুত স্ট্যাটাস করুন' }}
            </button>
        </form>
    </div>
    @endif

    <!-- 3. User Info & Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- User Profile Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="font-bold text-slate-800 text-base pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-emerald-600"></i> প্রোফাইল বিবরণ
            </h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">নাম:</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">মোবাইল নম্বর:</span>
                    <span class="font-semibold text-slate-800">{{ $user->phone }}</span>
                </div>
                @if($user->email)
                <div>
                    <span class="text-slate-400 block">ইমেইল:</span>
                    <span class="font-semibold text-slate-800">{{ $user->email }}</span>
                </div>
                @endif
                <div>
                    <span class="text-slate-400 block">উপজেলা:</span>
                    <span class="font-semibold text-slate-800">{{ $user->upazila->name_bn ?? 'নরসিংদী' }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs md:col-span-2 space-y-4">
            <h3 class="font-bold text-slate-800 text-base pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-500"></i> দ্রুত অ্যাকশন
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('jobs') }}#post-job" class="p-4 rounded-2xl bg-purple-50 hover:bg-purple-100 border border-purple-100 transition flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <span class="font-bold text-sm text-purple-950 block">চাকরি পোস্ট করুন</span>
                        <span class="text-[11px] text-purple-700">বিনামূল্যে কর্মী খুঁজুন</span>
                    </div>
                </a>

                @if(!$donorProfile)
                <a href="{{ route('blood') }}#register-donor" class="p-4 rounded-2xl bg-red-50 hover:bg-red-100 border border-red-100 transition flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-droplet"></i>
                    </div>
                    <div>
                        <span class="font-bold text-sm text-red-950 block">রক্তদাতা হোন</span>
                        <span class="text-[11px] text-red-700">রক্ত ব্যাংকে যুক্ত হন</span>
                    </div>
                </a>
                @else
                <a href="{{ route('blood') }}" class="p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 transition flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <span class="font-bold text-sm text-emerald-950 block">রক্ত ব্যাংক ডিরেক্টরি</span>
                        <span class="text-[11px] text-emerald-700">অন্যান্য দাতাদের তালিকা</span>
                    </div>
                </a>
                @endif
            </div>

            <!-- Posted Jobs by this user -->
            @if($myJobs->count() > 0)
            <div class="pt-4 border-t border-slate-100">
                <h4 class="font-bold text-xs text-slate-700 mb-2">আপনার পোস্ট করা চাকরি ({{ $myJobs->count() }}টি)</h4>
                <div class="space-y-2">
                    @foreach($myJobs as $job)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $job->title }}</span>
                                <span class="text-slate-400 block">{{ $job->company_name }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">সক্রিয়</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection
