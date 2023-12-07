@csrf

<div class="row gy-3">
  <div class="form-group col-md-6 col-12">
    <label class="form-label" for="email">{{ __('backend.email') }}</label>
    <input type="email"
           id="email"
           name="email"
           class="form-control"
           value="{{ old('email', $user->email ?? '') }}"
           required/>
  </div>
</div>

<div class="row mt-4">

  <div class="form-group col-md-6 col-12">
    <label class="form-label" for="password">{{ __('backend.password') }}</label>
    <input type="password"
           id="password"
           name="password"
           class="form-control"
           minlength="8"
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
    <label class="form-label" for="password_confirmation">{{ __('backend.password_confirmation') }}</label>
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
