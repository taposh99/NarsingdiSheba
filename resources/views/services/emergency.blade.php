@extends('layouts.app')

@section('title', 'নরসিংদীর জরুরি হেল্পলাইন নম্বর — পুলিশ, ফায়ার সার্ভিস, অ্যাম্বুলেন্স | নরসিংদী সেবা')

@section('content')
<div class="bg-emerald-800 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-black mb-2">নরসিংদী জেলা জরুরি সেবা ও হেল্পলাইন</h1>
        <p class="text-emerald-100 text-xs md:text-sm">পুলিশ, ফায়ার সার্ভিস, অ্যাম্বুলেন্স, বিদ্যুৎ ও অক্সিজেন সরবরাহকারীদের তাৎক্ষণিক যোগাযোগের নম্বর</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex flex-wrap items-center justify-between gap-4">
        <!-- Categories Filter -->
        <div class="flex items-center flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('emergency', ['upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ !$category ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সব জরুরি সেবা
            </a>
            <a href="{{ route('emergency', ['category' => 'police', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $category == 'police' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i class="fa-solid fa-shield-halved mr-1"></i> পুলিশ ও থানা
            </a>
            <a href="{{ route('emergency', ['category' => 'fire', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $category == 'fire' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i class="fa-solid fa-fire-extinguisher mr-1"></i> ফায়ার সার্ভিস
            </a>
            <a href="{{ route('emergency', ['category' => 'ambulance', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $category == 'ambulance' ? 'bg-rose-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i class="fa-solid fa-truck-medical mr-1"></i> অ্যাম্বুলেন্স
            </a>
            <a href="{{ route('emergency', ['category' => 'electricity', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $category == 'electricity' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i class="fa-solid fa-bolt mr-1"></i> পল্লী বিদ্যুৎ
            </a>
            <a href="{{ route('emergency', ['category' => 'oxygen', 'upazila' => $upazilaSlug]) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $category == 'oxygen' ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i class="fa-solid fa-mask-ventilator mr-1"></i> অক্সিজেন ব্যাংক
            </a>
        </div>

        <!-- Upazila Filter Dropdown -->
        <form method="GET" action="{{ route('emergency') }}" class="flex items-center gap-2">
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

    <!-- Emergency Services List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($services as $item)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                            {{ $item->category == 'police' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $item->category == 'fire' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $item->category == 'ambulance' ? 'bg-rose-100 text-rose-700' : '' }}
                            {{ $item->category == 'electricity' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $item->category == 'oxygen' ? 'bg-teal-100 text-teal-700' : '' }}">
                            @if($item->category == 'police') থানা / পুলিশ
                            @elseif($item->category == 'fire') ফায়ার সার্ভিস
                            @elseif($item->category == 'ambulance') অ্যাম্বুলেন্স
                            @elseif($item->category == 'electricity') পল্লী বিদ্যুৎ
                            @else অক্সিজেন
                            @endif
                        </span>
                        @if($item->upazila)
                            <span class="text-xs text-slate-500 font-medium">
                                <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $item->upazila->name_bn }}
                            </span>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $item->title }}</h3>
                    @if($item->address)
                        <p class="text-xs text-slate-500 mb-2">{{ $item->address }}</p>
                    @endif
                    @if($item->details)
                        <p class="text-xs text-emerald-800 bg-emerald-50 p-2.5 rounded-xl mb-3 border border-emerald-100">{{ $item->details }}</p>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                    <div>
                        <div class="text-sm font-black text-slate-800">{{ $item->phone }}</div>
                        @if($item->alt_phone)
                            <div class="text-xs text-slate-400">বিকল্প: {{ $item->alt_phone }}</div>
                        @endif
                    </div>
                    <a href="tel:{{ $item->phone }}" class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-phone"></i> সরাসরি কল
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-circle-info text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">এই ক্যাটাগরিতে কোনো সেবা পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $services->links() }}
    </div>

</div>
@endsection
