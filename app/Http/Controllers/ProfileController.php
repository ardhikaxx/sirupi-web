<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'telepon' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name', 'email', 'telepon'));

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
