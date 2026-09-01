<x-backend::layouts.page :title="__('backend.profile')" page-id="profile">
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.profile') }}</b>
    </div>
    <div class="card-body">
      <form action="{{ route('backend.profile.submit') }}" method="POST">
        @csrf

        <div class="row gy-3">
          <div class="form-group col-md-6 col-12">
            <label class="form-label" for="email">{{ __('user.email') }}</label>
            <input class="form-control"
              id="email"
              name="email"
              type="email"
              value="{{ old('email', $user->email ?? '') }}"
              required />
          </div>
        </div>

        <div class="row mt-4">

          <div class="form-group col-md-6 col-12">
            <label class="form-label" for="password">{{ __('user.password') }}</label>
            <input class="form-control"
              id="password"
              name="password"
              type="password"
              value="{{ old('password', '') }}"
              minlength="8" />
            <small class="text-muted">
              {{ __('backend.password_update_hint') }}
            </small>
          </div>

          <div class="form-group col-md-6 col-12">
            <label class="form-label" for="password_confirmation">{{ __('user.password_confirmation') }}</label>
            <input class="form-control"
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              minlength="8" />
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-auto">
            <button class="btn btn-primary" type="submit">{{ __('backend.save') }}</button>
          </div>
        </div>

      </form>
    </div>
  </div>

  <div class="card mt-4">
    <div class="card-header">
      <b>{{ __('two-factor.profile.card_title') }}</b>
    </div>
    <div class="card-body">
      @include('backend.two-factor-settings-trigger')
    </div>
  </div>

  @include('backend.two-factor-settings-modal')
</x-backend::layouts.page>
