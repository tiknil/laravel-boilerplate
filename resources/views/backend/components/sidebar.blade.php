<div id="sidebar" class="sidebar">
  <div class="sidebar-header">
    <img class="sidebar-logo" src="https://www.tiknil.com/images/logo.png" loading="lazy" alt="Logo"/>
  </div>

  <nav class="sidebar-nav">

    <span class="nav-item">
      <a href="{{ route('backend.dashboard') }}" class="nav-link">
        <i class="nav-icon bi bi-speedometer2"></i> {{ __('backend.dashboard') }}
      </a>
    </span>

    <span class="nav-title mt-1 collapsed" data-bs-toggle="collapse" data-bs-target="#sidebar-group">
      {{ __('backend.users') }}
      <span class="nav-title-icon" style="float: right"><i class="bi bi-chevron-down"></i></span>
    </span>

    <div id="sidebar-group" class="collapse">

      <span class="nav-item">
        <a href="#" class="nav-link" onclick="showToast('info', 'Non implementato')">
          <i class="nav-icon bi bi-people"></i> {{ __('backend.users') }}
        </a>
      </span>

      <span class="nav-item">
        <a href="#" class="nav-link" onclick="showToast('info', 'Non implementato')">
          <i class="nav-icon bi bi-person-plus"></i> {{ __('backend.create_user') }}
        </a>
      </span>
    </div>

  </nav>
</div>

