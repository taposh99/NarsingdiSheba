<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upazila;
use App\Models\EmergencyService;
use App\Models\BloodDonor;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Product;
use App\Models\Worker;
use App\Models\JobPost;
use App\Models\TouristPlace;
use App\Models\DailyPrice;
use App\Models\NewsTicker;
use App\Models\Advertisement;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $selectedUpazila = $request->query('upazila');

        $upazilas = Upazila::all();
        $tickers = NewsTicker::where('is_active', true)->get();

        $emergencyQuery = EmergencyService::with('upazila');
        $bloodQuery = BloodDonor::with('upazila');
        $doctorQuery = Doctor::with('upazila');
        $productQuery = Product::with('upazila');
        $workerQuery = Worker::with('upazila');
        $jobQuery = JobPost::with('upazila')->where('is_active', true);
        $placeQuery = TouristPlace::with('upazila');

        if ($selectedUpazila) {
            $upazila = Upazila::where('slug', $selectedUpazila)->first();
            if ($upazila) {
                $emergencyQuery->where('upazila_id', $upazila->id);
                $bloodQuery->where('upazila_id', $upazila->id);
                $doctorQuery->where('upazila_id', $upazila->id);
                $productQuery->where('upazila_id', $upazila->id);
                $workerQuery->where('upazila_id', $upazila->id);
                $jobQuery->where('upazila_id', $upazila->id);
                $placeQuery->where('upazila_id', $upazila->id);
            }
        }

        $featuredEmergency = $emergencyQuery->where('is_featured', true)->take(6)->get();
        $doctors = $doctorQuery->take(6)->get();
        $products = $productQuery->take(6)->get();
        $homemadeFoods = Product::where('category', 'homemade')->take(4)->get();
        $workers = $workerQuery->take(4)->get();
        $jobs = $jobQuery->latest()->take(4)->get();
        $places = $placeQuery->take(6)->get();
        $dailyPrices = DailyPrice::take(6)->get();
        $activeAd = Advertisement::where('status', 'active')->latest()->first();

        $stats = [
            'donors' => BloodDonor::count(),
            'doctors' => Doctor::count(),
            'hospitals' => Hospital::count(),
            'emergency' => EmergencyService::count(),
            'products' => Product::count(),
            'workers' => Worker::count(),
        ];

        return view('home', compact(
            'upazilas',
            'tickers',
            'selectedUpazila',
            'featuredEmergency',
            'doctors',
            'products',
            'homemadeFoods',
            'workers',
            'jobs',
            'places',
            'dailyPrices',
            'stats',
            'activeAd'
        ));
    }

    public function emergency(Request $request)
    {
        $category = $request->query('category');
        $upazilaSlug = $request->query('upazila');

        $query = EmergencyService::with('upazila');
        if ($category) {
            $query->where('category', $category);
        }
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $services = $query->paginate(12)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.emergency', compact('services', 'upazilas', 'category', 'upazilaSlug'));
    }

    public function blood(Request $request)
    {
        $search = trim($request->query('search', ''));
        $group = $request->query('group');
        $upazilaSlug = $request->query('upazila');
        $fitness = $request->query('fitness', 'all');
        $sort = $request->query('sort', 'fit_first');

        $cutoffDate = now()->subDays(90);

        $query = BloodDonor::with('upazila')->where('is_available', true);

        // Search by Name, Mobile Number or Location
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by Blood Group
        if ($group) {
            $query->where('blood_group', $group);
        }

        // Filter by Upazila
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        // Filter by Donation Fitness (Date-wise)
        if ($fitness === 'fit') {
            $query->where(function ($q) use ($cutoffDate) {
                $q->whereNull('last_donated_at')
                  ->orWhere('last_donated_at', '<=', $cutoffDate);
            });
        } elseif ($fitness === 'resting') {
            $query->whereNotNull('last_donated_at')
                  ->where('last_donated_at', '>', $cutoffDate);
        }

        // Sorting
        if ($sort === 'latest_donation') {
            $query->orderByDesc('last_donated_at');
        } elseif ($sort === 'newest') {
            $query->latest();
        } else {
            // Default: 'fit_first' - show fit donors on top, then resting
            $query->orderByRaw("CASE WHEN last_donated_at IS NULL OR last_donated_at <= ? THEN 0 ELSE 1 END", [$cutoffDate])
                  ->orderByRaw("CASE WHEN last_donated_at IS NULL THEN 0 ELSE 1 END")
                  ->orderBy('last_donated_at', 'asc');
        }

        $donors = $query->paginate(12)->withQueryString();
        $upazilas = Upazila::all();
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        // Live Blood Bank Counts
        $stats = [
            'total' => BloodDonor::where('is_available', true)->count(),
            'fit' => BloodDonor::where('is_available', true)->where(function ($q) use ($cutoffDate) {
                $q->whereNull('last_donated_at')->orWhere('last_donated_at', '<=', $cutoffDate);
            })->count(),
            'resting' => BloodDonor::where('is_available', true)->whereNotNull('last_donated_at')->where('last_donated_at', '>', $cutoffDate)->count(),
        ];

        return view('services.blood', compact(
            'donors', 
            'upazilas', 
            'bloodGroups', 
            'group', 
            'upazilaSlug', 
            'search', 
            'fitness', 
            'sort',
            'stats'
        ));
    }

    public function storeBloodDonor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'blood_group' => 'required|string|max:5',
            'phone' => 'required|string|max:20',
            'upazila_id' => 'required|exists:upazilas,id',
            'location' => 'required|string|max:150',
            'last_donated_at' => 'nullable|date',
        ]);

        $validated['is_available'] = true; // Auto approved as active donor
        BloodDonor::create($validated);

        return back()->with('success', 'রক্তদাতা হিসেবে সফলভাবে নিবন্ধিত হয়েছেন! আপনার প্রোফাইলটি সরাসরি রক্ত ব্যাংক তালিকায় যুক্ত হয়েছে।');
    }

    public function doctors(Request $request)
    {
        $specialty = $request->query('specialty');
        $upazilaSlug = $request->query('upazila');

        $query = Doctor::with('upazila');
        if ($specialty) {
            $query->where('specialty', 'like', "%{$specialty}%");
        }
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $doctors = $query->paginate(12)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.doctors', compact('doctors', 'upazilas', 'specialty', 'upazilaSlug'));
    }

    public function shop(Request $request)
    {
        $category = $request->query('category');
        $upazilaSlug = $request->query('upazila');

        $query = Product::with('upazila')->where('in_stock', true);
        if ($category) {
            $query->where('category', $category);
        }
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $products = $query->paginate(12)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.shop', compact('products', 'upazilas', 'category', 'upazilaSlug'));
    }

    public function workers(Request $request)
    {
        $category = $request->query('category');
        $upazilaSlug = $request->query('upazila');

        $query = Worker::with('upazila')->where('is_available', true);
        if ($category) {
            $query->where('category', 'like', "%{$category}%");
        }
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $workers = $query->paginate(12)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.workers', compact('workers', 'upazilas', 'category', 'upazilaSlug'));
    }

    public function jobs(Request $request)
    {
        $upazilaSlug = $request->query('upazila');

        $query = JobPost::with('upazila')->where('is_active', true);
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.jobs', compact('jobs', 'upazilas', 'upazilaSlug'));
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'company_name' => 'required|string|max:150',
            'salary' => 'nullable|string|max:50',
            'deadline' => 'nullable|string|max:50',
            'contact_phone' => 'required|string|max:20',
            'upazila_id' => 'required|exists:upazilas,id',
            'requirements' => 'nullable|string',
        ]);

        $validated['is_active'] = true; // Auto approved
        JobPost::create($validated);

        return back()->with('success', 'চাকরির বিজ্ঞপ্তিটি সফলভাবে তাৎক্ষণিক প্রকাশিত হয়েছে!');
    }

    public function marketPrices()
    {
        $prices = DailyPrice::all()->groupBy('category');
        return view('services.prices', compact('prices'));
    }

    public function places(Request $request)
    {
        $category = $request->query('category');
        $upazilaSlug = $request->query('upazila');

        $query = TouristPlace::with('upazila');
        if ($category) {
            $query->where('category', 'like', "%{$category}%");
        }
        if ($upazilaSlug) {
            $upazila = Upazila::where('slug', $upazilaSlug)->first();
            if ($upazila) {
                $query->where('upazila_id', $upazila->id);
            }
        }

        $places = $query->paginate(8)->withQueryString();
        $upazilas = Upazila::all();

        return view('services.places', compact('places', 'upazilas', 'category', 'upazilaSlug'));
    }

    public function search(Request $request)
    {
        $q = trim($request->query('q', ''));
        if (empty($q)) {
            return redirect()->route('home');
        }

        $emergency = EmergencyService::with('upazila')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('details', 'like', "%{$q}%")
            ->take(5)->get();

        $doctors = Doctor::with('upazila')
            ->where('name', 'like', "%{$q}%")
            ->orWhere('specialty', 'like', "%{$q}%")
            ->orWhere('hospital_chamber', 'like', "%{$q}%")
            ->take(5)->get();

        $products = Product::with('upazila')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->take(5)->get();

        $workers = Worker::with('upazila')
            ->where('name', 'like', "%{$q}%")
            ->orWhere('category', 'like', "%{$q}%")
            ->take(5)->get();

        $jobs = JobPost::with('upazila')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('company_name', 'like', "%{$q}%")
            ->take(5)->get();

        $donors = BloodDonor::with('upazila')->where('is_available', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('blood_group', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%")
                      ->orWhere('location', 'like', "%{$q}%");
            })
            ->take(6)->get();

        $places = TouristPlace::with('upazila')
            ->where('name', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->orWhere('location', 'like', "%{$q}%")
            ->take(4)->get();

        return view('search', compact('q', 'emergency', 'doctors', 'products', 'workers', 'jobs', 'donors', 'places'));
    }
}

