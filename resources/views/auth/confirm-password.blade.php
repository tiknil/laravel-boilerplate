<x-auth::page :title="__('two-factor.confirm_password.title')">
  <h2 class="text-center mt-2">{{ __('two-factor.confirm_password.heading') }}</h2>
  <form class="mt-4"
    action="{{ url('/user/confirm-password') }}"
    method="POST">
    @csrf

    <div class="text-muted mb-3">
      {{ __('two-factor.confirm_password.description') }}
    </div>

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-unlock"></i></span>
        <input class="form-control"
          name="password"
          type="password"
          aria-label="{{ __('user.password') }}"
          placeholder="{{ __('user.password') }}"
          minlength="8"
          required>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach ($errors->all() as $error)
          {{ $error }} <br />
        @endforeach
      </div>
    @endif

    <div class="row mt-4">
      <div class="col-auto">
        <a class="btn btn-secondary" href="{{ url()->previous() }}">{{ __('two-factor.cancel') }}</a>
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" type="submit">{{ __('two-factor.confirm') }}</button>
      </div>

    </div>
  </form>
</x-auth::page>
