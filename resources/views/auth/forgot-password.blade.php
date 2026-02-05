<x-auth::page title="{{ __('login.forgot_psw_page.title') }}">
  <h2 class="text-center mt-2">{{ __('login.forgot_psw_page.title') }}</h2>
  <form class="mt-4"
    action="{{ route('password.email') }}"
    method="POST">
    @csrf
    <div class="text-muted mb-3">
      {{ __('login.forgot_psw_page.subtext') }}
    </div>

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


    <div class="text-end">

      <button class="btn btn-primary" type="submit">{{ __('login.forgot_psw_page.submit_btn') }}</button>
    </div>

    @if (session('status'))
      <div class="alert alert-success mt-2">
        {{ __('login.forgot_psw_page.success_message') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger mt-2">
        {{ __('login.forgot_psw_page.error_message') }}
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('login') }}">
        {{ __('login.forgot_psw_page.login_link') }}
      </a>
    </div>
  </form>
</x-auth::page>
