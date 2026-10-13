<tr>
  <td>
    <small class="text-muted">{{ $log->created_at->translatedFormat('d M y H:i:s') }}</small> <br />

    @if ($user?->role)
      <small class="text-muted">{{ $user->role->label() }} - </small>
    @endif

    <small class="text-muted">{{ $log->user_id ?? '' }}</small>&nbsp;
    <span>{{ $user?->email ?? '' }}</span>
  </td>
  <td>
    <b>
      {{ App\Enums\AuditEvents::from($log->event)->toLabel() }}
    </b>
  </td>
  <td>
    @php
      $path = parse_url($log->url, PHP_URL_PATH);
      $cleanPath = str_replace(['/backend/'], '/', $path);
      $finalUrl = ltrim($cleanPath, '/');
    @endphp
    <div><span class="text-muted small">{{ $finalUrl ?: '' }}</span></div>
    <div><span class="text-muted small">{{ $log->ip_address ?: '-' }}</span></div>
  </td>
  <td>

    <small
      class="text-muted">{{ $log->auditable_type ? ltrim($log->auditable_type, 'App\Models') . ' - ' . $log->auditable_id : 'Tentativo di accesso' }}</small>

    @if ($log->event == 'login_failed')
      <div class="small">
        {{ $log->new_values['email'] ?? '' }}
      </div>
    @elseif ($log->auditable)
      <div class="small">
        @if ($log->auditable instanceof \App\Models\User)
          {{ $log->auditable->email }}
        @else
          {{ $log->auditable->name ?? ($log->auditable->description ?? '') }}
        @endif
      </div>
    @elseif (!$log->auditable_type && !$log->auditable_id)
    @else
      <span class="text-muted small">(Risorsa eliminiata)</span>
    @endif

  </td>
  <td class="text-end">
    @if (($log->event === 'updated' || $log->event === 'created') && !empty($log->new_values))
      <button class="btn btn-light btn-sm"
        type="button"
        wire:click.prevent="$dispatch('audit-detail-modal:open', { id: {{ $log->id }}})">
        <i class="bi bi-file-text-fill"></i>&nbsp;Dettagli
      </button>
    @endif
  </td>
</tr>
