@extends('backend.page')

@section('title', 'Dashboard')

@section('content')
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>Dashboard</b>
    </div>
    <div class="card-body">
      <b>Ed ora?</b> <br/>

      Hai a disposizione tutti i componenti di
      <a href="https://getbootstrap.com/docs/5.2/getting-started/introduction/" target="_blank" rel="nofollow">Bootstrap
        5</a>
      e tutte le
      <a href="https://icons.getbootstrap.com/" target="_blank" rel="nofollow">icone</a>
      collegate.

      <hr/>
      <b>Toast</b>

      <p>
        Predisposta l'integrazione javascript per creare dei toast facilmente con la funzione
        <code>showToast(type, message)</code>.
      </p>


      <a class="btn btn-success" onclick="showToast('success', 'Yeah! 😏')">Successo</a>
      <a class="btn btn-primary" onclick="showToast('info', 'Ciao 😄')">Info</a>
      <a class="btn btn-warning" onclick="showToast('warning', 'Attenzione! 🤔')">Warning</a>
      <a class="btn btn-danger" onclick="showToast('danger', 'Oh no! 😱')">Errore</a>
      <a class="btn btn-dark" onclick="showToast('dark', '...')">Dark</a>
      <a class="btn btn-light" onclick="showToast('light', '...')">Light</a>

      <p class="mt-2">
        Possono anche essere generati da server (es. per messaggi al submit di un form):
        <a href="{{ route('backend.toast-demo') }}">Toast da server</a>
      </p>

      <hr/>
      <b>Alert</b>

      <p>
        In automatico si mostrano degli alert in cima alla pagina in caso di errori di validazione
        o se nella sessione sono presenti le chiavi <code>success, warning, danger, info</code>.
      </p>

      <a class="btn btn-warning" href="{{ route('backend.alert-demo') }}">Warning</a>
      <a class="btn btn-danger" href="{{ route('backend.alert-demo', ['validate' => true]) }}">Validazione</a>

      <hr/>
      <b>Tooltips</b>

      <p>
        Basta aggiungere gli attributi <code>data-bs-tooltip</code> e <code>title="Messaggio..."</code> per
        aggiungere un tooltip a qualsiasi elemento.
      </p>

      <a class="btn btn-success" data-bs-tooltip title="Messaggo...">Esempio</a>

      <p class="mt-2">
        Vedi <a href="https://getbootstrap.com/docs/5.2/components/tooltips/" target="_blank">qui</a> per le
        customizzazioni possibili</p>

    </div>
  </div>
@endsection

