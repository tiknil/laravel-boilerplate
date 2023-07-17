<div class="multi-select"
     x-data="{ open: false, search: '', selected: @js($initialSelected())}"
     @click.outside="open = false"
     x-init="$watch('open', open => open ? $refs.search.focus() : ''); $watch('selected', s => { $refs.search.focus(); $dispatch('input', selected) })"
>
  <div class="form-select" @click="open = !open">
    <template x-for="entry in Object.entries(selected)" :key="entry[1]">
            <span class="badge bg-primary me-1">
                <i class="bi bi-x-lg" @click="delete selected[entry[0]]"></i>&nbsp;
                <span x-text="entry[1]"></span>
            </span>
    </template>


    <input class="ghost-input"
           placeholder="{{ $placeholder }}"
           type="text"
           x-ref="search"
           x-model="search"/>
  </div>

  <select name="{{ $name }}[]" id="{{$name}}" multiple class="hidden-input" @if($required) required @endif>
    @foreach($options as $key => $label)
      <option value="{{ $key }}" x-bind:selected="selected['{{ $key }}'] !== undefined">{{$label}}</option>
    @endforeach
  </select>

  <ul class="multi-select-options" x-bind:class="open ? 'open' : ''">
    @foreach($options as $key => $label)
      <li class="option"
          x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
          data-value="{{ $key }}"
          @click="selected[$el.dataset.value] === undefined
                    ? selected[$el.dataset.value] = $el.innerText
                    : delete selected[$el.dataset.value]"
      >
        <i x-show="selected[$el.parentElement.dataset.value] !== undefined"
           class="bi bi-check-lg text-primary"></i>
        {{ $label }}
      </li>
    @endforeach

    @if(count($options) === 0)
      <li class="empty-option text-muted">
        Nessun opzione disponibile
      </li>
    @endif
  </ul>
</div>
