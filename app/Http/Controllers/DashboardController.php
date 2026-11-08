<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BloodDonor;
use App\Models\JobPost;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\DailyPrice;
use App\Models\NewsTicker;
use App\Models\Doctor;
use App\Models\EmergencyService;
use App\Models\Upazila;
use App\Models\Advertisement;
use App\Models\AdPackage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user is a registered blood donor by matching phone
        $donorProfile = BloodDonor::where('phone', $user->phone)->first();

        // User's posted jobs
        $myJobs = JobPost::where('contact_phone', $user->phone)->latest()->get();

        $upazilas = Upazila::all();

        // If user has management access (Admin or Moderator with permissions), gather allowed collections
        $adminData = [];
        if ($user->canAccessManagement()) {
            $adminData = [
                'total_users' => User::count(),
                'total_donors' => BloodDonor::count(),
                'total_products' => Product::count(),
                'total_jobs' => JobPost::count(),
                'total_ads' => Advertisement::count(),
                'total_orders' => Order::count(),
                'recent_users' => User::latest()->take(6)->get(),
                'all_users' => $user->isAdmin() ? User::with('upazila')->latest()->get() : collect([]),
                'tickers' => $user->hasPermission('manage_tickers') ? NewsTicker::latest()->get() : collect([]),
                'prices' => $user->hasPermission('manage_prices') ? DailyPrice::latest()->get() : collect([]),
                'emergencies' => $user->hasPermission('manage_emergency') ? EmergencyService::with('upazila')->latest()->take(15)->get() : collect([]),
                'doctors' => $user->hasPermission('manage_doctors') ? Doctor::with('upazila')->latest()->take(15)->get() : collect([]),
                'donors' => $user->hasPermission('manage_blood') ? BloodDonor::with('upazila')->latest()->take(15)->get() : collect([]),
                'products' => $user->hasPermission('manage_products') ? Product::with('upazila')->latest()->take(15)->get() : collect([]),
                'jobs' => $user->hasPermission('manage_jobs') ? JobPost::with('upazila')->latest()->take(15)->get() : collect([]),
                'ads' => $user->hasPermission('manage_ads') ? Advertisement::with('package')->latest()->get() : collect([]),
                'ad_packages' => AdPackage::all(),
                'orders' => $user->hasPermission('manage_orders') ? Order::with(['upazila', 'items.product'])->latest()->take(20)->get() : collect([]),
                'available_permissions' => [
                    'manage_emergency' => 'জরুরি সেবা',
                    'manage_blood' => 'রক্ত ব্যাংক',
                    'manage_doctors' => 'ডাক্তার ও চেম্বার',
                    'manage_products' => 'অনলাইন শপ পণ্য',
                    'manage_orders' => 'কাস্টমার অর্ডার',
                    'manage_jobs' => 'চাকরির সার্কুলার',
                    'manage_prices' => 'আজকের বাজারদর',
                    'manage_tickers' => 'ব্রেকিং নিউজ টিকার',
                    'manage_ads' => 'বিজ্ঞাপন ও প্যাকেজ',
                ],
            ];
        }

        return view('dashboard', compact('user', 'donorProfile', 'myJobs', 'upazilas', 'adminData'));
    }

    public function toggleDonorStatus(Request $request)
    {
        $user = Auth::user();
        $donor = BloodDonor::where('phone', $user->phone)->first();

        if ($donor) {
            $donor->is_available = !$donor->is_available;
            $donor->save();
            return back()->with('success', 'রক্তদানের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
        }

        return back()->with('error', 'রক্তদাতার কোনো প্রোফাইল পাওয়া যায়নি।');
    }
}
