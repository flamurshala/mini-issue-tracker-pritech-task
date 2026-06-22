<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();

        return view('tags.index', compact('tags'));
    }

    public function store(StoreTagRequest $request)
    {
        Tag::create($request->validated());

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }
}
