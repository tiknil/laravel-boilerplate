@extends('backend.page')

@section('title', __('backend.users'))

@section('page-id', 'users')

@push('styles')
  @livewireStyles
@endpush

@push('scripts')
  @livewireScripts
@endpush

@section('content')
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.users') }}</b>

      <a href="{{ route('backend.users.create') }}" class="btn btn-sm btn-success">{{ __('backend.create_user') }}</a>
    </div>
    <div class="card-body">
      <livewire:users-table/>
    </div>
  </div>
@endsection

