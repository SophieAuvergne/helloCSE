<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Profile $profile): JsonResponse
    {
        if ($profile->comments()->where('admin_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Comment already exists.'], 403);
        }

        $comment = $profile->comments()->create([
            'comment' => $request->get('comment'),
            'admin_id' => auth()->id(),
            'profile_id' => $profile->id
        ]);

        return response()->json(['comment' => $comment], 201);
    }
}
