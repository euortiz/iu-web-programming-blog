<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Post::query()->latest()->withCount('comments')->get()
        );
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json(
            $post->load('comments')->loadCount('comments')
        );
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $request->user()->posts()->create($request->validated());

        return response()->json($post, 201);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());

        return response()->json($post->fresh());
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
        ]);
    }
}
