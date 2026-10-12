<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): JsonResponse
    {
        $comment = $post->comments()->create($request->validated());

        return response()->json($comment, 201);
    }
}
