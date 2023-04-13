<div id="sidebar" class="sidebar">
  <div class="sidebar-header">
    <img class="sidebar-logo" src="https://www.tiknil.com/images/logo.png" loading="lazy"/>
  </div>

  <ul class="sidebar-nav">

    <li class="nav-item">
      <a href="{{ route('backend.dashboard') }}" class="nav-link">
        <i class="nav-icon bi bi-speedometer2"></i> {{ __('backend.dashboard') }}
      </a>
    </li>

    <li class="nav-title mt-1 collapsed" data-bs-toggle="collapse" data-bs-target="#sidebar-group">
      {{ __('backend.users') }}
      <span class="nav-title-icon" style="float: right"><i class="bi bi-chevron-down"></i></span>
    </li>

    <div id="sidebar-group" class="collapse">

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-people"></i> {{ __('backend.users') }}
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-person-plus"></i> {{ __('backend.create_user') }}
        </a>
      </li>
    </div>

  </ul>
</div>

