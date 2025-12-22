<?php

namespace App\Services;

use App\Repositories\CheckoutRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;


class CheckoutService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected CheckoutRepository $repo) {}

    public function checkout()
    {
        $cart = $this->repo->checkout();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception(
                'The Cart is empty'
            );
        }

        DB::beginTransaction();
        try {

            // Calculate total
            $total = $cart->items->sum(fn($item) => $item->price * $item->qty);


            // Create order 
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total
            ]);


            // Create order items
            foreach ($cart->items as $item) {

                $product = Product::findOrFail($item->product_id);

                // check stock cuz what if two customer order the same product
                if ($product->stock < $item->qty) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                // create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price
                ]);

                // decrement stock after create order item
                $product->decrement('stock', $item->qty);
            }
            // Clear cart
            $cart->items()->delete();

            // insert to database
            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw new \Exception('Order creation failed: ' . $e->getMessage());
        }
    }

    public function orderList($perPage)
    {
        $order = $this->repo->orderList($perPage);

        return $order;
    }

    public function updateOrder($id, array $data)
    {
        return $this->repo->updateOrder($id, $data);
    }
}
