<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::with(['category', 'images', 'comments', 'tags'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('product created: ' . json_encode($request->all()));

        Log::info('Uploaded files:', ['files' => $request->files->all()['images']]);

        /*
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            "images" => "required|array",
            "images.*" => "required|image",
        ]);*/

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('images')) {
            $images = is_array($request->file('images')) ? $request->file('images') : [$request->file('images')];
    
            foreach ($images as $image) {
                try {
                    $imageUrl = $image->store('images');
                    $product->images()->create([
                        'url' => $imageUrl,
                    ]);
                    Log::info('Image uploaded successfully:', ['url' => $imageUrl]);
                } catch (\Exception $e) {
                    Log::error('Error uploading image:', ['error' => $e->getMessage()]);
                    return response()->json(['error' => 'Failed to upload image'], 500);
                }
            }
        }

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product->load(['category', 'images', 'comments', 'tags']);
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
