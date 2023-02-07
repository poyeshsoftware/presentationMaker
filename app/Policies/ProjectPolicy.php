<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
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
     * @param Project $project
     * @return Response|bool
     */
    public function view(User $user, Project $project): Response|bool
    {
        return User::userProjectAuthCheck($user, $project, User::USER_FEATURE_PERMISSION_READ, User::USER_FEATURE_PROJECT)
            ? Response::allow()
            : Response::deny(trans('auth.You are not authorized to view this project.'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->rule_num >= User::USER_EDITOR_ROLE
            ? Response::allow()
            : Response::deny(trans('auth.You are not authorized to create a project.'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Project $project
     * @return Response|bool
     */
    public function update(User $user, Project $project): Response|bool
    {
        return User::userProjectAuthCheck($user, $project, User::USER_FEATURE_PERMISSION_READ_WRITE, User::USER_FEATURE_PROJECT)
            ? Response::allow()
            : Response::deny(trans('auth.You are not authorized to update this project.'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return Response|bool
     */
    public function delete(User $user, Project $project): Response|bool
    {
        return User::userProjectAuthCheck($user, $project, User::USER_FEATURE_PERMISSION_READ_WRITE_DELETE, User::USER_FEATURE_PROJECT)
            ? Response::allow()
            : Response::deny(trans('auth.You are not authorized to delete this project.'));
    }
}
