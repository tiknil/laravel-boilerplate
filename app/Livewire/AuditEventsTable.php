<?php

namespace App\Livewire;

use App\Enums\AuditEvents;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;
use WireTable\Data\Column;
use WireTable\Traits\ResetPageOnUpdate;
use WireTable\WireTable;

class AuditEventsTable extends WireTable
{
    use ResetPageOnUpdate;

    #[Url(as: 'tab')]
    public string $tab = 'operazioni';

    private const ACCESS_EVENTS = ['login', 'logout', 'login_failed'];

    public string $userId = '';

    public string $auditableType = '';

    public string $event = '';

    public string $fromDate = '';

    public string $toDate = '';

    public string $ipAddress = '';

    public string $initialSortBy = 'created_at';

    public string $initialSortDir = 'desc';

    public string $auditableResourceId = '';

    public int $pageSize = 100;

    public function query(): Builder
    {
        return Audit::query()->with(['user', 'auditable']);
    }

    public function filter(Builder $query): Builder
    {
        if ($this->tab === 'accessi') {
            $query->whereIn('event', self::ACCESS_EVENTS);
        } else {
            $query->where(function ($query) {
                $query->whereNotIn('event', self::ACCESS_EVENTS)
                    ->orWhereNull('event');
            });
        }

        return $query
            ->when($this->userId !== '', fn (Builder $q) => $q->where('user_id', $this->userId))
            ->when($this->auditableType !== '', fn (Builder $q) => $q->where('auditable_type', $this->auditableType))
            ->when($this->auditableResourceId !== '', fn (Builder $q) => $q->where('auditable_id', $this->auditableResourceId))
            ->when($this->event !== '', fn (Builder $q) => $q->where('event', $this->event))
            ->when($this->fromDate !== '', fn (Builder $q) => $q->where('created_at', '>=', Carbon::parse($this->fromDate)))
            ->when($this->toDate !== '', fn (Builder $q) => $q->where('created_at', '<=', Carbon::parse($this->toDate)->endOfMinute()))
            ->when($this->ipAddress !== '', fn (Builder $q) => $q->where('ip_address', 'like', '%'.$this->ipAddress.'%'));
    }

    public function columns(): array
    {
        return [
            Column::create(label: 'Data e utente', key: 'created_at', sort: true),
            Column::create(label: 'Evento', key: 'event', sort: true),
            Column::create(label: 'Richiesta', key: 'url'),
            Column::create(label: 'Elemento'),
            Column::create(label: ''),
        ];
    }

    public function render(): View
    {
        $validEvents = array_filter(
            AuditEvents::cases(),
            fn ($event) => $this->tab === 'accessi' ? $event->isAccess() : !$event->isAccess()
        );
        $listEvents = array_combine(
            array_map(fn ($e) => $e->name, $validEvents),
            array_map(fn ($e) => $e->toLabel(), $validEvents)
        );
        $listAuditableResourceId = [User::class => 'Utente'];

        return view('backend.audit-events.table')->with([
            'listUsers' => User::query()
                ->orderBy('email')
                ->get()
                ->keyBy('id')
                ->map(fn (User $user) => $user->email)
                ->toArray(),
            'listEvents' => $listEvents,
            'listAuditableResourceId' => $listAuditableResourceId,
        ]);
    }

    public function renderRow($item): View
    {
        return view('backend.audit-events.table-row')->with([
            'log' => $item,
            'user' => $item->user,
        ]);
    }
}
