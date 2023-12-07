<div class="ms-wrapper" @if($multiple) data-multiple @endif>

    <div class="form-select ms-form-field">
        <template class="ms-badge-template">
            <span class="ms-badge badge bg-primary me-1">
                <i class="bi bi-x-lg ms-remove-btn"></i>&nbsp;
                <span class="ms-badge-label"></span>
            </span>
        </template>

        <input class="ms-ghost-input"
               placeholder="{{ $placeholder }}"
               type="text"/>
    </div>

    {{--
        Input fittizio che serve per visualizzare il warning del browser quando il campo è required e
        non sono stati inseriti valori.
        Va impostato il value tramite js
    --}}
    <input type="text" class="ms-hidden-fake-input" @if($required) required @endif/>

    <ul class="ms-options">
        @foreach($options as $key => $label)
            <li class="ms-option"
                data-value="{{ $key }}"
            >
                <i class="bi bi-check-lg text-primary ms-check-icon"></i>
                <span class="ms-option-label">{{ $label }}</span>
            </li>
        @endforeach

        <li class="ms-empty-option text-muted">
            Nessun opzione disponibile
        </li>
    </ul>

    {{--
        Per ogni valore selezionato creiamo un campo nascosto con il name e il valore da inviare tramite form.
        Vanno creati / eliminati tramite js
    --}}
    <template class="ms-input-template">
        <input type="hidden" class="ms-input-hidden" name="{{ $name }}"/>
    </template>
    @if($multiple)
        @foreach($selected as $value)
            <input type="hidden"
                   class="ms-input-hidden"
                   value="{{ $value }}"
                   name="{{ $name }}"/>
        @endforeach
    @elseif(!empty($selected))
        <input type="hidden"
               class="ms-input-hidden"
               value="{{ $selected ?? '' }}"
               name="{{ $name }}"/>
    @endif
</div>
