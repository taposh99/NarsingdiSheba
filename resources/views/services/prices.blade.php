@extends('layouts.app')

@section('title', 'নরসিংদীতে আজকের বাজারদর — নিত্যপণ্যের খুচরা ও পাইকারি দাম | নরসিংদী সেবা')

@section('content')
<div class="bg-teal-900 text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-2">
            <i class="fa-solid fa-scale-balanced text-teal-300"></i> আজকের বাজারদর (নরসিংদী জেলা)
        </h1>
        <p class="text-teal-100 text-xs md:text-sm">নরসিংদীর প্রধান বাজারসমূহের চাল, ডাল, তেল, সবজি, মাছ ও মাংসের দৈনিক নির্ভরযোগ্য দরদাম</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden">
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                <i class="fa-solid fa-calendar-day text-emerald-600 mr-1.5"></i>সর্বশেষ আপডেট: <span class="font-bold text-slate-800">{{ date('d M, Y') }}</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="inline-flex items-center gap-1 text-red-600 font-semibold"><i class="fa-solid fa-arrow-trend-up"></i> বাড়ছে</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold"><i class="fa-solid fa-arrow-trend-down"></i> কমছে</span>
                <span class="inline-flex items-center gap-1 text-slate-500 font-semibold"><i class="fa-solid fa-minus"></i> স্থির</span>
            </div>
        </div>

        <div class="p-6 space-y-8">
            @foreach($prices as $categoryName => $items)
                <div>
                    <h2 class="text-base font-bold text-teal-900 mb-3 pb-1 border-b border-slate-200 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-600"></span>
                        {{ $categoryName }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($items as $item)
                            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-slate-800 text-sm block">{{ $item->item_name }}</span>
                                    <span class="text-xs text-slate-500">প্রতি {{ $item->unit }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-black text-emerald-800">৳ {{ $item->price }}</div>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full
                                        {{ $item->trend == 'বাড়ছে' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $item->trend == 'কমছে' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $item->trend == 'স্থির' ? 'bg-slate-200 text-slate-700' : '' }}">
                                        @if($item->trend == 'বাড়ছে') <i class="fa-solid fa-arrow-trend-up"></i>
                                        @elseif($item->trend == 'কমছে') <i class="fa-solid fa-arrow-trend-down"></i>
                                        @else <i class="fa-solid fa-minus"></i>
                                        @endif
                                        {{ $item->trend }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
