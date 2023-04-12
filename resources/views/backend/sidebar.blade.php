<div id="sidebar" class="sidebar">
  <div class="sidebar-header">
    {{--
    <img class="sidebar-logo" src="https://beta.tiknil.com/images/logo.svg">
    --}}
    <span class="badge bg-primary fs-5">{{ config('app.name') }}</span>
  </div>

  <ul class="sidebar-nav">

    <li class="nav-title mt-1">Titoletto</li>
    <li class="nav-item">
      <a href="{{ route('backend.dashboard') }}" class="nav-link">
        <i class="nav-icon bi bi-speedometer2"></i> Dashboard
      </a>
    </li>

    <li class="nav-title mt-1 collapsed" data-bs-toggle="collapse" data-bs-target="#sidebar-group">
      Accordion
      <span class="nav-title-icon" style="float: right"><i class="bi bi-chevron-down"></i></span>
    </li>

    <div id="sidebar-group" class="collapse">

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-card-checklist"></i> Link 1
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon bi bi-person-badge"></i> Link 2
        </a>
      </li>
    </div>

  </ul>
</div>

