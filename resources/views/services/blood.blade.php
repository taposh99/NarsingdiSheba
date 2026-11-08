@extends('layouts.app')

@section('title', 'নরসিংদী রক্ত ব্যাংক — রক্তদাতা খুঁজুন ও নিবন্ধন করুন | নরসিংদী সেবা')

@section('content')
<div class="bg-gradient-to-r from-red-700 to-rose-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
                <i class="fa-solid fa-droplet text-red-300"></i> নরসিংদী রক্ত ব্যাংক ও রক্তদাতা তালিকা
            </h1>
            <p class="text-rose-100 text-xs md:text-sm">নরসিংদী জেলার স্বেচ্ছাসেবী রক্তদাতাদের সরাসরি যোগাযোগের প্ল্যাটফর্ম</p>
        </div>
        <a href="#register-donor" class="inline-flex items-center gap-2 bg-white text-red-700 hover:bg-rose-50 font-bold text-xs md:text-sm px-5 py-2.5 rounded-xl shadow-md transition self-start md:self-auto">
            <i class="fa-solid fa-hand-holding-medical"></i> রক্তদাতা হিসেবে যোগ দিন
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Blood Group Tabs & Upazila Filter -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs mb-8">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">রক্তের গ্রুপ নির্বাচন করুন:</p>
        
        <div class="flex items-center flex-wrap gap-2 mb-4">
            <a href="{{ route('blood', ['upazila' => $upazilaSlug]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$group ? 'bg-red-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সব রক্তগ্রুপ
            </a>
            @foreach($bloodGroups as $bg)
                <a href="{{ route('blood', ['group' => $bg, 'upazila' => $upazilaSlug]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $group == $bg ? 'bg-red-600 text-white shadow-xs' : 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-100' }}">
                    {{ $bg }}
                </a>
            @endforeach
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <span class="text-xs text-slate-500 font-medium">উপজেলা অনুযায়ী ফিল্টার করুন:</span>
            <form method="GET" action="{{ route('blood') }}" class="flex items-center gap-2">
                <input type="hidden" name="group" value="{{ $group }}">
                <select name="upazila" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-700 outline-none">
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

    <!-- Donors Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-14">
        @forelse($donors as $donor)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-red-500 text-white font-black text-lg flex items-center justify-center shadow-xs">
                                {{ $donor->blood_group }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $donor->name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $donor->location }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 mb-4">
                        <div class="flex justify-between">
                            <span class="text-slate-400">উপজেলা:</span>
                            <span class="font-semibold text-slate-700">{{ $donor->upazila->name_bn }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">সর্বশেষ রক্তদান:</span>
                            <span class="font-semibold text-slate-700">
                                {{ $donor->last_donated_at ? $donor->last_donated_at->format('d M, Y') : 'তথ্য নেই' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">স্ট্যাটাস:</span>
                            <span class="font-bold text-emerald-600"><i class="fa-solid fa-circle-check text-[10px] mr-1"></i>রক্তদানে প্রস্তুত</span>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="tel:{{ $donor->phone }}" class="flex-1 inline-flex items-center justify-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-2.5 rounded-xl transition shadow-xs">
                        <i class="fa-solid fa-phone"></i> সরাসরি কল
                    </a>
                    <a href="https://wa.me/88{{ $donor->phone }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center text-base transition shadow-xs">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-droplet-slash text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">এই গ্রুপে বর্তমানে কোনো রক্তদাতা পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <!-- Registration Section -->
    <div id="register-donor" class="max-w-3xl mx-auto bg-gradient-to-br from-red-50 to-rose-50 border border-red-200/80 rounded-3xl p-6 sm:p-10 shadow-lg">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-red-600 text-white rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-hand-holding-medical"></i>
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
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black text-sm py-3.5 rounded-xl shadow-md transition duration-150 mt-2">
                নিবন্ধন সম্পন্ন করুন
            </button>
        </form>
    </div>

</div>
@endsection

