<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
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
        $user = $request->user()?->load('avatar');

        return array_merge(parent::share($request), [
            'auth.user' => fn () => $user ? $user->only('id', 'first_name', 'last_name', 'email') : null,
            'auth.avatar' => fn () => $user && $user->avatar && Storage::disk('public')->exists($user->avatar->path) ? $user->avatar->only('path', 'alt') : null,
            'auth.permissions' => fn () => $user ? $user->getAllPermissions()->pluck('name')->toArray() : [],

            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
                'warning' => fn() => $request->session()->get('warning'),
                'info' => fn() => $request->session()->get('info'),
            ],

            'KPI' => function () {
                $routeName = Route::current()?->getName();

                if (str_starts_with($routeName, 'users')) {
                    $now = Carbon::now();
                    $last30Days = $now->copy()->subDays(30);
                    $last6Months = $now->copy()->subMonths(6);

                    $userCount = User::count();
                    $newUserCount = User::where('created_at', '>=', $last30Days)
                        ->count();
                    $activeUserCount = User::where('last_login', '>=', $last30Days)
                        ->count();
                    $retentionBase = User::where('created_at', '>=', $last6Months)
                        ->count();
                    $retentionCount = User::where('created_at', '>=', $last6Months)
                        ->whereRaw('last_login >= DATE_ADD(created_at, INTERVAL 14 DAY)')
                        ->count();

                    $retentionRate = $retentionBase > 0
                        ? round(($retentionCount / $retentionBase) * 100, 1)
                        : 0;

                    return [
                        'userCount' => $userCount,
                        'newUserCount' => $newUserCount,
                        'activeUserCount' => $activeUserCount,
                        'retentionRate' => $retentionRate,
                    ];
                }
            }
        ]);
    }
}
