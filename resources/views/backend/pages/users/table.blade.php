<div>

  <div class="row mb-3">

    <div class="form-group col-xl-6 col-6">
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control" placeholder="{{__('backend.search')}}" wire:model="search"/>
      </div>
    </div>

    <div class="form-group col-xl-3 col-6">

      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>

        <select name="role" id="role" class="form-select" wire:model="role">
          <option value="all"> {{ __('backend.all_roles') }} </option>
          @foreach(\App\Enums\UserRole::cases() as $role)
            <option value="{{ $role->name }}">
              {{ $role->label() }}
            </option>
          @endforeach
        </select>

      </div>

    </div>
  </div>

  {!! $this->renderTable() !!}
</div>
