<aside class="custom-sidebar d-flex flex-column justify-content-between p-4 text-light">
    <div>
        <div class="text-center mb-4">
            <img width="100px" src="{{ auth()->user()->profile_photo_url ?? asset('image/default-user.jpg') }}" alt="User" class="rounded-circle user-avatar mb-2">
            <h5 class="username">{{ auth()->user()->name ?? 'Username' }}</h5>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('users.index') }}" class="nav-link text-light d-flex align-items-center">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{route('galleries.index')}}" class="nav-link text-light d-flex align-items-center">
                    <i class="bi bi-image me-2"></i> Gallery
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{route('rooms.index')}}" class="nav-link text-light d-flex align-items-center">
                    <i class="bi bi-door-open me-2"></i> Rooms
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{route('bookings.index')}}" class="nav-link text-light d-flex align-items-center">
                    <i class="bi bi-calendar-check me-2"></i> Bookings
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{route('offers.index')}}" class="nav-link text-light d-flex align-items-center">
                    <i class="bi bi-tags me-2"></i> Offers
                </a>
            </li>

        </ul>
    </div>

    <div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</aside>
