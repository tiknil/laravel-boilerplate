<header class="header header-sticky mb-4">
  <div class="container-fluid d-flex flex-row align-items-center">
    <button class="header-toggler px-md-0" type="button"
            onclick="document.querySelector('.sidebar').classList.toggle('hide')">
      <i class="bi bi-list"></i>
    </button>
    <ul class="header-nav d-flex">

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
