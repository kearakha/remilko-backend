<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\RecipeCommentResource;
use App\Models\RecipeComment;

class RecipeCommentController extends Controller
{
    // comment
    public function getComments($recipe_id)
    {
        $comment = RecipeComment::where('recipe_id', $recipe_id)->with('user')->get();

        if ($comment->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No comments found for this recipe'
            ], 404);
        }

        return response()->json([
            'data' => [
                'comments' => RecipeCommentResource::collection($comment),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of comments',
            ],
            200
        ]);
    }

    public function addComment(Request $request, $recipe_id)
    {
        $user = JWTAuth::User();

        $validator = Validator::make($request->all(), [
            'comment_text' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $comment = RecipeComment::create([
            'id' => Str::random(8),
            'user_id' => $user->id,
            'recipe_id' => $recipe_id,
            'comment_text' => $validated['comment_text'],
        ]);

        return response()->json([
            'data' => [
                'comment' => new RecipeCommentResource($comment),
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Comment added successfully',
            ],
            200
        ]);
    }

    public function updateComment(Request $request, $recipe_id, $comment_id)
    {
        $comment = RecipeComment::where('recipe_id', $recipe_id)->find($comment_id);

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'comment_text' => 'sometimes|required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $comment->update($validated);

        return response()->json([
            'data' => [
                'comment' => new RecipeCommentResource($comment),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Comment updated successfully',
            ],
            200
        ]);
    }

    public function deleteComment($recipe_id, $comment_id)
    {
        $comment = RecipeComment::where('recipe_id', $recipe_id)->find($comment_id);

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found'
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Comment deleted successfully',
            ],
            200
        ]);
    }
}
