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

<div id="order-items-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Order Items</h1>
            </div>
            <div class="modal-body">
                <div id="cart-list"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function parseType(item) {
            if (item.sconce_id) {
                return "sconce";
            } else if (item.ceramic_id) {
                return "ceramic";
            } else if (item.cutout_id) {
                return "cutout";
            }
        }

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
            $("#order-items-modal").addClass("showing");
            $("#cart-list").html("");

            const activeOrder = STATE.activeOrder;
            const orderType = activeOrder.order_type;

            activeOrder.order_items.forEach((orderItem, idx) => {
                const item = formatResource(orderItem[orderType]);
                const itemPrice = Number(item.base_price);
                const cutoutPrice = Number(item?.cutout?.base_price) || 0;
                const quantity = Number(orderItem.quantity);
                const itemSubTotal = (itemPrice + cutoutPrice) * quantity;
                const formattedItemSubTotal = formatPrice(itemSubTotal)
                const idKey = `${item.type}_id`;
                item.cutout && (item.cutout = formatResource(item.cutout));
                item.type = parseType(item);

                const lineItemContainer = `
                    <div class="line-item-container" data-cart-idx="${idx}">
                        <div class="line-item ${item.type}" data-type="${item.type}">
                            <div>
                                <h3>${item.type}</h3>
                            </div>
                            <div>
                                <div class="img-container">
                                    <img src="${item.image_url}" alt="">
                                </div>
                                <div class="line-item-info">
                                    <div>
                                        <h5>${item.name}</h5>
                                        <div class="line-item-quantity">
                                            <div>
                                                <span>$${item.base_price}</span>
                                                <sub>(usd)</sub>
                                            </div>
                                            <span>x</span>
                                            <input data-quantity type="text" name="" id="" value="${quantity}">
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div>
                                            <span>Size:</span>
                                            <span>${item.dimensions}</span>
                                        </div>
                                        <div>
                                            <span>Material:</span>
                                            <span>${item.material}</span>
                                        </div>
                                        <div>
                                            <span>Color:</span>
                                            <span>${item.color}</span>
                                        </div>
                                        <div>
                                            <span>Finish:</span>
                                            <span>${item.finish || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Mounting Type:</span>
                                            <span>${item.mounting_type || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Fitting Type:</span>
                                            <span>${item.fitting_type || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Description:</span>
                                            <span>${item.description || "-"}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ${orderType === "sconce" ? (
                            `<hr>
                            <div class="line-item cutout" data-type="cutout">
                                <div>
                                    <h3>Cutout</h3>
                                </div>
                                <div>
                                    <div class="img-container">
                                        <img src="${item?.cutout?.image_url || ""}" alt="">
                                    </div>
                                    <div class="line-item-info">
                                        <div>
                                            <h5>${item?.cutout?.name || "No Cutout"}</h5>
                                            <div>
                                                <span>$${item?.cutout?.base_price || 0}</span>
                                                <sub>(usd)</sub>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            ${item?.cutout?.description ? (
                                                `<div>
                                                    <span>${item.cutout.description}</span>
                                                </div>`
                                            ) : ""}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line-item-total">
                                <p>${orderItem.description}</p>
                                <span data-price>$${formattedItemSubTotal}</span>
                            </div>`
                        ) : ""}
                    </div>
                `;

                $("#cart-list").append(lineItemContainer);

            });

        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>