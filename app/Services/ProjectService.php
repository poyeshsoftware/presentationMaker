<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ProjectService
{
    /**
     * @param User $user
     * @param Builder $query
     * @return Builder
     */
    public function getProjectsForUser(User $user, Builder $query): Builder
    {
        return $query->where(
            function (Builder $builder) use ($user) {


                if ($user->hasRole(User::USER_SUPER_ADMIN_ROLE_NAME)) {
                    return $builder;

                } elseif ($user->hasRole(User::USER_ADMINISTRATOR_ROLE_NAME)) {

                    return $builder->where('project_user_id', $user->id);

                } elseif ($user->hasRole(User::USER_SECOND_ADMINISTRATOR_ROLE_NAME)) {

                    return $builder->where('project_user_id', $user->parent_id);

                } elseif ($user->hasRole(User::USER_EDITOR_ROLE_NAME) || $user->hasRole(User::USER_LIMITED_ROLE_NAME)) {

                    return
                        $builder->where(
                            function (Builder $subQuery) use ($user) {
                                $subQuery->where('project_user_id', $user->parent_id)
                                    ->where('user_id', $user->id);
                            })->orWhereHas("users"
                            , function (Builder $subQuery) use ($user) {
                                $subQuery->where('user_id', $user->id)
                                    ->where('feature', User::USER_FEATURE_PROJECT)
                                    ->where('permission', ">=", User::USER_FEATURE_PERMISSION_READ);
                            });
                } else {
                    return $builder;
                }

            });
    }
}
