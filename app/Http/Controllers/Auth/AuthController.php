<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authenticating requests
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->only('index', 'show', 'me', 'update', 'store', 'destroy');
    }

    /**
     * Login user request
     * @param Request $request
     * @return array
     * @throws AuthenticationException
     */
    public function api_login(Request $request): array
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth::guard()->attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();

            // sync user roles
            $this->syncUserRoles($user);

            return ['token' => $user->createToken('token-' . $user->id)->plainTextToken];
        } else {
            throw new AuthenticationException();
        }
    }

    /**
     * Logout user request
     */
    public function logout(): array
    {
        auth()->guard()->user()->currentAccessToken()->delete();
        return ['operation' => 'successful'];
    }

    /**
     * @authenticated
     */
    public function me(): UserResource
    {
        $this->syncUserRoles(auth()->guard()->user());

        return new UserResource(auth()->guard()->user());
    }

    /**
     * Create a sub-user
     * @authenticated
     */
    public function store(UserRequest $request): UserResource|JsonResponse
    {
        if (auth()->guard()->user()->role < User::USER_SUPER_ADMIN_ROLE) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }
        $user = User::create([
            'name' => $request->name,
            'parent_id' => auth()->guard()->user()->parent_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        $this->syncUserRoles($user);

        return new UserResource($user);
    }

    /**
     * Update the specified User.
     * @authenticated
     * @param UserRequest $request
     * @param User $user
     * @return UserResource|JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if (auth()->guard()->user()->role < User::USER_SUPER_ADMIN_ROLE &&
            auth()->guard()->user()->id != $user->id) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        $req = $request->only(
            'name'
        );

        if (auth()->guard()->user()->role == User::USER_SUPER_ADMIN_ROLE) {
            $req['role'] = $request->role;
        }

        if ($request->has('email')) {
            if ($user->email != $request->email) {
                $req['email'] = $request->email;
            }
        }


        $user->update($req);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $this->syncUserRoles($user);

        return new UserResource($user);
    }

    /**
     * Display a listing of the Users.
     * @authenticated
     */
    public function index()
    {
        return UserResource::collection(
            User::query()
                ->where('id', auth()->guard()->user()->id)
                ->orWhere('parent_id', auth()->guard()->user()->id)
                ->orWhere('parent_id', auth()->guard()->user()->parent_id)
                ->get()
        );
    }


    /**
     * Display the specified User.
     * @param User $user
     * @return UserResource|JsonResponse
     * @authenticated
     */
    public function show(User $user)
    {
        if (
            (
                auth()->guard()->user()->id == $user->id ||
                auth()->guard()->user()->id == $user->parent_id ||
                auth()->guard()->user()->parent_id == $user->parent_id
            )
        ) {
            return new UserResource($user);
        } else {
            return response()->json(['error' => 'Not authorized.'], 403);
        }


    }

    /**
     * Remove the specified User.
     * @authenticated
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        if (
            (
                auth()->guard()->user()->role < User::USER_SUPER_ADMIN_ROLE &&
                (
                    $user->parent_id == auth()->guard()->user()->parent_id ||
                    $user->parent_id == auth()->guard()->user()->id
                )
            ) ||
            $user->parent_id == auth()->guard()->user()->id
        ) {
            return response()->json(['error' => 'Not authorized.'], 403);
        }

        $user->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful',
        ]);

    }

    /**
     * @param User $user
     * @return void
     */
    public function syncUserRoles(User $user): void
    {
        if ($user->role == User::USER_SUPER_ADMIN_ROLE) {
            $user->syncRoles(User::USER_SUPER_ADMIN_ROLE_NAME);
        } else if ($user->role == User::USER_ADMINISTRATOR_ROLE) {
            $user->syncRoles(User::USER_ADMINISTRATOR_ROLE_NAME);
        } else if ($user->role == User::USER_SECOND_ADMINISTRATOR_ROLE) {
            $user->syncRoles(User::USER_SECOND_ADMINISTRATOR_ROLE_NAME);
        } else if ($user->role == User::USER_EDITOR_ROLE) {
            $user->syncRoles(User::USER_EDITOR_ROLE_NAME);
        } else if ($user->role == User::USER_LIMITED_ROLE) {
            $user->syncRoles(User::USER_LIMITED_ROLE_NAME);
        }
    }
}
