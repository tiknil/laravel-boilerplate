<a href="{{ route('backend.users.edit', ['id' => $item->id]) }}" class="btn btn-outline-dark btn-sm">
  <i class="bi bi-pencil"></i> {{ __('backend.edit') }}
</a>

<a onclick="confirm('{{ addslashes(__('backend.delete_confirm_request')) }}') || event.stopImmediatePropagation()"
   wire:click="deleteUser({{ $item->id }})"
   class="btn btn-outline-danger btn-sm @if($item->id === Auth::user()->id) disabled @endif">
  <i class="bi bi-trash3"></i> {{ __('backend.delete') }}
</a>
