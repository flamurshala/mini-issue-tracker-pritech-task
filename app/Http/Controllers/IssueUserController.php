<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachIssueUserRequest;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IssueUserController extends Controller
{
    public function attach(AttachIssueUserRequest $request, Issue $issue): JsonResponse
    {
        $validated = $request->validated();

        $issue->users()->syncWithoutDetaching([$validated['user_id']]);

        $user = User::findOrFail($validated['user_id']);

        return response()->json([
            'message' => 'User assigned successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function detach(Issue $issue, User $user): JsonResponse
    {
        $issue->users()->detach($user->id);

        return response()->json([
            'message' => 'User removed successfully.',
            'user_id' => $user->id,
        ]);
    }
}
