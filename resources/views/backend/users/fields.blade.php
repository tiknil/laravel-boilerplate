@php
  use \App\Enums\UserRole;
@endphp

<div class="row gy-3">
  <div class="form-group col-md-6 col-12">

    <x-bs::input label="{{ __('user.email') }}" name="email" required/>

  </div>

  @can('admin')
    <div class="form-group col-md-6 col-12">

      <x-bs::select label="{{ __('user.role') }}" name="role" :options="UserRole::toOptions()" required/>

    </div>
  @endcan

</div>

<div class="row mt-4">

  <div class="form-group col-md-6 col-12">

    <x-bs::input
      type="password"
      label="{{ __('user.password') }}"
      name="password"
      :required="!isset($user)"
      minlength="8"
      autocomplete="new-password"
    />

    <small class="text-muted">
      @if(isset($user))
        {{ __('backend.password_update_hint') }}
      @endif
    </small>
  </div>

  <div class="form-group col-md-6 col-12">

    <x-bs::input
      type="password"
      label="{{ __('user.password_confirmation') }}"
      name="password_confirmation"
      minlength="8"
    />

  </div>
</div>

<div class="row mt-3">
  <div class="col-auto">
    <button type="submit" class="btn btn-primary">{{ __('backend.save') }}</button>
  </div>
</div>
