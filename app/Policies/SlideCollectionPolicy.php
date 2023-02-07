<?php

namespace App\Policies;

use App\Models\SlideCollection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SlideCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param SlideCollection $slideCollection
     * @return Response|bool
     */
    public function view(User $user, SlideCollection $slideCollection): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param SlideCollection $slideCollection
     * @return Response|bool
     */
    public function update(User $user, SlideCollection $slideCollection): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param SlideCollection $slideCollection
     * @return Response|bool
     */
    public function delete(User $user, SlideCollection $slideCollection): Response|bool
    {
        return true;
    }
}
