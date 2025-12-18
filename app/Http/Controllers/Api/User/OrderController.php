<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::with('items')->where('user_id', Auth::user()->id)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The Cart is empty',
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $total = 0;
            foreach ($cart->items as $item) {
                $total += $item->price * $item->qty;
            }

            // Create order 
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => $total
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price
                ]);
                $product = Product::find($item->product_id);
                $product->stock -= $item->qty;
                $product->save();
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order successfully',
                'order_id' => $order
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
