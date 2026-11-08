@extends('layouts.app')

@section('title', 'নরসিংদীর বিশেষজ্ঞ ডাক্তার ও চেম্বার — বিভাগভিত্তিক তালিকা | নরসিংদী সেবা')

@section('content')
<div class="bg-blue-800 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
            <i class="fa-solid fa-user-doctor text-blue-300"></i> বিশেষজ্ঞ ডাক্তার ও চেম্বার তালিকা
        </h1>
        <p class="text-blue-100 text-xs md:text-sm">নরসিংদী সদর ও সকল উপজেলার অভিজ্ঞ বিশেষজ্ঞ চিকিৎসকদের সিরিয়াল ও সময়সূচি</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex flex-wrap items-center justify-between gap-4">
        <!-- Specialty Tabs -->
        <div class="flex items-center flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('doctors', ['upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ !$specialty ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সকল বিশেষজ্ঞ
            </a>
            <a href="{{ route('doctors', ['specialty' => 'মেডিসিন', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $specialty == 'মেডিসিন' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                মেডিসিন
            </a>
            <a href="{{ route('doctors', ['specialty' => 'গাইনি', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $specialty == 'গাইনি' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                গাইনি ও প্রসূতি
            </a>
            <a href="{{ route('doctors', ['specialty' => 'শিশু', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $specialty == 'শিশু' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                শিশু বিশেষজ্ঞ
            </a>
            <a href="{{ route('doctors', ['specialty' => 'হৃদরোগ', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $specialty == 'হৃদরোগ' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                হৃদরোগ
            </a>
            <a href="{{ route('doctors', ['specialty' => 'অর্থোপেডিক', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $specialty == 'অর্থোপেডিক' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                অর্থোপেডিক
            </a>
        </div>

        <!-- Upazila Filter Dropdown -->
        <form method="GET" action="{{ route('doctors') }}" class="flex items-center gap-2">
            <input type="hidden" name="specialty" value="{{ $specialty }}">
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

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($doctors as $doc)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start gap-3.5 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $doc->name }}</h3>
                            <p class="text-xs text-blue-700 font-semibold mt-0.5">{{ $doc->specialty }}</p>
                            <p class="text-[11px] text-slate-500 leading-snug">{{ $doc->degree }}</p>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-600 mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-hospital text-slate-400 w-4 text-center"></i>
                            <span class="font-medium text-slate-800">{{ $doc->hospital_chamber }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-clock text-slate-400 w-4 text-center"></i>
                            <span>{{ $doc->visiting_time }}</span>
                        </div>
                        @if($doc->fee)
                        <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                            <i class="fa-solid fa-tag text-emerald-500 w-4 text-center"></i>
                            <span>ফি: {{ $doc->fee }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">
                        <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $doc->upazila->name_bn ?? '' }}
                    </span>
                    <a href="tel:{{ $doc->serial_phone }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-calendar-check"></i> সিরিয়াল বুকিং
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-user-doctor text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">এই বিভাগে কোনো ডাক্তারের তথ্য পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $doctors->links() }}
    </div>

</div>
@endsection

