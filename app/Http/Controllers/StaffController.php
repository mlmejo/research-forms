<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(): View
    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin']);
        })->get();

        return view('staff.index', ['users' => $users]);
    }

    public function create(): View
    {
        return view('staff.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|unique:users|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|confirmed|string',
        ]);

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect(route('staff.index'));
    }

    public function edit(User $staff): View
    {
        return view('staff.edit', ['user' => $staff]);
    }

    public function update(Request $request, User $staff): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'first_name' => 'required|string',
            'middle_name' => 'sometimes|required|string',
            'last_name' => 'required|string',
        ]);

        $staff->update($validated);

        $staff->syncRoles(['admin']);

        return redirect(route('staff.index'))
            ->with('message', 'Staff information udpated successfully.');
    }
}
