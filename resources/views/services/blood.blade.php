@extends('layouts.app')

@section('title', 'নরসিংদী রক্ত ব্যাংক — নাম, নম্বর ও ফিটনেস অনুযায়ী রক্তদাতা খুঁজুন | নরসিংদী সেবা')

@section('content')
<!-- Top Hero Header -->
<div class="bg-gradient-to-r from-red-700 via-rose-800 to-red-900 text-white py-8 px-4 sm:px-6 lg:px-8 shadow-sm">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-red-100 text-xs font-semibold mb-2">
                <i class="fa-solid fa-droplet text-red-300"></i> স্বেচ্ছাসেবী রক্তদান উদ্যোগ
            </div>
            <h1 class="text-2xl md:text-3xl font-black mb-1 flex items-center gap-2">
                নরসিংদী রক্ত ব্যাংক ও রক্তদাতা ডিরেক্টরি
            </h1>
            <p class="text-rose-100 text-xs md:text-sm">নরসিংদী জেলার স্বেচ্ছাসেবী রক্তদাতাদের নাম, নম্বর ও রক্তদানের ফিটনেস যাচাই করে জরুরি যোগাযোগ করুন</p>
        </div>
        <a href="#register-donor" class="inline-flex items-center gap-2 bg-white text-red-700 hover:bg-rose-50 font-bold text-xs md:text-sm px-5 py-2.5 rounded-xl shadow-md transition self-start md:self-auto">
            <i class="fa-solid fa-hand-holding-medical"></i> রক্তদাতা হিসেবে যোগ দিন
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Live Donation Fitness Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">নিবন্ধিত রক্তদাতা</p>
                <h3 class="text-xl font-black text-slate-900">{{ \App\Models\BloodDonor::toBnNumber($stats['total'] ?? 0) }} জন</h3>
                <p class="text-[11px] text-slate-400">নরসিংদী জেলার ৬টি উপজেলায়</p>
            </div>
        </div>

        <a href="{{ route('blood', array_merge(request()->query(), ['fitness' => 'fit'])) }}" class="bg-white p-4 rounded-2xl border {{ $fitness === 'fit' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200' }} shadow-xs hover:border-emerald-300 transition flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-105 transition">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="flex items-center gap-1.5">
                    <p class="text-xs text-slate-500 font-medium">রক্তদানে প্রস্তুত (ফিট)</p>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </div>
                <h3 class="text-xl font-black text-emerald-700">{{ \App\Models\BloodDonor::toBnNumber($stats['fit'] ?? 0) }} জন</h3>
                <p class="text-[11px] text-emerald-600 font-medium">৩+ মাস পার বা নতুন রক্তদাতা</p>
            </div>
        </a>

        <a href="{{ route('blood', array_merge(request()->query(), ['fitness' => 'resting'])) }}" class="bg-white p-4 rounded-2xl border {{ $fitness === 'resting' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200' }} shadow-xs hover:border-amber-300 transition flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-105 transition">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">বিশ্রামে আছেন (অপেক্ষমাণ)</p>
                <h3 class="text-xl font-black text-amber-700">{{ \App\Models\BloodDonor::toBnNumber($stats['resting'] ?? 0) }} জন</h3>
                <p class="text-[11px] text-amber-600 font-medium">৯০ দিনের মধ্যে রক্ত দিয়েছেন</p>
            </div>
        </a>
    </div>

    <!-- Main Filter, Search & Fitness Control Center -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-5">
        
        <!-- 1. Search by Name or Mobile Number Form -->
        <div>
            <form method="GET" action="{{ route('blood') }}" class="flex flex-col sm:flex-row items-center gap-2.5">
                <input type="hidden" name="group" value="{{ $group }}">
                <input type="hidden" name="upazila" value="{{ $upazilaSlug }}">
                <input type="hidden" name="fitness" value="{{ $fitness }}">
                <input type="hidden" name="sort" value="{{ $sort }}">

                <div class="relative flex-1 w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="রক্তদাতার নাম বা মোবাইল নম্বর দিয়ে খুঁজুন (যেমন: জাহিদ, শাকিল বা 017...)" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-xs md:text-sm text-slate-800 placeholder-slate-400 outline-none focus:border-red-600 focus:bg-white transition shadow-inner">
                    @if(!empty($search))
                        <a href="{{ route('blood', ['group' => $group, 'upazila' => $upazilaSlug, 'fitness' => $fitness, 'sort' => $sort]) }}" 
                           class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 text-xs px-2 py-0.5 rounded-lg bg-slate-200 transition">
                            <i class="fa-solid fa-xmark mr-1"></i>মুছুন
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold text-xs md:text-sm rounded-2xl transition shadow-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> সার্চ করুন
                </button>
            </form>
        </div>

        <!-- 2. Donation Fitness Filter Tabs -->
        <div class="pt-4 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-600">
                <span class="text-slate-400 font-semibold text-xs mr-1"><i class="fa-solid fa-heart-pulse text-red-500 mr-1"></i>রক্তদানের ফিটনেস:</span>
                <div class="flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('blood', ['search' => $search, 'group' => $group, 'upazila' => $upazilaSlug, 'fitness' => 'all', 'sort' => $sort]) }}" 
                       class="px-3.5 py-1.5 rounded-xl transition {{ $fitness === 'all' || !$fitness ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        সকল রক্তদাতা
                    </a>
                    <a href="{{ route('blood', ['search' => $search, 'group' => $group, 'upazila' => $upazilaSlug, 'fitness' => 'fit', 'sort' => $sort]) }}" 
                       class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ $fitness === 'fit' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200' }}">
                        <i class="fa-solid fa-circle-check"></i> রক্তদানে প্রস্তুত (ফিট)
                    </a>
                    <a href="{{ route('blood', ['search' => $search, 'group' => $group, 'upazila' => $upazilaSlug, 'fitness' => 'resting', 'sort' => $sort]) }}" 
                       class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ $fitness === 'resting' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200' }}">
                        <i class="fa-solid fa-hourglass-half"></i> বিশ্রামে আছেন (অপেক্ষমাণ)
                    </a>
                </div>
            </div>

            <!-- Sort By Dropdown -->
            <form method="GET" action="{{ route('blood') }}" class="flex items-center gap-2 self-start md:self-auto text-xs">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="group" value="{{ $group }}">
                <input type="hidden" name="upazila" value="{{ $upazilaSlug }}">
                <input type="hidden" name="fitness" value="{{ $fitness }}">
                <span class="text-slate-400 font-semibold whitespace-nowrap">সাজান:</span>
                <select name="sort" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 font-semibold text-xs rounded-xl px-3 py-1.5 outline-none focus:border-red-600">
                    <option value="fit_first" {{ $sort === 'fit_first' ? 'selected' : '' }}>রক্তদানে প্রস্তুত আগে</option>
                    <option value="latest_donation" {{ $sort === 'latest_donation' ? 'selected' : '' }}>সর্বশেষ রক্তদান অনুযায়ী</option>
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>নতুন নিবন্ধিত আগে</option>
                </select>
            </form>
        </div>

        <!-- 3. Blood Group Tabs -->
        <div class="pt-4 border-t border-slate-100">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">রক্তের গ্রুপ নির্বাচন করুন:</p>
            <div class="flex items-center flex-wrap gap-2">
                <a href="{{ route('blood', ['search' => $search, 'upazila' => $upazilaSlug, 'fitness' => $fitness, 'sort' => $sort]) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ !$group ? 'bg-red-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    সব রক্তগ্রুপ
                </a>
                @foreach($bloodGroups as $bg)
                    <a href="{{ route('blood', ['search' => $search, 'group' => $bg, 'upazila' => $upazilaSlug, 'fitness' => $fitness, 'sort' => $sort]) }}" 
                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $group == $bg ? 'bg-red-600 text-white shadow-xs' : 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-100' }}">
                        {{ $bg }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 4. Upazila Dropdown Filter -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <span class="text-xs text-slate-500 font-medium">উপজেলা অনুযায়ী ফিল্টার করুন:</span>
            <form method="GET" action="{{ route('blood') }}" class="flex items-center gap-2">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="group" value="{{ $group }}">
                <input type="hidden" name="fitness" value="{{ $fitness }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <select name="upazila" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-slate-700 outline-none focus:border-red-600 font-semibold">
                    <option value="">সকল উপজেলা</option>
                    @foreach($upazilas as $u)
                        <option value="{{ $u->slug }}" {{ $upazilaSlug == $u->slug ? 'selected' : '' }}>
                            {{ $u->name_bn }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

    </div>

    <!-- Active Filter Badges Bar (if any) -->
    @if(!empty($search) || !empty($group) || !empty($upazilaSlug) || ($fitness && $fitness !== 'all'))
    <div class="flex items-center gap-2 flex-wrap text-xs text-slate-500">
        <span class="font-bold">সক্রিয় ফিল্টার:</span>
        @if(!empty($search))
            <span class="bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                সার্চ: "{{ $search }}"
                <a href="{{ route('blood', ['group' => $group, 'upazila' => $upazilaSlug, 'fitness' => $fitness, 'sort' => $sort]) }}" class="text-red-500 hover:text-red-800 ml-1">×</a>
            </span>
        @endif
        @if(!empty($group))
            <span class="bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                গ্রুপ: {{ $group }}
                <a href="{{ route('blood', ['search' => $search, 'upazila' => $upazilaSlug, 'fitness' => $fitness, 'sort' => $sort]) }}" class="text-red-500 hover:text-red-800 ml-1">×</a>
            </span>
        @endif
        @if($fitness === 'fit')
            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                স্ট্যাটাস: রক্তদানে প্রস্তুত (ফিট)
                <a href="{{ route('blood', ['search' => $search, 'group' => $group, 'upazila' => $upazilaSlug, 'fitness' => 'all', 'sort' => $sort]) }}" class="text-emerald-500 hover:text-emerald-800 ml-1">×</a>
            </span>
        @elseif($fitness === 'resting')
            <span class="bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-lg font-semibold flex items-center gap-1">
                স্ট্যাটাস: বিশ্রামে আছেন
                <a href="{{ route('blood', ['search' => $search, 'group' => $group, 'upazila' => $upazilaSlug, 'fitness' => 'all', 'sort' => $sort]) }}" class="text-amber-500 hover:text-amber-800 ml-1">×</a>
            </span>
        @endif
        <a href="{{ route('blood') }}" class="text-xs text-red-600 hover:underline font-bold ml-2">সকল ফিল্টার মুছুন</a>
    </div>
    @endif

    <!-- Donors Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-14">
        @forelse($donors as $donor)
            @php
                $info = $donor->fitness_info;
            @endphp
            <div class="bg-white rounded-3xl border {{ $info['is_fit'] ? 'border-slate-200 hover:border-emerald-300' : 'border-amber-200/80 bg-gradient-to-b from-amber-50/20 to-white' }} shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <!-- Header with Blood Group & Name -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-red-600 to-rose-700 text-white font-black text-xl flex items-center justify-center shadow-xs shrink-0">
                                {{ $donor->blood_group }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $donor->name }}</h3>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                                    <span>{{ $donor->location }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Fitness Status Badge -->
                        @if($info['is_fit'])
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 shrink-0">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i> ফিট
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200 shrink-0">
                                <i class="fa-solid fa-hourglass-half text-amber-600"></i> বিশ্রাম
                            </span>
                        @endif
                    </div>

                    <!-- Details Box -->
                    <div class="space-y-2 text-xs text-slate-600 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium">উপজেলা:</span>
                            <span class="font-bold text-slate-800">{{ $donor->upazila->name_bn ?? 'নরসিংদী' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium">মোবাইল নম্বর:</span>
                            <span class="font-bold text-slate-900">{{ $donor->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-medium">সর্বশেষ রক্তদান:</span>
                            <span class="font-bold text-slate-800">
                                @if($donor->last_donated_at)
                                    {{ $donor->last_donated_at->format('d M, Y') }}
                                @else
                                    <span class="text-emerald-700">পূর্বে রক্ত দেননি (নতুন)</span>
                                @endif
                            </span>
                        </div>

                        <!-- Dynamic Fitness Calculation Description -->
                        <div class="pt-2 border-t border-slate-200/80 mt-2">
                            <div class="p-2.5 rounded-xl {{ $info['badge_class'] }} border text-xs flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <i class="{{ $info['icon'] }} text-sm"></i>
                                    <span class="font-bold">{{ $info['title'] }}</span>
                                </div>
                                <span class="text-[11px] font-semibold text-right">
                                    {{ $info['description'] }}
                                </span>
                            </div>
                        </div>

                        @if(!$info['is_fit'])
                            <p class="text-[10px] text-amber-700 bg-amber-100/50 rounded-lg p-2 text-center mt-1 font-medium leading-relaxed">
                                <i class="fa-solid fa-circle-info mr-1"></i> চিকিৎসকের পরামর্শে রক্তদানের পর ৩ মাস (৯০ দিন) শরীরকে বিশ্রাম দেওয়া আবশ্যক।
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Call & WhatsApp Action Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="tel:{{ $donor->phone }}" class="flex-1 inline-flex items-center justify-center gap-1.5 {{ $info['is_fit'] ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-slate-700 hover:bg-slate-800 text-white' }} font-bold text-xs py-2.5 rounded-xl transition shadow-xs">
                        <i class="fa-solid fa-phone"></i> সরাসরি কল করুন
                    </a>
                    <a href="https://wa.me/88{{ $donor->phone }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center text-base transition shadow-xs shrink-0" title="হোয়াটসঅ্যাপে মেসেজ পাঠান">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-solid fa-droplet-slash"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">কোনো রক্তদাতা পাওয়া যায়নি</h3>
                <p class="text-slate-500 text-xs max-w-sm mx-auto mb-4">
                    আপনার নির্বাচিত ফিল্টার বা সার্চ কিওয়ার্ড অনুযায়ী কোনো রক্তদাতা মেলেনি। অনুগ্রহ করে অন্য গ্রুপ বা উপজেলা নির্বাচন করুন।
                </p>
                <a href="{{ route('blood') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    <i class="fa-solid fa-rotate-left"></i> সকল ফিল্টার রিসেট করুন
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($donors->hasPages())
        <div class="mt-6">
            {{ $donors->links() }}
        </div>
    @endif

    <!-- Registration Section with Auto-approval notice -->
    <div id="register-donor" class="max-w-3xl mx-auto bg-gradient-to-br from-red-50 to-rose-50 border border-red-200/80 rounded-3xl p-6 sm:p-10 shadow-lg">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-red-600 text-white rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-hand-holding-medical"></i>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold mb-2 border border-emerald-200">
                <i class="fa-solid fa-bolt text-emerald-600"></i> তাৎক্ষণিক অটো-অ্যাপ্রুভ — জমার সাথে সাথেই তালিকাভুক্ত হবে
            </div>
            <h2 class="text-2xl font-black text-slate-900">স্বেচ্ছাসেবী রক্তদাতা হিসেবে নিবন্ধন করুন</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">আপনার এক ব্যাগ রক্ত বাঁচাতে পারে একটি মুমূর্ষু মানুষের জীবন</p>
        </div>

        <form action="{{ route('blood.register') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার পূর্ণ নাম *</label>
                    <input type="text" name="name" required placeholder="নাম লিখুন" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">রক্তের গ্রুপ *</label>
                    <select name="blood_group" required class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                        <option value="">গ্রুপ নির্বাচন করুন</option>
                        @foreach($bloodGroups as $bg)
                            <option value="{{ $bg }}">{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর *</label>
                    <input type="text" name="phone" required placeholder="01XXXXXXXXX" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">উপজেলা *</label>
                    <select name="upazila_id" required class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        @foreach($upazilas as $u)
                            <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">বর্তমান ঠিকানা / এলাকা *</label>
                    <input type="text" name="location" required placeholder="যেমন: ভেলানগর, নরসিংদী সদর" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সর্বশেষ রক্তদানের তারিখ (যদি থাকে)</label>
                    <input type="date" name="last_donated_at" class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-red-600">
                    <p class="text-[10px] text-slate-400 mt-1">পূর্বে রক্ত না দিয়ে থাকলে ফাঁকা রাখুন। সিস্টেম স্বয়ংক্রিয়ভাবে আপনাকে 'রক্তদানে প্রস্তুত' হিসেবে দেখাবে।</p>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black text-sm py-3.5 rounded-xl shadow-md transition duration-150 mt-2 flex items-center justify-center gap-2">
                <i class="fa-solid fa-check-circle"></i> নিবন্ধন সম্পন্ন করুন ও তালিকাভুক্ত হোন
            </button>
        </form>
    </div>

</div>
@endsection
