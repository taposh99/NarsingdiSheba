@extends('layouts.app')

@section('title', 'নরসিংদীর দর্শনীয় স্থান ও ভ্রমণ গাইড | নরসিংদী সেবা')

@section('content')
<div class="bg-gradient-to-r from-emerald-800 to-teal-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
            <i class="fa-solid fa-mountain-sun text-emerald-300"></i> দর্শনীয় স্থান ও ভ্রমণ গাইড
        </h1>
        <p class="text-emerald-100 text-xs md:text-sm">নরসিংদীর আড়াই হাজার বছরের প্রাচীন ইতিহাস, বিনোদন পার্ক ও নদী তটবর্তী সুন্দর স্থানসমূহ</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-8 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('places', ['upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ !$category ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সব স্থান
            </a>
            <a href="{{ route('places', ['category' => 'ঐতিহাসিক', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'ঐতিহাসিক' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                ঐতিহাসিক নিদর্শন
            </a>
            <a href="{{ route('places', ['category' => 'বিনোদন পার্ক', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'বিনোদন পার্ক' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                বিনোদন পার্ক
            </a>
            <a href="{{ route('places', ['category' => 'প্রাকৃতিক', 'upazila' => $upazilaSlug]) }}" 
               class="px-3.5 py-1.5 rounded-lg transition {{ $category == 'প্রাকৃতিক' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                প্রাকৃতিক ও নদী
            </a>
        </div>

        <form method="GET" action="{{ route('places') }}">
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

    <!-- Places Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($places as $place)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between group">
                <div>
                    <div class="h-48 relative overflow-hidden bg-slate-900">
                        @if($place->image_url)
                            <img src="{{ asset($place->image_url) }}" alt="{{ $place->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-emerald-800 to-teal-600 flex items-center justify-center text-white text-5xl">
                                <i class="fa-solid fa-landmark-dome"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold bg-emerald-700/90 text-white backdrop-blur-xs shadow-xs">
                            {{ $place->category }}
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-slate-900 text-lg mb-1 leading-snug group-hover:text-emerald-700 transition">{{ $place->name }}</h3>
                        <p class="text-xs text-slate-500 mb-3 flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-emerald-600 shrink-0"></i>{{ $place->location }}</p>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $place->description }}</p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>উপজেলা: <strong class="text-slate-700">{{ $place->upazila->name_bn ?? '' }}</strong></span>
                    <span class="text-emerald-700 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>উন্মুক্ত দর্শনার্থীদের জন্য</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                <i class="fa-solid fa-mountain text-3xl text-slate-300 mb-2"></i>
                <p class="text-slate-500 text-sm">কোনো দর্শনীয় স্থান পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $places->links() }}
    </div>

</div>
@endsection

