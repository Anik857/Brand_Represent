<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:100',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty = $data['quantity'] ?? 1;

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
            if (!empty($data['color'])) { $cart[$product->id]['color'] = $data['color']; }
            if (!empty($data['size'])) { $cart[$product->id]['size'] = $data['size']; }
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->main_image,
                'quantity' => $qty,
                'color' => $data['color'] ?? null,
                'size' => $data['size'] ?? null,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'count' => $this->countItems($cart),
        ]);
    }

    public function count()
    {
        $cart = session('cart', []);
        return response()->json(['count' => $this->countItems($cart)]);
    }

    public function items()
    {
        $cart = array_values(session('cart', []));
        $subtotal = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0.0);

        return response()->json([
            'items' => $cart,
            'subtotal' => round($subtotal, 2),
        ]);
    }

    private function countItems(array $cart): int
    {
        return array_sum(array_map(fn($i) => (int) ($i['quantity'] ?? 0), $cart));
    }
}


