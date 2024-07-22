<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use WireTable\Data\Column;
use WireTable\Traits\ResetPageOnUpdate;
use WireTable\WireTable;

class UsersTable extends WireTable
{
    use ResetPageOnUpdate;

    public string $role = '';

    public string $search = '';

    public function query(): Builder
    {
        return User::query();
    }

    public function filter(Builder $query): Builder
    {
        return $query->when($this->role !== '', fn (Builder $q) => $q->where('role', $this->role))
            ->when($this->search !== '', fn (Builder $q) => $q->where('email', 'like', '%'.$this->search.'%'));
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
                label: __('user.email'),
                key: 'email',
                sort: true
            ),
            Column::create(
                label: __('user.role'),
                key: 'role',
                map: fn ($user) => $user->role->label(),
            ),
            Column::create(
                label: '',
                cellView: 'backend.users.actions',
                thStyle: ['style' => 'width: 200px']
            ),
        ];
    }

    public function deleteUser(int $id): void
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
        return view('backend.users.table');
    }
}
