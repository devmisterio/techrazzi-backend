<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentController
 *
 * Controller for handling comment related requests.
 */
class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    protected CommentService $commentService;

    /**
     * CommentController constructor.
     *
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }

    /**
     * Store a new comment.
     *
     * @param StoreCommentRequest $request
     * @return CommentResource|JsonResponse
     */
    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $comment = $this->commentService->createComment($data);

        if ($comment) {
            return new CommentResource($comment);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment.'
            ], 500);
        }
    }

    /**
     * Get all comments of the authenticated user.
     *
     * @return JsonResource
     */
    public function userComments(): JsonResource
    {
        $userId = Auth::id();
        $comments = $this->commentService->getUserComments($userId);

        return CommentResource::collection($comments);
    }
}
