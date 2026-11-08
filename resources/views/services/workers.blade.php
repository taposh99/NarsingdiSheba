@extends('layouts.app')

@section('title', 'নরসিংদীর কাজের লোক ও দক্ষ কারিগর — সরাসরি যোগাযোগ | নরসিংদী সেবা')

@section('content')
<div class="bg-indigo-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
            <i class="fa-solid fa-screwdriver-wrench text-indigo-300"></i> কাজের লোক ও দক্ষ কারিগর
        </h1>
        <p class="text-indigo-100 text-xs md:text-sm">ইলেকট্রিশিয়ান, প্লাম্বার, এসি মিস্ত্রি, ড্রাইভার ও রান্নার মানুষের সাথে সরাসরি যোগাযোগের ফোন নম্বর</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('workers', ['upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ !$category ? 'bg-indigo-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সকল পেশা
            </a>
            <a href="{{ route('workers', ['category' => 'ইলেকট্রিশিয়ান', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'ইলেকট্রিশিয়ান' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                ইলেকট্রিশিয়ান
            </a>
            <a href="{{ route('workers', ['category' => 'প্লাম্বার', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'প্লাম্বার' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                প্লাম্বার / স্যানিটারি
            </a>
            <a href="{{ route('workers', ['category' => 'এসি', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'এসি' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                এসি ও ফ্রিজ
            </a>
            <a href="{{ route('workers', ['category' => 'ড্রাইভার', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'ড্রাইভার' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                ড্রাইভার
            </a>
            <a href="{{ route('workers', ['category' => 'রান্নার', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'রান্নার' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                রান্না / গৃহকর্মী
            </a>
        </div>

        <form method="GET" action="{{ route('workers') }}" class="flex items-center gap-2">
            <input type="hidden" name="category" value="{{ $category }}">
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

    <!-- Workers Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($workers as $w)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-lg">
                            {{ $w->category }}
                        </span>
                        <span class="text-xs text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check text-[10px] mr-1"></i>কাজে উপলব্ধ</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $w->name }}</h3>
                    <p class="text-xs text-slate-500 mb-3"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $w->upazila->name_bn ?? '' }}</p>

                    <div class="space-y-1.5 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 mb-4">
                        @if($w->experience)
                            <div class="flex justify-between">
                                <span class="text-slate-400">অভিজ্ঞতা:</span>
                                <span class="font-medium text-slate-700">{{ $w->experience }}</span>
                            </div>
                        @endif
                        @if($w->rate_info)
                            <div class="flex justify-between">
                                <span class="text-slate-400">মজুরি / পারিশ্রমিক:</span>
                                <span class="font-bold text-indigo-700">{{ $w->rate_info }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs font-bold text-slate-700">{{ $w->phone }}</span>
                    <a href="tel:{{ $w->phone }}" class="inline-flex items-center gap-1.5 bg-indigo-700 hover:bg-indigo-800 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-phone"></i> সরাসরি কল
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-toolbox text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">এই ক্যাটাগরিতে কোনো কারিগর পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $workers->links() }}
    </div>

</div>
@endsection
