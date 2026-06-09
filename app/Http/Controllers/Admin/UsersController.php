<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
class UsersController extends Controller
{
    public function index(Request $request)
{
    $query = User::withTrashed();

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($role = $request->input('role')) {
        $query->where('role', $role);
    }

    $users = $query->latest()->paginate(15)->withQueryString();

    return view('backend.users.users_index', compact('users'));
}

    public function show(User $user)
    {
        return view('backend.users.users_show', compact('user'));
    }


    public function create()
{
    return view('backend.users.users_create');
}

public function store(Request $request)
{
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
        'role'     => ['required', 'in:user,admin'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'role'     => $request->role,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('admin.users.index')
        ->with('success', 'User created successfully.');
}

    public function edit(User $user)
    {
        return view('backend.users.users_edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    $rules = [
        'name'  => ['required', 'string', 'max:255'],
        'email' =>  ['required','email', Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($user->id),],
        'role'  => ['required', 'in:user,admin'],
    ];

    if ($request->filled('password')) {
        $rules['password'] = ['string', 'min:8', 'confirmed'];
    }

    $request->validate($rules);

    $data = $request->only('name', 'email', 'role');

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')
        ->with('success', 'User updated successfully.');
}
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    public function restore($id)
{
    User::withTrashed()->findOrFail($id)->restore();
    return redirect()->route('admin.users.index')
        ->with('success', 'User restored.');
}
}

