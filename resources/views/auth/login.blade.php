<x-auth::page title="Accesso">
  <h2 class="text-center mt-2">Area riservata</h2>
  <div class="mt-4 text-center">
    Accedi con le tue credenziali
  </div>
  <form action="{{ route('login') }}" method="POST" class="mt-4">
    @csrf
    <div class="form-group">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               class="form-control"
               placeholder="E-mail"
               aria-label="E-mail"
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
               required>
      </div>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center">

      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name="remember"
               id="remember" {{ old('remember') === '1' ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
          Rimani collegato
        </label>
      </div>

      <button type="submit" class="btn btn-primary">Accedi</button>
    </div>

    @if(session('status'))
      <div class="alert alert-success mt-2">
        {{ session('status') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach($errors->all() as $error)
          {{ $error }} <br/>
        @endforeach
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('password.request') }}">Hai dimenticato la password?</a>
    </div>
  </form>
</x-auth::page>
