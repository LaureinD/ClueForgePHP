<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index()
    {
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

        $users = User::with('avatar')
            ->paginate(10);

        return inertia('admin/users/Index', [
            'KPI' => [
                'userCount' => $userCount,
                'newUserCount' => $newUserCount,
                'activeUserCount' => $activeUserCount,
                'retentionRate' => $retentionRate,
            ],
            'users' => $users,
        ]);
    }

    public function store() {

    }

    public function show() {

    }

    public function update() {

    }

    public function destroy() {

    }
}
