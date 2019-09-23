<?php

declare(strict_types=1);

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class CommentPolicy.
 * phpcs:disable
 */
class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the comment.
     *
     * @param User    $user    User.
     * @param Comment $comment Comment.
     *
     * @return boolean
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param User    $user    User.
     * @param Comment $comment Comment.
     *
     * @return boolean
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
