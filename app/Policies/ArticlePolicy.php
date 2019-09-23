<?php

declare(strict_types=1);

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ArticlePolicy.
 * phpcs:disable
 */
class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the article.
     *
     * @param User    $user    User.
     * @param Article $article Article.
     *
     * @return boolean
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param User    $user    User.
     * @param Article $article Article.
     *
     * @return boolean
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}
