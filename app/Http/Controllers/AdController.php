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

        $validated['status'] = 'pending';
        $validated['placement'] = 'top_banner';

        Advertisement::create($validated);

        return back()->with('success', 'আপনার বিজ্ঞাপনের আবেদন সফলভাবে জমা হয়েছে! আমাদের বিজ্ঞাপন টিম শীঘ্রই আপনার সাথে যোগাযোগ করবে।');
    }

    // Admin methods
    public function toggleStatus($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) abort(403);

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
        if (!Auth::check() || !Auth::user()->isAdmin()) abort(403);
        Advertisement::findOrFail($id)->delete();
        return back()->with('success', 'বিজ্ঞাপন মুছে ফেলা হয়েছে।');
    }
}

