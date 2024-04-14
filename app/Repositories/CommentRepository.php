<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class CommentRepository
 *
 * Repository for handling database operations related to comments.
 */
class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Save a new comment.
     *
     * @param array $data
     * @return Comment|bool
     */
    public function save(array $data): Comment|bool
    {
        try {
            return Comment::create($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    /**
     * Get all comments of a specific user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserComments(int $userId): Collection
    {
        try {
            return Comment::where('user_id', $userId)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching user comments: ' . $e->getMessage());
            return collect([]);
        }
    }
}
