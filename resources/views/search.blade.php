@extends('layouts.app')

@section('title', 'অনুসন্ধান ফলাফল: ' . $q . ' | নরসিংদী সেবা')

@section('content')
<div class="bg-emerald-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="text-xs text-emerald-300 font-semibold uppercase tracking-wider">সার্বজনীন সন্ধান</span>
        <h1 class="text-2xl md:text-3xl font-black mt-1">অনুসন্ধান ফলাফল: "{{ $q }}"</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- 1. Emergency Results -->
    @if($emergency->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-kit-medical text-red-500"></i> জরুরি সেবা
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($emergency as $item)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $item->title }}</h3>
                        <p class="text-xs text-slate-500">{{ $item->address ?? $item->upazila->name_bn }}</p>
                    </div>
                    <a href="tel:{{ $item->phone }}" class="bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-phone"></i> কল
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 2. Doctor Results -->
    @if($doctors->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-user-doctor text-blue-600"></i> ডাক্তার ও চেম্বার
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($doctors as $doc)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $doc->name }}</h3>
                        <p class="text-xs text-blue-600 font-semibold">{{ $doc->specialty }}</p>
                        <p class="text-[11px] text-slate-500">{{ $doc->hospital_chamber }}</p>
                    </div>
                    <a href="tel:{{ $doc->serial_phone }}" class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg">
                        সিরিয়াল
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 3. Shop Products -->
    @if($products->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-bag-shopping text-amber-600"></i> শপ ও ঘরের খাবার
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($products as $prod)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $prod->title }}</h3>
                        <p class="text-xs text-emerald-700 font-bold">৳ {{ number_format($prod->discount_price ?? $prod->price, 0) }}</p>
                    </div>
                    <a href="tel:{{ $prod->seller_phone }}" class="bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg">
                        অর্ডার
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 4. Workers -->
    @if($workers->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-screwdriver-wrench text-indigo-600"></i> কাজের লোক ও কারিগর
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($workers as $w)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $w->name }}</h3>
                        <p class="text-xs text-indigo-600 font-semibold">{{ $w->category }}</p>
                    </div>
                    <a href="tel:{{ $w->phone }}" class="bg-indigo-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg">
                        কল
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 5. Jobs -->
    @if($jobs->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i class="fa-solid fa-briefcase text-purple-600"></i> চাকরির খবর
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($jobs as $j)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $j->title }}</h3>
                        <p class="text-xs text-slate-600">{{ $j->company_name }} • {{ $j->salary }}</p>
                    </div>
                    <a href="tel:{{ $j->contact_phone }}" class="bg-purple-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg">
                        যোগাযোগ
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 6. Blood Donors Results -->
    @if(isset($donors) && $donors->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center justify-between">
            <span class="flex items-center gap-2"><i class="fa-solid fa-droplet text-red-600"></i> রক্তদাতা তালিকা</span>
            <a href="{{ route('blood', ['search' => $q]) }}" class="text-xs text-red-600 hover:underline font-semibold">সকল রক্তদাতা দেখুন &rarr;</a>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($donors as $d)
                @php $fInfo = $d->fitness_info; @endphp
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-red-600 text-white font-black text-sm flex items-center justify-center shrink-0">
                            {{ $d->blood_group }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm leading-tight">{{ $d->name }}</h3>
                            <p class="text-[11px] text-slate-500">{{ $d->location }}</p>
                            <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-md mt-1 {{ $fInfo['is_fit'] ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-800' }}">
                                {{ $fInfo['title'] }}
                            </span>
                        </div>
                    </div>
                    <a href="tel:{{ $d->phone }}" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-2 rounded-xl shrink-0 transition">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 7. Tourist Places Results -->
    @if(isset($places) && $places->count() > 0)
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center justify-between">
            <span class="flex items-center gap-2"><i class="fa-solid fa-map-location-dot text-teal-600"></i> দর্শনীয় স্থান</span>
            <a href="{{ route('places') }}" class="text-xs text-teal-600 hover:underline font-semibold">সব স্থান দেখুন &rarr;</a>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($places as $p)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col justify-between">
                    @if($p->image_url)
                        <img src="{{ asset($p->image_url) }}" alt="{{ $p->name }}" class="w-full h-32 object-cover">
                    @endif
                    <div class="p-3">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-teal-50 text-teal-700">{{ $p->category }}</span>
                        <h3 class="font-bold text-slate-900 text-xs mt-1 leading-snug">{{ $p->name }}</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $p->location }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($emergency->count() == 0 && $doctors->count() == 0 && $products->count() == 0 && $workers->count() == 0 && $jobs->count() == 0 && (!isset($donors) || $donors->count() == 0) && (!isset($places) || $places->count() == 0))
        <div class="bg-white p-12 text-center rounded-2xl border border-slate-200">
            <i class="fa-solid fa-magnifying-glass text-3xl text-slate-300 mb-2"></i>
            <h3 class="text-base font-bold text-slate-800 mb-1">কোনো তথ্য পাওয়া যায়নি</h3>
            <p class="text-xs text-slate-500">দয়া করে অন্য কোনো শব্দ দিয়ে সন্ধান করুন বা বানান চেক করুন।</p>
        </div>
    @endif

</div>
@endsection

