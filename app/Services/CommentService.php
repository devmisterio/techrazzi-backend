<?php

namespace App\Services;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Support\Collection;

/**
 * Class CommentService
 *
 * Service class for handling logic operations related to comments.
 */
class CommentService
{
    /**
     * @var CommentRepositoryInterface
     */
    protected CommentRepositoryInterface $commentRepository;

    /**
     * CommentService constructor.
     *
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(CommentRepositoryInterface $commentRepository) {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Create a new comment.
     *
     * @param array $data
     * @return Comment|bool
     */
    public function createComment(array $data): Comment|bool
    {
        $comment = $this->commentRepository->save($data);

        if ($comment) {
            return $comment->load('user');
        }

        return false;
    }

    /**
     * Get all comments of a specific user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserComments(int $userId): Collection
    {
        return $this->commentRepository->getUserComments($userId);
    }
}
