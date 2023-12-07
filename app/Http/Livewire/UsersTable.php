<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use WireTable\Data\Column;
use WireTable\Traits\WithSorting;
use WireTable\WireTable;

class UsersTable extends WireTable
{
    use WithSorting;

    public string $role = "all";

    public string $search = "";

    public function query(): Builder
    {
        return User::query();
    }

    public function filter(Builder $query): Builder
    {
        return $query->when($this->role !== "all", fn (Builder $q) => $q->where('role', $this->role))
            ->when($this->search !== "", fn (Builder $q) => $q->where('email', 'like', "%" . $this->search . "%"));
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
                label: __('backend.role'),
                key: 'role',
                map: fn($user) => $user->role->label(),
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

    public function render(): View
    {
        return view('backend.pages.users.table');
    }
}
