@extends('backend.page')

@section('title', __('backend.edit_user', ['name' => $user->name]))

@section('content')
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.edit_user', ['name' => $user->name])  }}</b>
    </div>
    <div class="card-body">
      <x-bs::form :model="$user" action="{{ route('backend.users.update', ['id' => $user->id]) }}" method="PATCH">
        @include('backend.users.fields')
      </x-bs::form>
    </div>
  </div>
@endsection

