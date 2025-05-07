<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tag::with(['products', 'categories', 'orders'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tag = Tag::create($request->validate([
            'name' => 'required',
        ]));
        return response()->json($tag, 201);
    }

    public function attach(Request $request)
    {
        $tag = Tag::findOrFail($request->tag_id);
        $taggable = $request->taggable_type::findOrFail($request->taggable_id);
        $taggable->tags()->attach($tag->id);

        return response()->json([
            'message' => 'Tag attached successfully',
            'taggable' => $taggable,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
