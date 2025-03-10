@php
  use \App\Enums\UserRole;
@endphp

<div class="card">
  <div class="card-header d-flex flex-row justify-content-between align-items-center">
    <b>{{ __('backend.users') }}</b>

    <a href="{{ route('backend.users.create') }}" class="btn btn-sm btn-success">{{ __('backend.create_user') }}</a>
  </div>
  <div class="card-body">
    <div class="row mb-3">

      <div class="form-group col-xl-6 col-6">

        <x-bs::input name="search" placeholder="{{__('backend.search')}}" wire:model.live="search" icon="bi bi-search"/>

      </div>

      <div class="form-group col-xl-3 col-6">

        <x-bs::select name="role" :options="UserRole::toOptions()" wire:model.live="role"
                      icon="bi bi-person-badge"
                      empty-option="{{ __('backend.all_roles') }}"/>
      </div>
    </div>

    {!! $this->renderTable() !!}
  </div>
</div>

