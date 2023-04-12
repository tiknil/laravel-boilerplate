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
                <a class="nav-link">
                    {{ Auth::user()->email }}
                </a>
            </li>
        </ul>
        <form class="form-inline ms-2">
            <a href="{{ route('auth.logout') }}"
               onclick="return confirm('Ti stai disconnettendo. Vuoi procedere?')"
               class="btn btn-sm btn-outline-secondary">Logout</a>
        </form>
    </div>
</header>
