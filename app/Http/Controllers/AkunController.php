<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('accountadmin', compact('users'));
    }

    public function create()
    {
        return view('accountcreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'status'   => 'required',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status'   => $validated['status'],
        ]);

        return redirect('/account/admin')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('accountedit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect('/account/admin')->with('success', 'Akun berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/account/admin')->with('success', 'Akun berhasil dihapus.');
    }
}
