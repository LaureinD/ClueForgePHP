<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $baseQuery = User::with('avatar');

        $userCount = (clone $baseQuery)->count();
        $newUserCount = (clone $baseQuery)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();
        $activeUserCount = (clone $baseQuery)
            ->where('last_login', '>=', Carbon::now()->subDays(30))
            ->count();
        $retentionCount = (clone $baseQuery)
            ->whereRaw('created_at >= NOW() - INTERVAL 30 DAY AND last_login > created_at + INTERVAL 14 DAY')
            ->count();
        $retentionRate = $newUserCount > 0
            ? number_format((($retentionCount / $newUserCount) * 100), 2,'.',' ')
            : 0;
        $usersPaginated = (clone $baseQuery)->paginate(10);

        return inertia('admin/users/Index', [
            'users'          => $usersPaginated,
            'userCount'      => $userCount,
            'newUserCount'   => $newUserCount,
            'activeUserCount'=> $activeUserCount,
            'retentionRate'  => $retentionRate,
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
