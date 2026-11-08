<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Upazila;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        $price = $product->discount_price ?? $product->price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => (float)$price,
                'unit' => $product->unit,
                'seller_name' => $product->seller_name,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            $count = array_sum(array_column($cart, 'quantity'));
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            return response()->json([
                'success' => true,
                'message' => 'পণ্যটি কার্টে যুক্ত করা হয়েছে!',
                'cart' => $cart,
                'count' => $count,
                'subtotal' => $subtotal,
            ]);
        }

        return back()->with('success', 'পণ্যটি সফলভাবে কার্টে যুক্ত হয়েছে!');
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $action = $request->input('action'); // 'increase' or 'decrease'

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease') {
                $cart[$productId]['quantity']--;
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);
        }

        return back();
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'পণ্যটি কার্ট থেকে সরানো হয়েছে।');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'আপনার কার্ট খালি। অনুগ্রহ করে পণ্য যুক্ত করুন।');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
            'upazila_id' => 'required|exists:upazilas,id',
            'notes' => 'nullable|string',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryCharge = 50.00;
        $totalAmount = $subtotal + $deliveryCharge;

        $orderNumber = 'NSB-' . strtoupper(Str::random(6));

        $order = Order::create([
            'order_number' => $orderNumber,
            'upazila_id' => $validated['upazila_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'delivery_address' => $validated['delivery_address'],
            'subtotal' => $subtotal,
            'delivery_charge' => $deliveryCharge,
            'total_amount' => $totalAmount,
            'payment_method' => 'cash_on_delivery',
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_title' => $item['title'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.success', ['orderNumber' => $orderNumber]);
    }

    public function orderSuccess($orderNumber)
    {
        $order = Order::with(['items', 'upazila'])->where('order_number', $orderNumber)->firstOrFail();
        return view('services.order-success', compact('order'));
    }
}

