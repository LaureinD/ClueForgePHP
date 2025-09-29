<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth.user' => function () use ($request) {
                $user = $request->user();
                if (!$user) return null;

                return $user->only('id', 'first_name', 'last_name', 'email');
            },
            'auth.avatar' => function () use ($request) {
                $user = $request->user();
                if (!$user) return null;

                $avatar = $user->avatar;
                if (!$avatar || !Storage::disk('public')->exists($avatar->path)) return null;

                return $avatar->only('path', 'alt');
            },
        ]);
    }
}
