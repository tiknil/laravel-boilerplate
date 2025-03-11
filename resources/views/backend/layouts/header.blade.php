<header class="header header-sticky mb-4">
  <div class="container-fluid d-flex flex-row align-items-center">
    <button class="header-toggler px-md-0" type="button"
            onclick="document.querySelector('.sidebar').classList.toggle('hide')">
      <i class="bi bi-list"></i>
    </button>
    <ul class="header-nav d-flex">
      @can('developer')

        <a class="nav-link" href="/telescope" target="_blank">
          Telescope
          @if(config('telescope.enabled'))
            <span class="badge badge-sm text-bg-light">ON</span>
          @else
            <span class="badge badge-sm text-bg-light">OFF</span>

          @endif
        </a>

        <a class="nav-link" id="apiDocsDropdown" role="button" data-bs-toggle="dropdown"
           aria-expanded="true">
          API Docs
          <i class="bi bi-chevron-down"></i>
        </a>

        <div class="dropdown-menu" aria-labelledby="apiDocsDropdown" style="min-width: 250px">

          <a class="dropdown-item-text" href="{{ asset('docs/redoc.html') }}" target="_blank">
            Redoc
          </a>

          <a class="dropdown-item-text" href="{{ asset('docs/scalar.html') }}" target="_blank">
            Scalar
          </a>

          <a class="dropdown-item-text" href="{{ asset('docs/swagger.html') }}" target="_blank">
            Swagger
          </a>
        </div>

      @endcan
    </ul>
    <ul class="header-nav ms-auto">

      <li class="nav-item">
        <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
           aria-expanded="true">
          {{ Auth::user()->email }}
          <i class="bi bi-chevron-down"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown" style="min-width: 250px">
          <span class="dropdown-item-text">{{ Auth::user()->email }}</span>
          <span class="dropdown-item-text">
            <a href="{{ route('backend.profile') }}">{{ __('backend.profile_update_link') }}</a>
          </span>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item-text text-end">
            <a href="{{ route('auth.logout') }}"
               onclick="return confirm('{{ __('backend.logout_confirm') }}')"
               class="btn btn-secondary">{{ __('backend.logout') }}</a>
          </span>
        </div>
      </li>
    </ul>
  </div>
</header>
