<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with(['user', 'products'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => 0,
        ]);

        $total = 0;

        foreach($request->products as $prod) {
            $product = Product::findOrFail($prod['product_id']);
            $order->products()->attach($product->id, [
                'quantity' => $prod['quantity'],
                'price' => $prod['price'],
            ]);
            $total += $prod['price'] * $prod['quantity'];
        }

        $order->update([
            'total' => $total,
        ]);

        return response()->json($order->load(['user', 'products']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order->load(['user', 'products', 'tags']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
