<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <table id="orders-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Ordered For</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Client Message</th>
                    <th>Notes</th>
                    <th>Order Type</th>
                    <th>Current Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o) {
                    $created_at = new DateTime($o['created_at']);
                    $created_at = $created_at->format('M j, Y \@ g:i A T');
                ?>
                    <tr data-id="<?php echo $o['order_id']; ?>">
                        <td><?php echo $o['order_id']; ?></td>
                        <td><?php echo "{$o['first_name']} {$o['last_name']}"; ?></td>
                        <td><?php echo $o['order_item_count']; ?></td>
                        <td><?php echo "$" . number_format($o['total_amount'], 2); ?></td>
                        <td><?php echo $o['message'] ?? "-"; ?></td>
                        <td><?php echo $o['internal_notes'] ?? "-"; ?></td>
                        <td><?php echo $o['order_type']; ?></td>
                        <td><?php echo $o['current_status']; ?></td>
                        <td class="dt-type-date"><?php echo $created_at; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    $(document).ready(function() {
        const dTable = new DataTable("#orders-table", {
            ...STATE.dtDefaultOpts,
        });

        setTimeout(() => dTable.draw(), 1000);
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>