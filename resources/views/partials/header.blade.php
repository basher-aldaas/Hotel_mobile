<header class="custom-header d-flex justify-content-between align-items-center px-4 py-3">
    <div class="d-flex align-items-center">
        <i class="bi bi-building-fill-check fs-4 me-2 text-info"></i>
        <h5 class="mb-0 text-light">Hotel Admin Panel</h5>
    </div>

    @if(auth()->check())
        <div class="d-flex align-items-center">
            <span class="me-3 text-light">Hello, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-info btn-sm">Logout</button>
            </form>
        </div>
    @endif
</header>
