@extends('backend.page')

@section('title', __('backend.create_user'))

@section('content')
  <div class="card">
    <div class="card-header d-flex flex-row justify-content-between align-items-center">
      <b>{{ __('backend.create_user') }}</b>
    </div>
    <div class="card-body">
      <form action="{{ route('backend.users.store') }}" method="POST">
        @include('backend.pages.users.fields')
      </form>
    </div>
  </div>
@endsection

