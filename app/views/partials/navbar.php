<nav id="nav">
    <a href="/">
        <img src="assets/images/logo.png" alt="">
    </a>
    <span>Welcome, <?php echo $user['username']; ?>!</span>
    <?php if (isset($title)) {
        echo "<h1>$title</h1>";
    } ?>
    <ul id="ham-menu">
        <li>
            <a href="/dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="7" x="3" y="3" rx="1" />
                    <rect width="7" height="7" x="14" y="3" rx="1" />
                    <rect width="7" height="7" x="14" y="14" rx="1" />
                    <rect width="7" height="7" x="3" y="14" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
        <hr>
        <li>
            <a href="/cutouts">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5.42 9.42 8 12" />
                    <circle cx="4" cy="8" r="2" />
                    <path d="m14 6-8.58 8.58" />
                    <circle cx="4" cy="16" r="2" />
                    <path d="M10.8 14.8 14 18" />
                    <path d="M16 12h-2" />
                    <path d="M22 12h-2" />
                </svg>
                <span>Cutouts</span>
            </a>
        </li>
        <li>
            <a href="/one-of-a-kind">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 2v5.632c0 .424-.272.795-.653.982A6 6 0 0 0 6 14c.006 4 3 7 5 8" />
                    <path d="M10 5H8a2 2 0 0 0 0 4h.68" />
                    <path d="M14 2v5.632c0 .424.272.795.652.982A6 6 0 0 1 18 14c0 4-3 7-5 8" />
                    <path d="M14 5h2a2 2 0 0 1 0 4h-.68" />
                    <path d="M18 22H6" />
                    <path d="M9 2h6" />
                </svg>
                <span>One of a Kind</span>
            </a>
        </li>
        <li>
            <a href="/sconces">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4h6l3 7H8l3-7Z"></path>
                    <path d="M14 11v5a2 2 0 0 1-2 2H8"></path>
                    <path d="M4 15h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4v-6Z"></path>
                </svg>
                <span>Sconces</span>
            </a>
        </li>
        <li>
            <a href="/orders">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 12h-5" />
                    <path d="M15 8h-5" />
                    <path d="M19 17V5a2 2 0 0 0-2-2H4" />
                    <path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
                </svg>
                <span>Orders</span>
            </a>
        </li>
        <?php if ($user['role_id'] < 3) { ?>
            <li>
                <a href="/roles">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="15" r="3" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                        <path d="m21.7 16.4-.9-.3" />
                        <path d="m15.2 13.9-.9-.3" />
                        <path d="m16.6 18.7.3-.9" />
                        <path d="m19.1 12.2.3-.9" />
                        <path d="m19.6 18.7-.4-1" />
                        <path d="m16.8 12.3-.4-1" />
                        <path d="m14.3 16.6 1-.4" />
                        <path d="m20.7 13.8 1-.4" />
                    </svg>
                    <span>Roles</span>
                </a>
            </li>
            <li>
                <a href="/users">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span>Users</span>
                </a>
            </li>
        <?php } ?>
        <hr>
        <li>
            <a href="/logout">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
                <span>Log Out</span>
            </a>
        </li>
    </ul>
    <svg id="ham-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
        <path d="M7 8h10"></path>
        <path d="M7 12h10"></path>
        <path d="M7 16h10"></path>
    </svg>
</nav>