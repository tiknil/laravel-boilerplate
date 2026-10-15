<header class="header header-sticky mb-4">
  <div class="container-fluid d-flex flex-row align-items-center">
    <button class="header-toggler px-md-0"
      type="button"
      onclick="document.querySelector('.sidebar').classList.toggle('hide')">
      <i class="bi bi-list"></i>
    </button>
    <ul class="header-nav d-flex">
      @can('developer')

        <a class="nav-link"
          href="/telescope"
          target="_blank">
          Telescope
          @if (config('telescope.enabled'))
            <span class="badge badge-sm text-bg-light">ON</span>
          @else
            <span class="badge badge-sm text-bg-light">OFF</span>
          @endif
        </a>

        <a class="nav-link"
          href="{{ asset('docs/api.html') }}"
          target="_blank">
          Api docs
        </a>

      @endcan
    </ul>
    <ul class="header-nav ms-auto">

      <li class="nav-item">
        <a class="nav-link"
          id="userDropdown"
          data-bs-toggle="dropdown"
          href="#"
          role="button"
          aria-expanded="true">
          {{ Auth::user()->email }}
          <i class="bi bi-chevron-down"></i>
        </a>
        <div class="dropdown-menu"
          aria-labelledby="userDropdown"
          style="min-width: 250px">
          <span class="dropdown-item-text">{{ Auth::user()->email }}</span>
          <span class="dropdown-item-text">
            <a href="{{ route('backend.profile') }}">{{ __('backend.profile_update_link') }}</a>
          </span>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item-text text-end">
            <a class="btn btn-secondary"
              href="{{ route('auth.logout') }}"
              onclick="return confirm('{{ __('backend.logout_confirm') }}')">{{ __('backend.logout') }}</a>
          </span>
        </div>
      </li>
    </ul>
  </div>
</header>
