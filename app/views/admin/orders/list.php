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
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
        </table>
    </div>
</main>

<div id="order-details-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Order</h1>
            </div>
            <div class="modal-body">
                <form id="order-details-form">
                    <h4>General Info</h4>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="total_amount">Total</label>
                            <span data-total_amount></span>
                        </div>
                        <div class="input-container">
                            <label for="order_type">Order Type</label>
                            <span data-order_type></span>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="current_status">Status</label>
                            <span data-current_status></span>
                        </div>
                        <div class="input-container">
                            <label for="created_at">Ordered</label>
                            <span data-created_at></span>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="items">Items</label>
                            <span data-order_item_count></span>
                        </div>
                        <button id="view-items-btn" class="continue-btn">View Items</button>
                    </div>
                    <hr>
                    <h4>Client Info</h4>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="name">Name</label>
                            <span data-full_name></span>
                        </div>
                        <div class="input-container">
                            <label for="email">Email</label>
                            <a data-email></a>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="phone">Phone</label>
                        <span data-phone></span>
                    </div>
                    <div class="input-container">
                        <label for="message">Message</label>
                        <p data-message></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const dTable = new DataTable("#orders-table", {
            ...STATE.dtDefaultOpts,
            ajax: {
                url: "/orders/getAll",
                dataSrc: function(response) {
                    let res = [];
                    if (response && response.data) {
                        res = Object.values(response.data).map(order => {
                            order.internal_notes = order.internal_notes ? order.internal_notes : "-";
                            return order;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }

                    STATE.orders = res;

                    return res;
                }
            },
            columns: [{
                    data: 'order_id'
                },
                {
                    data: 'full_name'
                },
                {
                    data: 'order_item_count'
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'message'
                },
                {
                    data: 'internal_notes'
                },
                {
                    data: 'order_type'
                },
                {
                    data: 'current_status'
                },
                {
                    data: 'created_at'
                }
            ],
            initComplete: function() {
                handleInitTableRowEvents()
                this.api().on('draw', function() {
                    handleInitTableRowEvents();
                });
            }
        });

        function handleInitTableRowEvents() {
            dTable.rows().every(function(idx) {
                const rowNode = this.node();
                if (!rowNode) {
                    console.warn(`Row node not found for index ${idx}`);
                    return;
                }

                const orderId = this.data().order_id;
                const data = STATE.orders.find(x => x.order_id === orderId);

                rowNode.onclick = () => {
                    console.log(data)
                    const modal = $("#order-details-modal");

                    modal.find('#order-details-id').text(orderId);
                    modal.find('.modal-header h1').text(`Order #${orderId}`);
                    modal.find('[data-order_type]').text(data.order_type);
                    modal.find('[data-order_item_count]').text(data.order_item_count);
                    modal.find('[data-created_at]').text(data.created_at);
                    modal.find('[data-total_amount]').text(`$${data.total_amount}`);
                    modal.find('[data-current_status]').text(data.current_status);
                    modal.find('[data-full_name]').text(data.full_name);
                    modal.find('[data-email]')
                        .text(data.email)
                        .attr('href', `mailto:${data.email}`);
                    modal.find('[data-phone]').text(data.phone);
                    modal.find('[data-message]').text(data.message);

                    modal.addClass('showing');
                    STATE.activeOrder = data;
                };
            });

        }

        $("#view-items-btn").on('click', function(e) {
            e.preventDefault();
            const data = STATE.activeOrder;
            // render order items here.
        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>