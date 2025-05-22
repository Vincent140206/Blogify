<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article)
    {
        return true; // All users can view articles
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true; // Any authenticated user can create articles
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}