<?php include_once __DIR__ . "/../partials/header.php"; ?>
<?php include_once __DIR__ . "/../partials/navbar.php"; ?>

<div id="dashboard-container">
    <div id="dashboard-main">
        <a href="/sconces">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4h6l3 7H8l3-7Z"></path>
                <path d="M14 11v5a2 2 0 0 1-2 2H8"></path>
                <path d="M4 15h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4v-6Z"></path>
            </svg>
            <span>Sconces</span>
        </a>
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
            <span>Sconce Cutouts</span>
        </a>
        <a href="/orders">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 12h-5" />
                <path d="M15 8h-5" />
                <path d="M19 17V5a2 2 0 0 0-2-2H4" />
                <path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
            </svg>
            <span>Sconce Orders</span>
        </a>
        <a href="/portfolios">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2v5.632c0 .424-.272.795-.653.982A6 6 0 0 0 6 14c.006 4 3 7 5 8" />
                <path d="M10 5H8a2 2 0 0 0 0 4h.68" />
                <path d="M14 2v5.632c0 .424.272.795.652.982A6 6 0 0 1 18 14c0 4-3 7-5 8" />
                <path d="M14 5h2a2 2 0 0 1 0 4h-.68" />
                <path d="M18 22H6" />
                <path d="M9 2h6" />
            </svg>
            <span>Portfolio</span>
        </a>
        <a href="/shop_items">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                <path d="M2 7h20" />
                <path d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7" />
            </svg>
            <span>Shop</span>
        </a>
        <a href="/users">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            <span>Users</span>
        </a>
    </div>
</div>

<?php include_once __DIR__ . "/../partials/footer.php"; ?>