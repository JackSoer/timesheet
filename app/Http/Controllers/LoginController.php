<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $userId = auth()->user()->id;
        $currentPassword = auth()->user()->password;

        if (!Hash::check($request->currentPassword, $currentPassword)) {
            throw ValidationException::withMessages([
                'currentPassword' => 'Incorrect current password',
            ]);
        }

        User::find($userId)->update(['password' => $request->newPassword]);

        return redirect('/login');
    }
}
