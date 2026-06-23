<nav style="background: #111827; color: #ffffff;">
    <div class="container" style="display: flex; align-items: center; gap: 24px; padding-top: 16px; padding-bottom: 16px;">
        <a href="{{ route('projects.index') }}" style="color: #ffffff; font-weight: 700;">Mini Issue Tracker</a>
        <a href="{{ route('projects.index') }}" style="color: #d1d5db;">Projects</a>
        <a href="{{ route('issues.index') }}" style="color: #d1d5db;">Issues</a>
        <a href="{{ route('tags.index') }}" style="color: #d1d5db;">Tags</a>
        <div style="margin-left: auto; display: flex; align-items: center; gap: 14px;">
            @auth
                <span style="color: #d1d5db;">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: 0; color: #d1d5db; cursor: pointer; padding: 0;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="color: #d1d5db;">Login</a>
                <a href="{{ route('register') }}" style="color: #d1d5db;">Register</a>
            @endauth
        </div>
    </div>
</nav>
