<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsTicker;
use App\Models\DailyPrice;
use App\Models\EmergencyService;
use App\Models\Doctor;
use App\Models\BloodDonor;
use App\Models\Product;
use App\Models\Worker;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'অননুমোদিত প্রবেশাধিকার। শুধুমাত্র সুপার অ্যাডমিন এই অ্যাকশন নিতে পারবেন।');
        }
    }

    private function ensurePermission(string $permission)
    {
        if (!Auth::check() || !Auth::user()->hasPermission($permission)) {
            abort(403, 'অননুমোদিত প্রবেশাধিকার। আপনার এই বিভাগটি পরিচালনা করার অনুমতি নেই।');
        }
    }

    // 1. News Ticker Management
    public function storeTicker(Request $request)
    {
        $this->ensurePermission('manage_tickers');
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
        ]);
        $validated['is_active'] = true;
        NewsTicker::create($validated);
        return back()->with('success', 'নতুন ব্রেকিং নিউজ টিকার সফলভাবে যুক্ত হয়েছে!');
    }

    public function toggleTicker($id)
    {
        $this->ensurePermission('manage_tickers');
        $ticker = NewsTicker::findOrFail($id);
        $ticker->is_active = !$ticker->is_active;
        $ticker->save();
        return back()->with('success', 'টিকার স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }

    public function deleteTicker($id)
    {
        $this->ensurePermission('manage_tickers');
        NewsTicker::findOrFail($id)->delete();
        return back()->with('success', 'টিকার সফলভাবে মুছে ফেলা হয়েছে।');
    }

    // 2. Daily Market Price Management
    public function storePrice(Request $request)
    {
        $this->ensurePermission('manage_prices');
        $validated = $request->validate([
            'item_name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'price' => 'required|string|max:20',
            'unit' => 'required|string|max:20',
            'trend' => 'required|in:স্থির,বাড়ছে,কমছে',
        ]);
        DailyPrice::create($validated);
        return back()->with('success', 'নতুন পণ্যের বাজারদর সফলভাবে যুক্ত হয়েছে!');
    }

    public function updatePrice(Request $request, $id)
    {
        $this->ensurePermission('manage_prices');
        $price = DailyPrice::findOrFail($id);
        $price->update($request->only(['price', 'trend']));
        return back()->with('success', 'বাজারদর সফলভাবে হালনাগাদ করা হয়েছে।');
    }

    public function deletePrice($id)
    {
        $this->ensurePermission('manage_prices');
        DailyPrice::findOrFail($id)->delete();
        return back()->with('success', 'বাজারদর থেকে পণ্য মুছে ফেলা হয়েছে।');
    }

    // 3. Emergency Service Management
    public function storeEmergency(Request $request)
    {
        $this->ensurePermission('manage_emergency');
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string',
            'phone' => 'required|string|max:20',
            'upazila_id' => 'required|exists:upazilas,id',
            'address' => 'nullable|string',
            'details' => 'nullable|string',
        ]);
        $validated['is_featured'] = true;
        EmergencyService::create($validated);
        return back()->with('success', 'নতুন জরুরি সেবা নম্বর সফলভাবে যুক্ত হয়েছে!');
    }

    public function deleteEmergency($id)
    {
        $this->ensurePermission('manage_emergency');
        EmergencyService::findOrFail($id)->delete();
        return back()->with('success', 'জরুরি সেবা নম্বর মুছে ফেলা হয়েছে।');
    }

    // 4. Doctor Management
    public function storeDoctor(Request $request)
    {
        $this->ensurePermission('manage_doctors');
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'specialty' => 'required|string|max:100',
            'degree' => 'required|string|max:150',
            'hospital_chamber' => 'required|string|max:200',
            'visiting_time' => 'required|string|max:150',
            'serial_phone' => 'required|string|max:20',
            'fee' => 'nullable|string|max:50',
            'upazila_id' => 'required|exists:upazilas,id',
        ]);
        Doctor::create($validated);
        return back()->with('success', 'নতুন বিশেষজ্ঞ ডাক্তার সফলভাবে যুক্ত হয়েছেন!');
    }

    public function deleteDoctor($id)
    {
        $this->ensurePermission('manage_doctors');
        Doctor::findOrFail($id)->delete();
        return back()->with('success', 'ডাক্তারের তথ্য মুছে ফেলা হয়েছে।');
    }

    // 5. Blood Donor Management
    public function deleteDonor($id)
    {
        $this->ensurePermission('manage_blood');
        BloodDonor::findOrFail($id)->delete();
        return back()->with('success', 'রক্তদাতার তথ্য মুছে ফেলা হয়েছে।');
    }

    // 6. Product Management
    public function storeProduct(Request $request)
    {
        $this->ensurePermission('manage_products');
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string',
            'seller_name' => 'required|string|max:100',
            'seller_phone' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:20',
            'description' => 'nullable|string',
            'upazila_id' => 'nullable|exists:upazilas,id',
        ]);
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(1000, 9999);
        $validated['in_stock'] = true;
        Product::create($validated);
        return back()->with('success', 'নতুন পণ্য সফলভাবে শপে যুক্ত হয়েছে!');
    }

    public function deleteProduct($id)
    {
        $this->ensurePermission('manage_products');
        Product::findOrFail($id)->delete();
        return back()->with('success', 'পণ্য মুছে ফেলা হয়েছে।');
    }

    // 7. Job Moderation
    public function toggleJob($id)
    {
        $this->ensurePermission('manage_jobs');
        $job = JobPost::findOrFail($id);
        $job->is_active = !$job->is_active;
        $job->save();
        return back()->with('success', 'চাকরির বিজ্ঞপ্তির স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }

    public function deleteJob($id)
    {
        $this->ensurePermission('manage_jobs');
        JobPost::findOrFail($id)->delete();
        return back()->with('success', 'চাকরির বিজ্ঞপ্তি মুছে ফেলা হয়েছে।');
    }

    // 8. Order Delivery & Status Management
    public function updateOrderStatus(Request $request, $id)
    {
        $this->ensurePermission('manage_orders');
        $order = \App\Models\Order::findOrFail($id);
        $status = $request->input('status', 'pending');
        $order->status = $status;
        $order->save();

        return back()->with('success', "অর্ডার #{$order->id}-এর স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।");
    }

    // 9. User Roles & Permission Management (Super Admin only)
    public function updateUserPermissions(Request $request, $id)
    {
        $this->ensureAdmin();
        $targetUser = User::findOrFail($id);

        // Prevent self-demotion from super admin
        if ($targetUser->id === Auth::id() && $request->input('role') !== 'admin') {
            return back()->with('error', 'আপনি নিজের সুপার অ্যাডমিন রোল বাতিল করতে পারবেন না।');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,moderator,seller,user',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $targetUser->role = $validated['role'];
        if ($validated['role'] === 'admin') {
            $targetUser->permissions = ['*'];
        } elseif ($validated['role'] === 'moderator') {
            $targetUser->permissions = $validated['permissions'] ?? [];
        } else {
            $targetUser->permissions = [];
        }
        $targetUser->save();

        return back()->with('success', "ইউজার '{$targetUser->name}'-এর রোল ও পারমিশন সফলভাবে হালনাগাদ করা হয়েছে।");
    }
}
