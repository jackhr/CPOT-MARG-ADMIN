<?php include_once __DIR__ . "/../partials/header.php" ?>

<style>
    body {
        background: var(--black);
        color: var(--white);
    }

    #main-container {
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px;
        text-align: center;
    }

    img {
        max-width: 200px;
        margin-bottom: 48px;
    }

    p {
        line-height: 1.5;
        max-width: 800px;
    }
</style>

<div id="main-container">
    <img src="/assets/images/icons/hardhat.avif" alt="Hardhat">
    <h1>Under Construction</h1>
    <p>The site is getting an upgrade! We should be finished soon, and will contact you once completed.</p>
    <a href="/logout" class="continue-btn" style="width: 300px;margin-top: 48px;">Logout</a>
</div>

<?php include_once __DIR__ . "/../partials/footer.php" ?>