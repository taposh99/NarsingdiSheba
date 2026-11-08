<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdPackage;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    public function index()
    {
        $packages = AdPackage::where('is_active', true)->get();
        return view('advertise', compact('packages'));
    }

    public function submitAdRequest(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:ad_packages,id',
            'business_name' => 'required|string|max:150',
            'client_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'title' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'target_url' => 'nullable|url|max:255',
        ]);

        $validated['status'] = 'active'; // Auto-approved as requested
        $validated['start_date'] = now();
        $validated['end_date'] = now()->addDays(30);
        $validated['placement'] = 'top_banner';

        Advertisement::create($validated);

        return back()->with('success', 'আপনার বিজ্ঞাপনটি সফলভাবে তাৎক্ষণিক প্রকাশিত হয়েছে এবং হোমপেজে যুক্ত হয়েছে!');
    }

    // Admin methods
    public function toggleStatus($id)
    {
        if (!Auth::check() || !Auth::user()->hasPermission('manage_ads')) {
            abort(403, 'বিজ্ঞাপন পরিচালনার অনুমতি নেই।');
        }

        $ad = Advertisement::findOrFail($id);
        if ($ad->status === 'active') {
            $ad->status = 'expired';
        } else {
            $ad->status = 'active';
            $ad->start_date = now();
            $ad->end_date = now()->addDays(30);
        }
        $ad->save();

        return back()->with('success', 'বিজ্ঞাপনের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
    }

    public function deleteAd($id)
    {
        if (!Auth::check() || !Auth::user()->hasPermission('manage_ads')) {
            abort(403, 'বিজ্ঞাপন পরিচালনার অনুমতি নেই।');
        }
        Advertisement::findOrFail($id)->delete();
        return back()->with('success', 'বিজ্ঞাপন মুছে ফেলা হয়েছে।');
    }
}

