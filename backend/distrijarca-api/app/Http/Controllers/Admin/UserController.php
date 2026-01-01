<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,super_admin',
            'activo' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['activo'] = $request->has('activo');

        $user = User::create($validated);

        ActivityLog::log('create_user', "Usuario {$user->name} creado", User::class, $user->id);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function show(User $user)
    {
        $activities = $user->activityLogs()->orderBy('created_at', 'desc')->take(20)->get();
        return view('admin.users.show', compact('user', 'activities'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,super_admin',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $user->update($validated);

        ActivityLog::log('update_user', "Usuario {$user->name} actualizado", User::class, $user->id);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log('delete_user', "Usuario {$userName} eliminado");

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::log('change_password', "Contraseña cambiada para usuario {$user->name}", User::class, $user->id);

        return redirect()->back()->with('success', 'Contraseña actualizada exitosamente');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['activo' => !$user->activo]);

        $status = $user->activo ? 'activado' : 'desactivado';
        ActivityLog::log('toggle_user_status', "Usuario {$user->name} {$status}", User::class, $user->id);

        return redirect()->back()->with('success', "Usuario {$status} exitosamente");
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.users.activity-logs', compact('logs'));
    }
}
