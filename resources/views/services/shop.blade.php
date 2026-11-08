@extends('layouts.app')

@section('title', 'নরসিংদী অনলাইন শপ — বাবুরহাট বস্ত্র ও ঘরের খাবার | নরসিংদী সেবা')

@section('content')
<div class="bg-gradient-to-r from-amber-700 to-orange-800 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
                <i class="fa-solid fa-bag-shopping text-amber-300"></i> নরসিংদী অনলাইন শপ ও ঘরের খাবার
            </h1>
            <p class="text-amber-100 text-xs md:text-sm">বাবুরহাটের তাঁতের পোশাক, নরসিংদীর তাজা ফল এবং হোমমেড খাবারের সমাহার</p>
        </div>
        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-xs text-white text-xs px-3.5 py-2 rounded-xl self-start md:self-auto border border-white/20">
            <i class="fa-solid fa-truck-fast"></i> জেলাজুড়ে হোম ডেলিভারি
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('shop', ['upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ !$category ? 'bg-amber-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সব পণ্য
            </a>
            <a href="{{ route('shop', ['category' => 'baburhat', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'baburhat' ? 'bg-amber-700 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                🧵 বাবুরহাট বস্ত্র
            </a>
            <a href="{{ route('shop', ['category' => 'homemade', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'homemade' ? 'bg-orange-600 text-white' : 'bg-orange-50 text-orange-700 hover:bg-orange-100' }}">
                🍲 ঘরের খাবার (হোমমেড)
            </a>
            <a href="{{ route('shop', ['category' => 'grocery', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'grocery' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                🍎 লটকন ও স্থানীয় ফল
            </a>
        </div>

        <form method="GET" action="{{ route('shop') }}" class="flex items-center gap-2">
            <input type="hidden" name="category" value="{{ $category }}">
            <select name="upazila" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-700 outline-none">
                <option value="">সকল এলাকা</option>
                @foreach($upazilas as $u)
                    <option value="{{ $u->slug }}" {{ $upazilaSlug == $u->slug ? 'selected' : '' }}>
                        {{ $u->name_bn }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $prod)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div class="p-5">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold 
                            {{ $prod->category == 'homemade' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $prod->category == 'baburhat' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $prod->category == 'grocery' ? 'bg-green-100 text-green-700' : '' }}">
                            @if($prod->category == 'homemade') 🍲 ঘরের খাবার
                            @elseif($prod->category == 'baburhat') 🧵 বাবুরহাট বস্ত্র
                            @else 🍎 স্থানীয় ফল ও ফলন
                            @endif
                        </span>
                        <span class="text-xs text-slate-500 font-medium">{{ $prod->upazila->name_bn ?? '' }}</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-2 hover:text-emerald-700 transition">
                        {{ $prod->title }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                        {{ $prod->description }}
                    </p>

                    <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 space-y-1">
                        <p><i class="fa-solid fa-shop text-slate-400 mr-1.5"></i>দোকান / রাঁধুনি: <span class="font-semibold text-slate-800">{{ $prod->seller_name }}</span></p>
                        <p><i class="fa-solid fa-box text-slate-400 mr-1.5"></i>ক্যাশ অন ডেলিভারি সুবিধা আছে</p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="text-xl font-black text-emerald-800">
                            ৳ {{ number_format($prod->discount_price ?? $prod->price, 0) }}
                            <span class="text-xs font-normal text-slate-500">/ {{ $prod->unit }}</span>
                        </div>
                        @if($prod->discount_price)
                            <div class="text-xs text-slate-400 line-through">৳ {{ number_format($prod->price, 0) }}</div>
                        @endif
                    </div>

                    <a href="tel:{{ $prod->seller_phone }}" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-phone"></i> অর্ডার কল
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-bag-shopping text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">এই ক্যাটাগরিতে কোনো পণ্য পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>
@endsection
