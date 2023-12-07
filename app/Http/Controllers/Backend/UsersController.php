<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsersController
{
    public function page(): View
    {
        return view('backend.pages.users.table-page');
    }

    public function create(): View
    {
        return view('backend.pages.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->createOrUpdate($request, null);
    }

    public function edit($id): View
    {
        return view('backend.pages.users.edit')
            ->with(['user' => User::findOrFail($id)]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return $this->createOrUpdate($request, User::findOrFail($id));

    }

    private function createOrUpdate(Request $request, User|null $user): RedirectResponse
    {
        $isCreation = is_null($user);

        $params = $request->validate([
            'email' => [
                'required',
                'email',
                $isCreation
                    ? Rule::unique('users')
                    : Rule::unique('users')->ignore($user->id),
            ],
            'role' => ['nullable', 'string'],
            'password' => [$isCreation ? 'required' : 'nullable', 'confirmed'],
        ]);

        if ($isCreation) {
            $user = new User();
        }

        $user->email = $params['email'];

        if (!empty($params['password'])) {
            $user->password = Hash::make($params['password']);
        }

        if (Gate::allows('admin') && !empty($params['role'])) {
            $user->role = $params['role'];
        }

        $user->save();

        return redirect(route('backend.users'));

    }
}
