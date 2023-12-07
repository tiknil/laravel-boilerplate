<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use WireTable\Data\Column;
use WireTable\Traits\WithSorting;
use WireTable\WireTable;

class UsersTable extends WireTable
{
    use WithSorting;

    public function query(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        return [
            Column::create(
                label: __('backend.created_at'),
                key: 'created_at',
                sort: true
            ),
            Column::create(
                label: __('backend.email'),
                key: 'email',
                sort: true
            ),
            Column::create(
                label: '',
                cellView: 'backend.pages.users.actions',
                thStyle: ['style' => 'width: 200px']
            ),
        ];
    }

    public function deleteUser(int $id)
    {

        $authUser = Auth::user();

        $user = User::find($id);

        if ($authUser->id === $user->id) {
            //
        } else {
            $user->delete();
        }
    }
}
