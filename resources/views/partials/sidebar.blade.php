<div class="sidebar">
    {{-- Logo Section --}}
    <div class="sidebar-logo">
        <img src="{{ asset('images/Blogify.png') }}" alt="Logo" class="logo">
        <span class="logo-text">Blogify</span>
    </div>

    {{-- Navigation Menu --}}
    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <img src="{{ asset('images/Dashboard_icon.png') }}" class="menu-icon" />
            Dashboard
        </a>
        <a href="{{ route('articles.my-blogs') }}" class="{{ request()->routeIs('articles.my-blogs') ? 'active' : '' }}">
            <img src="{{ asset('images/Myblog_icon.png') }}" class="menu-icon" />
            My Blogs
        </a>
        <a href="{{ route('settings.index') }}" class="{{ Request::is('settings') ? 'active' : '' }}">
            <img src="{{ asset('images/Settings_icon.png') }}" class="menu-icon" />
            Settings
        </a>
        
    </div>

    {{-- User Profile Section --}}
    <div class="sidebar-bottom">
        <hr class="divider" />
        <div class="profile-info">
            <a href="{{ route('settings.index') }}">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="Profile" class="profile" />
            </a>
            <div class="sidebar-content">
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <img src="{{ asset('images/Logout.png') }}" style="width: 24px; height: 24px;">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>