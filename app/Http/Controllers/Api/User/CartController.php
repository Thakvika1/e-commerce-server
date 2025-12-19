<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    // check cart
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json([
                'status' => 'success',
                'cart' => [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'cart' => $cart,
        ]);
    }
    // add item to cart
    public function add($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found !!'
            ], 404);
        }

        // if cart exist get else create new cart with this user id
        $cart =  Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        // dd($cart);

        // check if item already exists
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            if ($cartItem->qty >= $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient stock for product ID ' . $product->id . '. Available quantity: ' . $product->stock
                ], 200);
            }
            $cartItem->qty++;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => 1,
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
        ]);
    }

    // update item in cart
    public function update(Request $request, $id)
    {

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }


        $cart = Cart::where('user_id', Auth::user()->id)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = cartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found',
            ], 404);
        }

        $cartItem->qty = $request->qty;
        if ($cartItem->qty > $product->stock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient stock for product ID ' . $product->id . '. Available quantity: ' . $product->stock
            ], 200);
        }

        $cartItem->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated'
        ], 200);
    }

    // remove item from cart
    public function remove($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }


        $cart = Cart::where('user_id', Auth::user()->id)->first();
        // dd($cart);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item remove success'
        ], 200);
    }
}
