@foreach(['success', 'warning', 'info', 'primary', 'danger'] as $type)
  @if(Session::has($type))
    <div class="alert alert-{{ $type }} alert-dismissible mb-2">
      {{ Session::get($type) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
@endforeach

@if (isset($errors) && count($errors) > 0)
  <div class="alert alert-danger alert-dismissible mb-2">
    @foreach ($errors->all() as $error)
      {{ $error }} <br/>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
