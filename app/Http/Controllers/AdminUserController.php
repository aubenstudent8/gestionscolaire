<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! $request->user() || ! $request->user()->hasRole('Super Administrator')) {
                return response()->view('errors.403', [], 403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        $users = User::orderBy('id','desc')->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $role = Role::firstOrCreate(['name' => 'Administrator']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($role);

        return back()->with('status', 'Administrateur créé.');
    }
}
