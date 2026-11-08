@extends('layouts.app')

@section('title', 'বিনামূল্যে নিবন্ধন করুন — নরসিংদী সেবা')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-8">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white flex items-center justify-center text-2xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">নরসিংদী সেবায় ফ্রি নিবন্ধন</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">কয়েক সেকেন্ডে আপনার নাগরিক অ্যাকাউন্ট তৈরি করুন</p>
        </div>

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs space-y-1">
            @foreach($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">আপনার পূর্ণ নাম *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="নাম লিখুন" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
            </div>

            <!-- Phone & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="01XXXXXXXXX" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ইমেইল (ঐচ্ছিক)</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                </div>
            </div>

            <!-- Upazila & Account Type -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার উপজেলা *</label>
                    <select name="upazila_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        @foreach($upazilas as $u)
                            <option value="{{ $u->id }}" {{ old('upazila_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name_bn }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">অ্যাকাউন্টের ধরন *</label>
                    <select name="role" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>সাধারণ নাগরিক / রক্তদাতা</option>
                        <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>ব্যবসায়ী / হোমমেড কিচেন</option>
                    </select>
                </div>
            </div>

            <!-- Passwords -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) *</label>
                    <input type="password" name="password" required placeholder="পাসওয়ার্ড দিন" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">পাসওয়ার্ড নিশ্চিত করুন *</label>
                    <input type="password" name="password_confirmation" required placeholder="পুনরায় পাসওয়ার্ড দিন" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-emerald-600 focus:bg-white text-slate-800 transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm py-3.5 rounded-xl shadow-md transition duration-150 mt-2">
                অ্যাকাউন্ট তৈরি করুন
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            পূর্বেই একটি অ্যাকাউন্ট আছে? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:underline">লগইন করুন</a>
        </div>

    </div>
</div>
@endsection

