<div class="ss-wrapper" @if($livewire) wire:ignore.self @endif>

  <select name="{{ $name }}"
          @if($livewire) wire:key="ss-{{ $name }}" @endif
          @if($required) required @endif
    {{ $attributes->merge(['class' => 'ss-ghost-select']) }}>

    <option @selected(($value ?? $emptyValue) == $emptyValue) value="{{ $emptyValue }}"></option>
    @foreach($options as $key => $label)
      <option value="{{ $key }}" @selected($value == $key)>{{ $label }}</option>
    @endforeach

  </select>

  <div class="form-select ss-box"
       @if($livewire) wire:ignore @endif
       role="button"
       aria-label="{{ $placeholder }}">
    <div class="text-muted ss-placeholder">{{ $placeholder ?? '&nbsp;' }}</div>
    <div class="ss-value-label" style="display:none;"></div>
  </div>

  <div class="ss-dropdown hidden"
       @if($livewire) wire:ignore @endif
  >
    <div class="ss-dropdown-search">
      <input type="text" class="form-control form-control-sm "
             placeholder="{{ $searchPlaceholder ?: __('components.search-select.search-placeholder') }}"/>
    </div>

    <template class="ss-option-template">
      <div class="ss-option" data-key="">
        <span></span>
        @if($allowClear)
          <i class="bi bi-x-lg ss-remove-icon"></i>
        @endif
      </div>
    </template>

    
    <div class="ss-options">

    </div>

    <div class="text-muted p-2 empty-results">
      {{ __('components.search-select.no-results') }}
    </div>

  </div>
</div>
