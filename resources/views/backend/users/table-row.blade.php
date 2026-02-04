<tr wire:key="{{ $user->id }}">

  <td>{{ $user->created_at->translatedFormat('d M y') }} <small
      class="text-muted">{{ $user->created_at->translatedFormat('H:i') }}</small></td>
  <td>{{ $user->email }}</td>
  <td>{{ $user->role->label() }}</td>
  <td>
    <a class="btn btn-light btn-sm" href="{{ route('backend.users.edit', ['id' => $user->id]) }}">
      <i class="bi bi-pencil"></i> {{ __('backend.edit') }}
    </a>

    <a class="btn btn-light text-danger btn-sm @if ($user->id === Auth::user()->id) disabled @endif"
      wire:confirm="{{ __('backend.delete_confirm_request') }}"
      wire:click="deleteUser({{ $user->id }})">
      <i class="bi bi-trash3"></i> {{ __('backend.delete') }}
    </a>

  </td>
</tr>
