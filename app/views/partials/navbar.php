<nav>
    <span>Welcome, <?php echo $user['username']; ?>!</span>
    <ul id="ham-menu">
        <li><a href="/dashboard">Sconces</a></li>
        <li><a href="/dashboard">Covers</a></li>
        <li><a href="/dashboard">Cut Outs</a></li>
        <li><a href="/dashboard">Finishes</a></li>
        <li><a href="/dashboard">Lights</a></li>
        <li><a href="/dashboard">Orders</a></li>
        <li><a href="/dashboard">Promotions</a></li>
        <li><a href="/dashboard">Roles</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="/dashboard">Unique Ceramics</a></li>
        <hr>
        <li><a href="/logout">Log Out</a></li>
    </ul>
    <svg id="ham-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
        <path d="M7 8h10"></path>
        <path d="M7 12h10"></path>
        <path d="M7 16h10"></path>
    </svg>
</nav>