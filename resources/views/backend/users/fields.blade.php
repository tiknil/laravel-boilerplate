@csrf

<div class="row gy-3">
  <div class="form-group col-md-6 col-12">
    <label class="form-label" for="email">{{ __('user.email') }}</label>
    <input type="email"
           id="email"
           name="email"
           class="form-control"
           value="{{ old('email', $user->email ?? '') }}"
           required/>
  </div>
  @can('admin')
    <div class="form-group col-md-6 col-12">

      <label class="form-label" for="role">{{ __('user.role') }}</label>

      <select name="role" id="role" class="form-select">
        @foreach(\App\Enums\UserRole::cases() as $role)
          <option value="{{ $role->name }}" @selected(old('role', $user->role ?? '') == $role)>
            {{ $role->label() }}
          </option>
        @endforeach
      </select>
    </div>
  @endcan

</div>

<div class="row mt-4">

  <div class="form-group col-md-6 col-12">
    <label class="form-label" for="password">{{ __('user.password') }}</label>
    <input type="password"
           id="password"
           name="password"
           class="form-control"
           minlength="8"
           autocomplete="new-password"
           @if(!isset($user)) required @endif
           value="{{ old('password', '') }}"
    />
    <small class="text-muted">
      @if(isset($user))
        {{ __('backend.password_update_hint') }}
      @endif
    </small>
  </div>

  <div class="form-group col-md-6 col-12">
    <label class="form-label" for="password_confirmation">{{ __('user.password_confirmation') }}</label>
    <input type="password"
           id="password_confirmation"
           name="password_confirmation"
           minlength="8"
           class="form-control"
    />
  </div>
</div>

<div class="row mt-3">
  <div class="col-auto">
    <button type="submit" class="btn btn-primary">{{ __('backend.save') }}</button>
  </div>
</div>
