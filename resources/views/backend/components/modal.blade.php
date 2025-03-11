@php($livewire = is_subclass_of(static::class, \Livewire\Component::class))

<div @if($livewire ?? false) wire:ignore.self @endif
class="modal fade"
     @if(isset($static)) data-bs-backdrop="static" @endif
     id="{{ $id }}"
  {{ $attributes->except(['livewire', 'static', 'size', 'title', 'footer']) }}
>
  <div @if($livewire ?? false) wire:ignore.self @endif class="modal-dialog modal-{{ $size ?? 'lg' }}">
    <div @if($livewire ?? false) wire:ignore.self @endif class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{{ $title }}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {{ $slot }}
      </div>
      @if(!empty($footer))
        <div class="modal-footer">
          {{ $footer }}
        </div>
      @endif
    </div>
  </div>
</div>
