<x-backend::layouts.page>
  <x-slot:title>{{ __('backend.edit_user', ['name' => $user->name]) }}</x-slot:title>
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.edit_user', ['name' => $user->name])  }}</b>
    </div>
    <div class="card-body">
      <x-bs::form :model="$user" action="{{ route('backend.users.update', ['id' => $user->id]) }}" method="PATCH">
        <x-backend::users.fields :user="$user"/>
      </x-bs::form>
    </div>
  </div>
</x-backend::layouts.page>

