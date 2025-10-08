<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('avatar', 'roles')
            ->when($request->search, function ($query) use ($request) {
                $search = '%' . $request->search . '%';
                $query
                    ->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })
            ->when($request->boolean('showDeleted'), function ($query) {
                $query->withTrashed();
            })
            ->paginate(10)
            ->withQueryString();

        $roles = Role::with('permissions')->get();

        $permissionCategories = Category::with([
            'permissions' => function($query) {
                $query->whereNot('name', 'like', 'forceDelete%');
            }
        ])
            ->whereHas('permissions')
            ->get();

        return inertia('admin/users/Index', [
            'filters' => [
                'search' => $request->search,
                'showDeleted' => $request->boolean('showDeleted'),
            ],
            'users' => $users,
            'roles' => $roles,
            'permissionCategories' => $permissionCategories,
        ]);
    }

    public function create()
    {
        // Integrated in Index
    }

    public function store(Request $request)
    {
        //todo: add strong password check (min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d\W])$/)
        $fields = $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'selectedRoles' => 'required|array|min:1',
            'selectedRoles.*' => 'string|exists:roles,name'
        ], [
            'avatar.image' => 'Only images are accepted.',
            'avatar.mimes' => 'Only images are accepted.',
            'avatar.max' => 'File exceeds 2MB size limit.',
        ]);

        $fields['first_name'] = ucfirst(strtolower($fields['first_name']));
        $fields['last_name'] = ucfirst(strtolower($fields['last_name']));

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => $fields['password'],
        ]);

        foreach($fields['selectedRoles'] as $role) {
            $user->assignRole($role);
        }

        $file = $request->file('avatar');
        if ($file) {
            $storagePath = $file->store('img/avatars', 'public');
            $fileType = $file->getClientMimeType();
            $fileSize = $file->getSize();

            $user->images()->create([
                'path' => $storagePath,
                'alt' => 'avatar '.$fields['first_name'].' '.$fields['last_name'],
                'type' => $fileType,
                'size' => $fileSize,
                'is_primary' => true,
            ]);
        }

        return redirect()
            ->back()
            ->with('success',['message' => "User created successfully: \n $user->first_name $user->last_name",]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => 'nullable|confirmed|min:6',
            'selectedRoles' => 'required|array|min:1',
            'selectedRoles.*' => 'string|exists:roles,name'
        ], [
            'avatar.image' => 'Only images are accepted.',
            'avatar.mimes' => 'Only images are accepted.',
            'avatar.max' => 'File exceeds 2MB size limit.',
        ]);

        $updateData = [
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
        ];

        if (!empty($fields['password'])) {
            $updateData['password'] = $fields['password'];
        }

        $user->update($updateData);



        $roleIds = Role::whereIn('name', $fields['selectedRoles'])->pluck('id');
        $user->roles()->sync($roleIds);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $user->avatar->delete();
            }

            $file = $request->file('avatar');
            if ($file) {
                $storagePath = $file->store('img/avatars', 'public');
                $fileType = $file->getClientMimeType();
                $fileSize = $file->getSize();

                $user->images()->create([
                    'path' => $storagePath,
                    'alt' => 'avatar '.$fields['first_name'].' '.$fields['last_name'],
                    'type' => $fileType,
                    'size' => $fileSize,
                    'is_primary' => true,
                ]);
            }
        }

        return redirect()
            ->back()
            ->with('success',['message' => "User updated successfully: \n $user->first_name $user->last_name",]);
    }

    public function delete(User $user)
    {
        try {
            $user->delete();

            return redirect()->back()->with('success', ['message' => "User successfully deleted: \n$user->first_name $user->last_name"]);

        } catch (\Exception $error) {
            return redirect()->back()->with('error', 'No valid user selected.');
        }
    }

    public function forceDelete()
    {

    }

    public function restore($userId)
    {
        try {
            $user = User::withTrashed()->findOrFail($userId);
            $user->restore();

            return redirect()->back()->with('success', ['message' => "User successfully restored: \n$user->first_name $user->last_name"]);

        } catch (\Illuminate\Validation\ValidationException $error) {
            return redirect()->back()->with('error', 'No valid user selected.');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:users,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $error) {
            return redirect()->back()->with('error', 'No valid users selected.');
        }

        $users = User::whereIn('id', $validated['ids'])->get();

        $deletedCount = 0;
        $errorCount = 0;

        foreach ($users as $user) {
            if ($user->hasRole('admin')) {
                $errorCount++;
                continue;
            }
            if ($user->trashed()) {
                $errorCount++;
                continue;
            }

            $user->delete();
            $deletedCount++;
        }

        $messages = [];
        if ($deletedCount > 0) {
            $messages['success'] = ['message' => "$deletedCount " . ($deletedCount === 1 ? 'user' : 'users') . " deleted."];
        }

        if ($errorCount > 0) {
            $messages['error'] = ['message' => "Couldn't delete $errorCount " . ($errorCount === 1 ? 'user' : 'users') . ".", 'autoClose' => false];
        }

        //todo: add list of users that were not deleted and why. (integrate 'more info' modal in flashMessage?)
        return redirect()->back()->with($messages);
    }

    public function bulkRestore(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:users,id',
            ]);

        } catch (\Illuminate\Validation\ValidationException $error) {
            return redirect()->back()->with('error', 'No valid users selected.');
        }

        $restoredCount = User::onlyTrashed()
            ->whereIn('id', $validated['ids'])
            ->restore();

        $message = "$restoredCount " . ($restoredCount === 1 ? 'user' : 'users') . " restored.";

        return redirect()->back()->with('success', ['message' => $message]);
    }
}
