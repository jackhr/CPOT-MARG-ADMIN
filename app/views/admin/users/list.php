<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<div id="users-main">
    <div id="users-table-wrapper">
        <table id="users-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u) { ?>
                    <tr>
                        <th><?php echo $u['user_id']; ?></th>
                        <th><?php echo $u['username']; ?></th>
                        <th><?php echo $u['email']; ?></th>
                        <th><?php echo $u['created_at']; ?></th>
                        <th><?php echo $u['updated_at']; ?></th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php include_once __DIR__ . "/../../partials/footer.php"; ?>