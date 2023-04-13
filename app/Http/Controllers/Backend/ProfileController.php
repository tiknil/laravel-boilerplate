<?php

namespace App\Http\Controllers\Backend;

use App\Utils\Toast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController
{
    public function page(): View
    {
        return view('backend.pages.profile')->with(['user' => Auth::user()]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $params = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],

            'password' => 'nullable|confirmed',
        ]);

        $user->name = $params['name'];
        $user->email = $params['email'];

        if ($params['password'] !== null) {
            $user->password = Hash::make($params['password']);
        }

        $user->save();

        Toast::show('success', __('backend.submit_success'));

        return redirect(route('backend.profile'));
    }
}
