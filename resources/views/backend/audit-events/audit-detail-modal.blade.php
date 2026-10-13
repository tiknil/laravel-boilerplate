@script
  <script>
    const modal = document.getElementById('audit-detail-modal')

    const instance = new bootstrap.Modal(modal)

    modal.addEventListener('hidden.bs.modal', () => {
      $wire.resetModal()
    })

    Livewire.on('audit-detail-modal:open', function({
      id
    }) {
      instance.show()
      $wire.setData(id)
    })
  </script>
@endscript


<x-backend::components.modal id="audit-detail-modal"
  title="Dati modificati"
  size="lg"
  livewire>
  <div class="row">
    @if ($audit)
      <div class="mt-2">
        @foreach ($audit->new_values as $campo => $nuovoValore)
          @php
            $vecchioValore = $audit->old_values[$campo] ?? 'N/D';
          @endphp

          <div class="mb-1">
            <strong>{{ ucfirst($campo) }}:</strong>

            <span class="text-danger text-decoration-line-through me-1">
              {{ is_array($vecchioValore) ? json_encode($vecchioValore) : $vecchioValore }}
            </span>

            &rarr;

            <span class="text-success fw-bold ms-1">
              {{ is_array($nuovoValore) ? json_encode($nuovoValore) : $nuovoValore }}
            </span>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</x-backend::components.modal>
