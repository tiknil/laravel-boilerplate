<x-backend::layouts.page :title="__('backend.create_user')">
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.create_user') }}</b>
    </div>
    <div class="card-body">

      <x-bs::form action="{{ route('backend.users.store') }}" method="POST">
        <x-backend::users.fields/>
      </x-bs::form>
    </div>
  </div>
</x-backend::layouts.page>

