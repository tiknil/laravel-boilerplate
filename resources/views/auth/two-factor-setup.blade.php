<x-auth::page :title="__('two-factor.setup.title')">
  <h2 class="text-center mt-2">{{ __('two-factor.setup.heading') }}</h2>

  <livewire:two-factor-settings :standalone="true" />
</x-auth::page>