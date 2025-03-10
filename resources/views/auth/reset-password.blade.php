<x-auth::page title="Reset password">
  <h2 class="text-center mt-2">Reset password</h2>
  <form action="{{ route('password.update') }}" method="POST" class="mt-4">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="text-muted mb-3">
      Inserisci la nuova password del tuo account
    </div>

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input type="email"
               name="email"
               value="{{ $email }}"
               class="form-control"
               placeholder="E-mail"
               aria-label="E-mail"
               readonly
               required>
      </div>
    </div>

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-unlock"></i></span>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="Password"
               aria-label="Password"
               minlength="8"
               required>
      </div>
    </div>

    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-unlock"></i></span>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               placeholder="Conferma password"
               aria-label="Conferma password"
               minlength="8"
               required>
      </div>
    </div>


    <div class="text-end">
      <button type="submit" class="btn btn-primary">Invia</button>
    </div>

    @if($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach($errors->all() as $error)
          {{ $error }} <br/>
        @endforeach
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('login') }}">Accesso con password</a>
    </div>
  </form>
</x-auth::page>
