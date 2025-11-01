<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session('cart', []);
        $subtotal = array_reduce($cart, fn($s, $i) => $s + ($i['price'] * $i['quantity']), 0.0);
        return view('frontend.checkout', [
            'items' => array_values($cart),
            'subtotal' => $subtotal,
        ]);
    }

    public function place(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout.show')->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($cart, $request, &$order) {
            $subtotal = array_reduce($cart, fn($s, $i) => $s + ($i['price'] * $i['quantity']), 0.0);
            $tax = 0;
            $shipping = 0;
            $discount = 0;
            $total = $subtotal + $tax + $shipping - $discount;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(substr(uniqid(), -8)),
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'billing_address' => $request->address,
                'shipping_option' => $request->shipping ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_cost' => $shipping,
                'discount_amount' => $discount,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment ?? null,
                'payment_transaction_id' => $request->transactionId ?? null,
                'payment_number' => $request->paymentNumber ?? null,
            ]);

            foreach ($cart as $item) {
                $unit = $item['price'];
                $qty = $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'] ?? (Product::find($item['product_id'])->name ?? 'Product'),
                    'product_sku' => Product::find($item['product_id'])->sku ?? '',
                    'variant_color' => $item['color'] ?? null,
                    'variant_size' => $item['size'] ?? null,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'total_price' => $unit * $qty,
                ]);

                // Optional: reduce stock
                Product::where('id', $item['product_id'])->decrement('quantity', $qty);
            }
        });

        session()->forget('cart');

        return redirect('/')->with('success', 'Order placed successfully.');
    }
}
