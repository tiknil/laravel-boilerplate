@extends('backend.page')

@section('page-id', 'vue-page')

@section('title', 'Vue')

@section('content')
  <div class="card">
    <div class="card-header">
      Integrazione con <b>Vue</b>
    </div>
    <div class="card-body">
      <div class="row mb-2">
        <div class="col">
          <b>Composition API:</b> <br/>

          <div id="counter-composition"></div>

          <small>Esempio di componente Vue che usa la Composition API, vedi il file `CounterComposition.vue`</small>

        </div>
        <div class="col">
          <b>Options API:</b> <br/>
          <div id="counter-options"></div>

          <small>Esempio di componente Vue che usa la Options API, vedi il file `CounterOptions.vue`</small>
        </div>
      </div>

      La Composition API ci risulta più facile da leggere, più estendibile tramite <a
        href="https://vuejs.org/guide/reusability/composables.html">"composables"</a> e più concisa.

      <hr/>

      Viene incluso Vue3 con supporto a typescript, eslint e prettier. <br/>
      Vedi il file <code>resources/js/backend/pages/vue-page.ts</code> per un esempio di come inizializzare i componenti
      Vue.

    </div>
  </div>
@endsection

