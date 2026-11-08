@extends('layouts.app')

@section('title', 'অর্ডার সফল হয়েছে — নরসিংদী সেবা')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden text-center p-6 sm:p-10">
        
        <!-- Success Icon -->
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-4 animate-bounce">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2">অর্ডার সফলভাবে গ্রহণ করা হয়েছে!</h1>
        <p class="text-xs sm:text-sm text-slate-500 mb-6">
            অর্ডারটি নিশ্চিত করার জন্য আমাদের প্রতিনিধি শীঘ্রই আপনার সাথে ফোনে যোগাযোগ করবেন।
        </p>

        <!-- Order Summary Card -->
        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 text-left space-y-3 mb-6">
            <div class="flex justify-between items-center pb-3 border-b border-slate-200 text-xs">
                <span class="text-slate-500">অর্ডার নম্বর:</span>
                <span class="font-black text-emerald-800 text-sm tracking-wider">{{ $order->order_number }}</span>
            </div>

            <div class="flex justify-between items-center text-xs">
                <span class="text-slate-500">গ্রাহকের নাম:</span>
                <span class="font-bold text-slate-800">{{ $order->customer_name }}</span>
            </div>

            <div class="flex justify-between items-center text-xs">
                <span class="text-slate-500">মোবাইল নম্বর:</span>
                <span class="font-bold text-slate-800">{{ $order->customer_phone }}</span>
            </div>

            <div class="flex justify-between items-center text-xs">
                <span class="text-slate-500">ডেলিভারি ঠিকানা:</span>
                <span class="font-medium text-slate-800 text-right">{{ $order->delivery_address }}, {{ $order->upazila->name_bn ?? '' }}</span>
            </div>

            <div class="flex justify-between items-center text-xs">
                <span class="text-slate-500">পেমেন্ট মেথড:</span>
                <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">ক্যাশ অন ডেলিভারি (পণ্য পেয়ে টাকা দিন)</span>
            </div>

            <!-- Items -->
            <div class="pt-3 border-t border-slate-200">
                <p class="text-xs font-bold text-slate-700 mb-2">অর্ডারকৃত পণ্যসমূহ:</p>
                <div class="space-y-1.5 text-xs text-slate-600">
                    @foreach($order->items as $item)
                        <div class="flex justify-between">
                            <span>{{ $item->product_title }} × {{ $item->quantity }}</span>
                            <span class="font-bold text-slate-800">৳ {{ number_format($item->subtotal, 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 space-y-1 text-xs">
                <div class="flex justify-between text-slate-500">
                    <span>সাবটোটাল:</span>
                    <span>৳ {{ number_format($order->subtotal, 0) }}</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>হোম ডেলিভারি চার্জ:</span>
                    <span>৳ {{ number_format($order->delivery_charge, 0) }}</span>
                </div>
                <div class="flex justify-between text-base font-black text-slate-900 pt-1 border-t border-slate-200">
                    <span>সর্বমোট প্রদেয়:</span>
                    <span class="text-emerald-800">৳ {{ number_format($order->total_amount, 0) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('shop') }}" class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm py-3.5 rounded-xl transition shadow-xs">
                আরও কেনাকাটা করুন
            </a>
            <a href="{{ route('home') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm py-3.5 rounded-xl transition">
                মূল পেজে ফিরে যান
            </a>
        </div>

    </div>
</div>
@endsection

