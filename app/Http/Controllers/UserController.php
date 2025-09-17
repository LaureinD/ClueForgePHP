<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::paginate(10);

        return inertia('admin/users/Index', $users);
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
