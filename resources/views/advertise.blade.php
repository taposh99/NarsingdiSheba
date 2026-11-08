@extends('layouts.app')

@section('title', 'বিজ্ঞাপন দিন — নরসিংদী সেবা বিজ্ঞাপন প্যাকেজসমূহ')

@section('content')
<div class="bg-gradient-to-r from-emerald-900 to-teal-900 text-white py-12 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-4xl mx-auto">
        <span class="bg-emerald-700/60 border border-emerald-500/40 text-emerald-200 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
            ব্যবসায়িক প্রচার ও ব্র্যান্ডিং
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black mt-3 mb-4">
            নরসিংদী সেবায় বিজ্ঞাপন দিন
        </h1>
        <p class="text-sm sm:text-base text-emerald-100 max-w-2xl mx-auto leading-relaxed">
            নরসিংদী জেলার হাজার হাজার সক্রিয় নাগরিক, ব্যবসায়ী ও প্রবাসীদের কাছে আপনার প্রতিষ্ঠান, পণ্য বা সেবার তথ্য দ্রুত পৌঁছে দিন।
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Packages Pricing Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        @foreach($packages as $pkg)
            <div class="bg-white rounded-3xl border {{ $pkg->badge ? 'border-emerald-600 shadow-xl ring-2 ring-emerald-600/20' : 'border-slate-200 shadow-md' }} p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden">
                @if($pkg->badge)
                    <div class="absolute top-0 right-0 bg-emerald-600 text-white text-[11px] font-bold px-4 py-1 rounded-bl-xl shadow-xs">
                        {{ $pkg->badge }}
                    </div>
                @endif

                <div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">{{ $pkg->name }}</h3>
                    <div class="mb-4">
                        <span class="text-3xl font-black text-emerald-800">৳ {{ number_format($pkg->price, 0) }}</span>
                        <span class="text-xs text-slate-500">/ {{ $pkg->duration }}</span>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-3 text-xs text-slate-600 mb-6">
                        @foreach(explode("\n", $pkg->features) as $line)
                            @if(trim($line))
                                <div class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-sm shrink-0"></i>
                                    <span>{{ trim($line) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <a href="#ad-form" onclick="document.getElementById('package_select').value = '{{ $pkg->id }}'" 
                   class="w-full text-center py-3.5 rounded-xl font-bold text-xs sm:text-sm transition shadow-xs
                   {{ $pkg->badge ? 'bg-emerald-700 hover:bg-emerald-800 text-white' : 'bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-800' }}">
                    এই প্যাকেজটি বেছে নিন
                </a>
            </div>
        @endforeach
    </div>

    <!-- Booking Form Section -->
    <div id="ad-form" class="max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-emerald-700 text-white rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-rectangle-ad"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900">বিজ্ঞাপনের জন্য আবেদন করুন</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">তথ্যগুলো পূরণ করুন, আমাদের প্রতিনিধি ২ ঘণ্টার মধ্যে যোগাযোগ করবেন</p>
        </div>

        <form action="{{ route('ad.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Package Selection -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিজ্ঞাপন প্যাকেজ *</label>
                <select name="package_id" id="package_select" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
                    <option value="">প্যাকেজ নির্বাচন করুন</option>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} — ৳ {{ number_format($p->price, 0) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Business & Client Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">প্রতিষ্ঠান / ব্র্যান্ডের নাম *</label>
                    <input type="text" name="business_name" required placeholder="যেমন: নরসিংদী শপিং মল" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">যোগাযোগকারীর নাম *</label>
                    <input type="text" name="client_name" required placeholder="আপনার নাম" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
                </div>
            </div>

            <!-- Phone & Website URL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর *</label>
                    <input type="text" name="phone" required placeholder="01XXXXXXXXX" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ওয়েবসাইট বা ফেসবুক পেজ লিঙ্ক (ঐচ্ছিক)</label>
                    <input type="url" name="target_url" placeholder="https://..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
                </div>
            </div>

            <!-- Ad Title -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিজ্ঞাপনের প্রধান শিরোনাম (Title)</label>
                <input type="text" name="title" placeholder="যেমন: ঈদ স্পেশাল বিশাল মূল্যছাড়!" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800">
            </div>

            <!-- Details -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিজ্ঞাপনের বিবরণ বা অফারের তথ্য</label>
                <textarea name="description" rows="3" placeholder="আপনার অফার, ঠিকানা বা বিশেষ সুবিধা সম্পর্কে লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800"></textarea>
            </div>

            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-black text-sm py-3.5 rounded-xl shadow-md transition duration-150">
                বিজ্ঞাপনের আবেদন জমা দিন
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>জরুরি বিজ্ঞাপনের জন্য সরাসরি কল করুন:</span>
            <a href="tel:01700000000" class="font-bold text-emerald-700 hover:underline">
                <i class="fa-solid fa-phone mr-1"></i>01700000000
            </a>
        </div>
    </div>

</div>
@endsection

