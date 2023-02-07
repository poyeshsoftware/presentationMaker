<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed id
 * @property mixed email
 * @property mixed password
 * @property mixed role
 * @property mixed parent_id
 * @property mixed $rule_num
 * @method static where(string $string, mixed $email)
 * @method static create(array $array)
 * @method static get()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // User Roles (for Spatie\Permission)
    const USER_SUPER_ADMIN_ROLE = 10;
    const USER_SUPER_ADMIN_ROLE_NAME = "Super Administrator";
    const USER_ADMINISTRATOR_ROLE = 9;
    const USER_ADMINISTRATOR_ROLE_NAME = "Administrator";
    const USER_SECOND_ADMINISTRATOR_ROLE = 8;
    const USER_SECOND_ADMINISTRATOR_ROLE_NAME = "Second Level Administrator";
    const USER_EDITOR_ROLE = 6;
    const USER_EDITOR_ROLE_NAME = "Editor";
    const USER_LIMITED_ROLE = 3;
    const USER_LIMITED_ROLE_NAME = "Limited";

    // User Features and Permissions
    const USER_FEATURE_PROJECT = "project";
    const USER_FEATURE_REFERENCE = "reference";
    const USER_FEATURE_TRACKING = "tracking";
    const USER_FEATURE_PERMISSION_READ = 0;
    const USER_FEATURE_PERMISSION_READ_WRITE = 1;
    const USER_FEATURE_PERMISSION_READ_WRITE_DELETE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'parent_id',
        'name',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the parent user for the user.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the projects the user owns.
     */
    public function projects(): HasMany
    {
        if ($this->role == self::USER_SUPER_ADMIN_ROLE || $this->role == self::USER_ADMIN_ROLE) {
            return $this->hasMany(Project::class, 'user_project_id');
        } else {
            return $this->hasMany(Project::class, 'user_id');
        }
    }


    public function accessGrantedProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * @param User $user
     * @param Project $project
     * @param $permission
     * @param $feature
     * @return bool
     */
    public static function userProjectAuthCheck(User $user, Project $project, $permission,$feature): bool
    {
        if ($user->id === $project->user_id) {
            return true;
        } elseif ($user->id === $project->project_user_id) {
            return true;
        } elseif ($user->parent_id === $project->project_user_id && $user->rule_num >= User::USER_EDITOR_ROLE) {
            return true;
        } else if (
            $project->users()->where('user_id', $user->id)
                ->wherePivot("permission", ">=", $permission)
                ->wherePivot("feature", $feature)
                ->exists()
        ) {
            return true;
        } else {
            return false;
        }
    }
}
