@extends('layouts.app')

@section('title', 'লগইন করুন — নরসিংদী সেবা')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white flex items-center justify-center text-2xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">নরসিংদী সেবায় লগইন</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">আপনার মোবাইল নম্বর বা ইমেইল দিয়ে প্রবেশ করুন</p>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Login Input (Phone or Email) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">মোবাইল নম্বর অথবা ইমেইল *</label>
                <div class="relative">
                    <input type="text" name="login" value="{{ old('login') }}" required autofocus
                           placeholder="01XXXXXXXXX অথবা email@example.com" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-3 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                    <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-slate-400"></i>
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700">পাসওয়ার্ড *</label>
                    <a href="tel:01700000000" class="text-[11px] text-emerald-700 hover:underline">পাসওয়ার্ড ভুলে গেছেন?</a>
                </div>
                <div class="relative">
                    <input type="password" name="password" required 
                           placeholder="আপনার পাসওয়ার্ড লিখুন" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-3 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                    <i class="fa-solid fa-key absolute left-3.5 top-3.5 text-slate-400"></i>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                <label for="remember" class="ml-2 text-xs text-slate-600">আমাকে মনে রাখুন</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm py-3.5 rounded-xl shadow-md transition duration-150">
                লগইন করুন
            </button>
        </form>

        <!-- Demo credentials box -->
        <div class="mt-6 p-3.5 bg-emerald-50/70 border border-emerald-100 rounded-2xl text-[11px] text-emerald-800 space-y-1">
            <p class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-circle-info"></i> টেস্ট লগইন অ্যাকাউন্ট:</p>
            <p>• অ্যাডমিন (সকল এক্সেস): <span class="font-bold text-slate-800">01700000000</span> | পাসওয়ার্ড: <span class="font-bold text-slate-800">password</span></p>
            <p>• মডারেটর (নির্দিষ্ট পারমিশন): <span class="font-bold text-slate-800">01900000000</span> | পাসওয়ার্ড: <span class="font-bold text-slate-800">password</span></p>
            <p>• সেলার (দোকানদার): <span class="font-bold text-slate-800">01800000000</span> | পাসওয়ার্ড: <span class="font-bold text-slate-800">password</span></p>
        </div>

        <!-- Register Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            এখনও কোনো অ্যাকাউন্ট নেই? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:underline">নতুন অ্যাকাউন্ট তৈরি করুন</a>
        </div>

    </div>
</div>
@endsection

