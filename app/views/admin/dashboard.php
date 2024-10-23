<?php include_once __DIR__ . "/../partials/header.php"; ?>

<nav>
    <span>Welcome, <?php echo $user['username']; ?>!</span>
    <ul id="ham-menu">
        <li><a href="/admin/dashboard">Sconces</a></li>
        <li><a href="/admin/dashboard">Covers</a></li>
        <li><a href="/admin/dashboard">Cut Outs</a></li>
        <li><a href="/admin/dashboard">Finishes</a></li>
        <li><a href="/admin/dashboard">Lights</a></li>
        <li><a href="/admin/dashboard">Orders</a></li>
        <li><a href="/admin/dashboard">Promotions</a></li>
        <li><a href="/admin/dashboard">Roles</a></li>
        <li><a href="/admin/dashboard">Users</a></li>
        <li><a href="/admin/dashboard">Unique Ceramics</a></li>
        <hr>
        <li><a href="/admin/logout">Log Out</a></li>
    </ul>
    <svg id="ham-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
        <path d="M7 8h10"></path>
        <path d="M7 12h10"></path>
        <path d="M7 16h10"></path>
    </svg>
</nav>


<?php include_once __DIR__ . "/../partials/footer.php"; ?>