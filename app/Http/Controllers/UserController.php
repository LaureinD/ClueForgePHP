<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
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
            ->when($request->search, function ($query) use ($request) {
                $search = '%' . $request->search . '%';
                $query
                    ->where('first_name','like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })
            ->when($request->boolean('showDeleted'), function ($query) {
                $query->withTrashed();
            })
            ->paginate(10)
            ->withQueryString();

        return inertia('admin/users/Index', [
            'filters' => [
                'search' => $request->search,
                'showDeleted' => $request->boolean('showDeleted'),
            ],
            'KPI' => [
                'userCount' => $userCount,
                'newUserCount' => $newUserCount,
                'activeUserCount' => $activeUserCount,
                'retentionRate' => $retentionRate,
            ],
            'users' => $users,
        ]);
    }


    public function store()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function bulkDelete(Request $request)
    {
        if (!$request->has('users') || !is_array($request->users) || empty($request->users)) {
            return redirect()->back()->with('error', 'No users selected.');
        }
        $users = User::whereIn('id', $request->users)->get();
        $deletedCount = 0;
        $adminCount = 0;

        foreach ($users as $user) {
            if ($user->id === 2) {
                $adminCount++;
            } else {
                $user->delete();
                $deletedCount++;
            }
        }

        $message = $deletedCount.($deletedCount === 1 ? ' user' : ' users').' deleted.';
        $adminError = 'Couldn\'t delete '.$adminCount.($adminCount === 1 ? ' user' : ' users').' for having admin rights.';

        $redirect = redirect()->back();

        if ($deletedCount > 0) {
            $redirect->with('success', ['message' => $deletedCount > 0 ? $message : '',]);
        }

        if ($adminCount > 0) {
            $redirect->with('error', ['message' => $adminCount > 0 ? $adminError : '', 'autoClose' => false]);
            //todo: add list of users that were not deleted. (integrate 'more info' modal in flashMessage?)
        }

        return $redirect;
    }

    public function restore()
    {

    }

    public function bulkRestore(Request $request)
    {
        if (!$request->has('users') || !is_array($request->users) || empty($request->users)) {
            return redirect()->back()->with('error', ['message' => 'No users selected.',]);
        }

        $restoredCount = User::whereIn('id', $request->users)->restore();

        return redirect()->back()->with('success', ['message' => $restoredCount.($restoredCount === 1 ? ' user' : ' users').' restored.',]);
    }

    public function forceDelete()
    {

    }
}
