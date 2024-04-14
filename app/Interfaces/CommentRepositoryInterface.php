<?php

namespace App\Interfaces;

use App\Models\Comment;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function save(array $data): Comment|bool;
    public function getUserComments(int $userId): Collection;
}
