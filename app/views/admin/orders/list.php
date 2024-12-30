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
                <div id="order-options-container">
                    <a href="" class="continue-btn order-option other email-client" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        <span>Email Client</span>
                    </a>
                    <div data-status="in process" class="continue-btn order-option">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v6h6"></path>
                            <path d="M21 12A9 9 0 0 0 6 5.3L3 8"></path>
                            <path d="M21 22v-6h-6"></path>
                            <path d="M3 12a9 9 0 0 0 15 6.7l3-2.7"></path>
                            <circle cx="12" cy="12" r="1"></circle>
                        </svg>
                        <span>Make In Process</span>
                    </div>
                    <div data-status="completed" class="continue-btn order-option success">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg>
                        <span>Complete</span>
                    </div>
                    <div data-status="canceled" class="continue-btn order-option danger">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m4.9 4.9 14.2 14.2"></path>
                        </svg>
                        <span>Cancel</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="order-details-form">
                    <div class="order-info-container">
                        <div class="order-info-container-title">
                            <h4>Client Info</h4>
                            <svg class="toggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                        <div class="order-info-container-content">
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
                                <a data-phone></a>
                            </div>
                            <div class="mutiple-input-container" style="margin-top: 36px;">
                                <div class="input-container">
                                    <label for="address_1">Street Address</label>
                                    <span data-address_1></span>
                                </div>
                                <div class="input-container">
                                    <label for="town_or_city">Town / City</label>
                                    <span data-town_or_city></span>
                                </div>
                            </div>
                            <div class="mutiple-input-container">
                                <div class="input-container">
                                    <label for="state">State</label>
                                    <span data-state></span>
                                </div>
                                <div class="input-container">
                                    <label for="country">Country</label>
                                    <span data-country></span>
                                </div>
                            </div>
                            <div class="input-container" style="margin: 24px 0 0;">
                                <label for="message">Message</label>
                                <p data-message></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="order-info-container">
                        <div class="order-info-container-title">
                            <h4>Order Info</h4>
                            <svg class="toggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                        <div class="order-info-container-content">
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
                        </div>
                    </div>
                    <hr>
                    <div class="order-info-container line-items">
                        <div class="order-info-container-title">
                            <h4>Line Items</h4>
                            <svg class="toggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                        <div class="order-info-container-content"></div>
                        <button id="view-items-btn" class="continue-btn">View Items In Detail</button>
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
            } else if (item.one_of_a_kind_id) {
                return "one of a kind";
            } else if (item.cutout_id) {
                return "cutout";
            }
        }

        STATE.dTable = new DataTable("#orders-table", {
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

        function reloadOrdersTable() {
            STATE.dTable.ajax.reload(null, false); // false ensures the current paging stays the same
        }

        function renderLineItems(order) {
            const lineItemsHTML = order.order_items.reduce((html, item) => {
                html += `<div>${item.description}</div><div>$${formatPrice(item.price)}</div>`;
                return html;
            }, "");

            const totalHTML = `<div>Total</div><div>$${formatPrice(order.total_amount)}</div>`;

            $(".order-info-container.line-items .order-info-container-content")
                .html(lineItemsHTML + totalHTML);
            $(".order-info-container.line-items .order-info-container-title h4")
                .text(`Line Items (${order.order_item_count})`);
        }

        function handleInitTableRowEvents() {
            STATE.dTable.rows().every(function(idx) {
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
                    modal.find('[data-created_at]').text(data.created_at);
                    modal.find('[data-total_amount]').text(`$${formatPrice(data.total_amount)}`);
                    modal.find('[data-current_status]')
                        .text(data.current_status)
                        .attr('data-current_status', data.current_status);
                    modal.find('[data-full_name]').text(data.full_name);
                    modal.find('[data-email]')
                        .text(data.email)
                        .attr('href', `mailto:${data.email}`);
                    modal.find('[data-phone]')
                        .text(data.phone)
                        .attr('href', `tel:${data.phone}`);
                    modal.find('[data-address_1]').text(data.address_1);
                    modal.find('[data-town_or_city]').text(data.town_or_city);
                    modal.find('[data-state]').text(data.state);
                    modal.find('[data-country]').text(data.country);
                    modal.find('[data-message]').text(data.message);
                    modal.find('.continue-btn.email-client').attr('href', `mailto:${data.email}`);

                    renderLineItems(data);

                    modal.addClass('showing');
                    STATE.activeOrder = data;
                };
            });

        }

        $(".order-option[data-status]").on('click', async function() {
            const statusData = {
                current_status: STATE.activeOrder.current_status,
                new_status: $(this).data('status'),
            };

            const css = 'style="text-transform: capitalize;"';

            const choice = await Swal.fire({
                icon: "warning",
                title: "Updating Order Status",
                html: `Please confirm that you would like to change the status of <strong>Order #${STATE.activeOrder.order_id}</strong> from <strong ${css}>"${STATE.activeOrder.current_status}"</strong> to <strong ${css}>"${statusData.new_status}"</strong>`,
                confirmButtonText: "confirm",
                showCancelButton: true
            });

            if (!choice.isConfirmed) return;

            $.ajax({
                url: `/orders/${STATE.activeOrder.order_id}/status`,
                method: "PUT",
                dataType: "JSON",
                contentType: "application/json",
                data: JSON.stringify(statusData),
                success: res => {
                    const {
                        data,
                        status,
                        message
                    } = res;
                    const success = status === 200;

                    Swal.fire({
                        icon: success ? "success" : "error",
                        title: success ? "Success" : "Error",
                        text: message,
                    });

                    if (success) {
                        $("#order-details-modal [data-current_status]")
                            .attr('data-current_status', data.current_status)
                            .text(data.current_status);

                        reloadOrdersTable();
                    }
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $(".order-info-container-title").on("click", function() {
            $(this).closest('.order-info-container').toggleClass('hidden');
        });

        $("#order-items-modal .modal-close").on("click", function() {
            setTimeout(() => {
                $("#order-details-modal").addClass("showing");
            }, STATE.modalDelay);
        });

        $("#view-items-btn").on('click', function(e) {
            e.preventDefault();
            $("#order-details-modal .modal-close").trigger("click");
            setTimeout(() => {
                $("#order-items-modal").addClass("showing");
            }, STATE.modalDelay);
            $("#cart-list").html("");

            const activeOrder = STATE.activeOrder;
            const orderType = activeOrder.order_type;

            activeOrder.order_items.forEach((orderItem, idx) => {
                const item = formatResource(orderItem[orderType]);
                orderItem.cutout && (orderItem.cutout = formatResource(orderItem.cutout));
                const itemPrice = Number(item.base_price);
                const cutoutPrice = Number(orderItem?.cutout?.base_price) || 0;
                const quantity = Number(orderItem.quantity);
                const itemSubTotal = (itemPrice + cutoutPrice) * quantity;
                const formattedItemSubTotal = formatPrice(itemSubTotal)
                const idKey = `${item.type}_id`;
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
                                        <img src="${orderItem?.cutout?.image_url || ""}" alt="">
                                    </div>
                                    <div class="line-item-info">
                                        <div>
                                            <h5>${orderItem?.cutout?.name || "No Cutout"}</h5>
                                            <div>
                                                <span>$${orderItem?.cutout?.base_price || 0}</span>
                                                <sub>(usd)</sub>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            ${orderItem?.cutout?.description ? (
                                                `<div>
                                                    <span>${orderItem.cutout.description}</span>
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