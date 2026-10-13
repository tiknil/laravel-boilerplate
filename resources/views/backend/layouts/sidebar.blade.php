<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <img class="sidebar-logo"
      src="https://www.tiknil.com/images/logo.png"
      alt="Logo"
      loading="lazy" />
  </div>

  <nav class="sidebar-nav">

    <span class="nav-item">
      <a class="nav-link" href="{{ route('backend.users') }}">
        <i class="nav-icon bi bi-people"></i> {{ __('backend.users') }}
      </a>
    </span>
    <span class="nav-item">
      @can('developer')
        <a class="nav-link" href="{{ route('backend.audit-events') }}">
          <i class="nav-icon bi bi-card-checklist"></i> Auditing
        </a>
      @endcan
    </span>
  </nav>
</div>
