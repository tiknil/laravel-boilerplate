<x-auth::page title="{{ __('login.reset_page.title') }}">
  <h2 class="text-center mt-2">{{ __('login.reset_page.title') }}</h2>
  <form class="mt-4"
    action="{{ route('password.update') }}"
    method="POST">
    @csrf

    <input name="token"
      type="hidden"
      value="{{ $token }}">

    <div class="text-muted mb-3">
      {{ __('login.reset_page.subtext') }}
    </div>

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input class="form-control"
          name="email"
          type="email"
          value="{{ $email }}"
          aria-label="{{ __('user.email') }}"
          placeholder="{{ __('user.email') }}"
          readonly
          required>
      </div>
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

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-unlock"></i></span>
        <input class="form-control"
          name="password_confirmation"
          type="password"
          aria-label="{{ __('user.password_confirmation') }}"
          placeholder="{{ __('user.password_confirmation') }}"
          minlength="8"
          required>
      </div>
    </div>


    <div class="text-end">
      <button class="btn btn-primary" type="submit">{{ __('login.reset_page.submit_btn') }}</button>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach ($errors->all() as $error)
          {{ $error }} <br />
        @endforeach
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('login') }}">{{ __('login.forgot_psw_page.login_link') }}</a>
    </div>
  </form>
</x-auth::page>
