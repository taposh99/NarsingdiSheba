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

        // If user is Admin, gather system collections for management
        $adminData = [];
        if ($user->isAdmin()) {
            $adminData = [
                'total_users' => User::count(),
                'total_donors' => BloodDonor::count(),
                'total_products' => Product::count(),
                'total_jobs' => JobPost::count(),
                'total_ads' => Advertisement::count(),
                'total_orders' => Order::count(),
                'recent_users' => User::latest()->take(6)->get(),
                'tickers' => NewsTicker::latest()->get(),
                'prices' => DailyPrice::latest()->get(),
                'emergencies' => EmergencyService::with('upazila')->latest()->take(15)->get(),
                'doctors' => Doctor::with('upazila')->latest()->take(15)->get(),
                'donors' => BloodDonor::with('upazila')->latest()->take(15)->get(),
                'products' => Product::with('upazila')->latest()->take(15)->get(),
                'jobs' => JobPost::with('upazila')->latest()->take(15)->get(),
                'ads' => Advertisement::with('package')->latest()->get(),
                'ad_packages' => AdPackage::all(),
                'orders' => Order::with(['upazila', 'items.product'])->latest()->take(20)->get(),
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
