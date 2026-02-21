<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::findOrFail(Auth::id());
        $resultCount = $user->completedTests()->count();
        return view('user.profile', compact('user', 'resultCount'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ], [
            'name.required'  => 'Ism-familiya kiritilishi shart',
            'email.required' => 'Email kiritilishi shart',
            'email.unique'   => 'Bu email allaqachon ishlatilmoqda',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil muvaffaqiyatli yangilandi');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.required'      => 'Joriy parol kiritilishi shart',
            'current_password.current_password' => 'Joriy parol noto\'g\'ri',
            'password.required'              => 'Yangi parol kiritilishi shart',
            'password.confirmed'             => 'Parollar mos kelmadi',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Parol muvaffaqiyatli o\'zgartirildi');
    }
}