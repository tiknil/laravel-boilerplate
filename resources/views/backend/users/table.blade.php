@php
  use \App\Enums\UserRole;
@endphp
<div>

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
