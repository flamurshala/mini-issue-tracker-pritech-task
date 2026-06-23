<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\Request;

class IssueTagController extends Controller
{
    public function attach(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'tag_id' => ['required', 'exists:tags,id'],
        ]);

        $issue->tags()->syncWithoutDetaching([$validated['tag_id']]);

        $tag = Tag::findOrFail($validated['tag_id']);

        return response()->json([
            'message' => 'Tag attached successfully.',
            'tag' => $tag,
        ]);
    }

    public function detach(Issue $issue, Tag $tag)
    {
        $issue->tags()->detach($tag->id);

        return response()->json([
            'message' => 'Tag detached successfully.',
            'tag_id' => $tag->id,
        ]);
    }
}
