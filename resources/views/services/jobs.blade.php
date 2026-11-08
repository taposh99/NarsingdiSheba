@extends('layouts.app')

@section('title', 'নরসিংদীতে চাকরির খবর ও নিয়োগ বিজ্ঞপ্তি | নরসিংদী সেবা')

@section('content')
<div class="bg-purple-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-purple-300"></i> স্থানীয় চাকরির খবর ও সার্কুলার
            </h1>
            <p class="text-purple-100 text-xs md:text-sm">নরসিংদী জেলার বিভিন্ন প্রতিষ্ঠান, দোকান ও কোম্পানির চাকরির সুযোগ</p>
        </div>
        <a href="#post-job" class="inline-flex items-center gap-2 bg-white text-purple-900 hover:bg-purple-50 font-bold text-xs md:text-sm px-5 py-2.5 rounded-xl shadow-md transition self-start md:self-auto">
            <i class="fa-solid fa-plus"></i> বিনামূল্যে চাকরি পোস্ট করুন
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex items-center justify-between">
        <span class="text-xs font-bold text-slate-700">উপজেলা অনুযায়ী ফিল্টার করুন:</span>
        <form method="GET" action="{{ route('jobs') }}">
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

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-14">
        @forelse($jobs as $job)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-purple-50 text-purple-700 text-xs font-bold px-2.5 py-0.5 rounded-md">
                            {{ $job->upazila->name_bn ?? '' }}
                        </span>
                        @if($job->deadline)
                            <span class="text-xs text-rose-600 font-semibold"><i class="fa-solid fa-clock mr-1"></i>আবেদনের শেষ তারিখ: {{ $job->deadline }}</span>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $job->title }}</h3>
                    <p class="text-xs font-semibold text-slate-600 mb-3"><i class="fa-solid fa-building text-slate-400 mr-1.5"></i>{{ $job->company_name }}</p>

                    @if($job->salary)
                    <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-800 text-xs font-bold px-3 py-1.5 rounded-lg mb-3">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600"></i> বেতন: {{ $job->salary }}
                    </div>
                    @endif

                    @if($job->requirements)
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        {{ $job->requirements }}
                    </p>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400">যোগাযোগ করুন সরাসরি:</span>
                    <a href="tel:{{ $job->contact_phone }}" class="inline-flex items-center gap-1.5 bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-xs">
                        <i class="fa-solid fa-phone"></i> {{ $job->contact_phone }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-briefcase text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">বর্তমানে কোনো চাকরি পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <!-- Post a Job Section -->
    <div id="post-job" class="max-w-3xl mx-auto bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-lg">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-purple-600 text-white rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900">বিনামূল্যে চাকরির বিজ্ঞপ্তি পোস্ট করুন</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">আপনার প্রতিষ্ঠান বা দোকানের জন্য দক্ষ কর্মী খুঁজে নিন</p>
        </div>

        <form action="{{ route('jobs.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">পদের নাম (Title) *</label>
                    <input type="text" name="title" required placeholder="যেমন: সেলসম্যান আবশ্যক" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">কোম্পানি বা প্রতিষ্ঠানের নাম *</label>
                    <input type="text" name="company_name" required placeholder="প্রতিষ্ঠানের নাম" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">উপজেলা *</label>
                    <select name="upazila_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        @foreach($upazilas as $u)
                            <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">বেতন (ঐচ্ছিক)</label>
                    <input type="text" name="salary" placeholder="যেমন: ৳ ১৫,০০০" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আবেদনের শেষ তারিখ</label>
                    <input type="text" name="deadline" placeholder="যেমন: ৩০ নভেম্বর ২০২৬" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">আবেদন বা যোগাযোগের মোবাইল নম্বর *</label>
                <input type="text" name="contact_phone" required placeholder="01XXXXXXXXX" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">কাজের বিবরণ ও যোগ্যতা</label>
                <textarea name="requirements" rows="3" placeholder="শিক্ষাগত যোগ্যতা, অভিজ্ঞতা এবং কাজের বিবরণ লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-purple-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-black text-sm py-3.5 rounded-xl shadow-md transition duration-150">
                বিজ্ঞপ্তি পোস্ট করুন
            </button>
        </form>
    </div>

</div>
@endsection
