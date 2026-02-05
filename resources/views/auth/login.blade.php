<x-auth::page title="{{ __('login.login_page.title') }}">
  <h2 class="text-center mt-2">{{ __('login.login_page.title') }}</h2>
  <div class="mt-4 text-center">
    {{ __('login.login_page.subtext') }}
  </div>
  <form class="mt-4"
    action="{{ route('login') }}"
    method="POST">
    @csrf
    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input class="form-control"
          name="email"
          type="email"
          value="{{ old('email') }}"
          aria-label="{{ __('user.email') }}"
          placeholder="{{ __('user.email') }}"
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
          required>
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center">

      <div class="form-check">
        <input class="form-check-input"
          id="remember"
          name="remember"
          type="checkbox"
          value="1"
          {{ old('remember') === '1' ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
          {{ __('login.login_page.remember_me') }}
        </label>
      </div>

      <button class="btn btn-primary" type="submit">{{ __('login.login_page.submit_btn') }}</button>
    </div>

    @if (session('status'))
      <div class="alert alert-success mt-2">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach ($errors->all() as $error)
          {{ $error }} <br />
        @endforeach
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('password.request') }}">{{ __('login.login_page.password_forgot_link') }}</a>
    </div>
  </form>
</x-auth::page>
