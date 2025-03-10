<x-auth::page title="Password dimenticata">
  <h2 class="text-center mt-2">Password dimenticata</h2>
  <form action="{{ route('password.email') }}" method="POST" class="mt-4">
    @csrf
    <div class="text-muted mb-3">
      Riceverai una mail con le istruzioni per impostare una nuova password al tuo utente
    </div>

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


    <div class="text-end">

      <button type="submit" class="btn btn-primary">Invia</button>
    </div>

    @if(session('status'))
      <div class="alert alert-success mt-2">
        Email inviata correttamente. <br/>
        Controlla la tua posta in arrivo
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger mt-2">
        Non siamo riusciti ad inviare l'email.<br/>Verifica che l'indirizzo sia corretto
      </div>
    @endif

    <div class="text-center mt-4">
      <a class="text-primary" href="{{ route('login') }}">Accesso con password</a>
    </div>
  </form>
</x-auth::page>
