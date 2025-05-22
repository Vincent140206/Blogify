<style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 90px;
    background: #2876E9;
    padding: 30px 20px;
    overflow-y: auto; 
    z-index: 1000;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    align-items: flex-start;
    overflow: hidden;
    transition: width 0.3s ease;
  }
  .container {
    flex: 1;
    padding: 20px;
    margin-left: 90px; 
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: margin-left 0.3s ease;
  }

  .layout {
    display: flex;
  }

  .sidebar-expanded {
    width: 250px !important;
  }

  .container-expanded {
    margin-left: 250px !important;
  }

</style>
<div class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/Blogify.png') }}" alt="Logo" class="logo">
        <span class="logo-text">Blogify</span>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <img src="{{ asset('images/Dashboard_icon.png') }}" class="menu-icon" />
            Dashboard
        </a>
        <a href="{{ route('articles.my-blogs') }}" class="{{ Request::is('my-blogs*') ? 'active' : '' }}">
            <img src="{{ asset('images/Myblog_icon.png') }}" class="menu-icon" />
            My Blogs
        </a>
        <a href="#" class="{{ Request::is('settings') ? 'active' : '' }}">
            <img src="{{ asset('images/Settings_icon.png') }}" class="menu-icon" />
            Settings
        </a>
    </div>

    <div class="sidebar-bottom">
        <hr class="divider" />
        <div class="profile-info">
            <a href="{{ route('profile') }}">
                <img src="{{ asset('images/profile-icon.svg') }}" alt="Profile" class="profile" />
            </a>
            <div class="user-details">
                <div class="user-name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                <div class="user-email">{{ Auth::check() ? Auth::user()->email : '' }}</div>
            </div>
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" style="background: none; border: none; padding: 0; cursor: pointer;">
                    <img src="{{ asset('images/Logout.png') }}" style="width: 24px; height: 24px;">
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="login-btn" style="color: white; text-decoration: none;">Login</a>
            @endauth
        </div>
    </div>
</div>
