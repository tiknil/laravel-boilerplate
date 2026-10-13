<div class="card">
  <div class="card-header d-flex flex-row justify-content-between align-items-center">
    <b>{{ __('backend.audit_events') }}</b>
    <div id="export-btn"></div>
  </div>
  <div class="card-body">
    <div>

      <ul class="nav nav-tabs px-3 pt-2 mb-2">
        <li class="nav-item">
          <a class="nav-link {{ $this->tab === 'accessi' ? 'active' : '' }}" href="{{ route('backend.audit-events', ['tab' => 'accessi']) }}">Accessi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $this->tab !== 'accessi' ? 'active' : '' }}" href="{{ route('backend.audit-events', ['tab' => 'operazioni']) }}">Operazioni</a>
        </li>
      </ul>
      <div class="card-body">
        <div class="row" style="margin-bottom: 1rem;">
          <div class="form-group col-md-3 col-6">
            <x-bs::search-select name="userId"
              wire:model.live='userId'
              label="Chi ha eseguito l'operazione"
              placeholder="Qualsiasi utente"
              allow-clear
              :options="$listUsers" />
          </div>
          @if ($tab == 'operazioni')
            <div class="form-group col-md-3 col-6">
              <x-bs::search-select name="auditableIdResourceId"
                wire:model.live='auditableType'
                placeholder="Qualsiasi elemento"
                label="Risorsa soggetto dell'operazione"
                allow-clear
                :options="$listAuditableResourceId" />
            </div>

            <div class="form-group col-md-3 col-6">
              <x-bs::input name="auditableResourceId"
                type="number"
                wire:model.live='auditableResourceId'
                label="Id risorsa" />
            </div>
          @endif

          <div class="form-group col-md-3 col-6">
            <x-bs::search-select name="event"
              wire:model.live='event'
              placeholder="Qualsiasi evento"
              label=" "
              allow-clear
              :options="$listEvents" />
          </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
          <div class="col-12 col-md-3 form-group">
            <x-bs::input name="from"
              type="datetime-local"
              label="Dal"
              wire:model.live='fromDate' />
          </div>
          <div class="col-12 col-md-3 form-group">
            <x-bs::input name="to"
              type="datetime-local"
              label="Al"
              wire:model.live='toDate' />
          </div>
          <div class="col-12 col-md-3 form-group">
            <x-bs::input name="ipAddress"
              type="text"
              label="Indirizzo IP"
              wire:model.live='ipAddress' />
          </div>
        </div>

        {!! $this->renderTable() !!}
      </div>

    </div>

  </div>


  <livewire:audit-events-detail-modal />

</div>
