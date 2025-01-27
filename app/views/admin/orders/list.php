<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <button class="create-btn continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 12h-5" />
                <path d="M15 8h-5" />
                <path d="M19 17V5a2 2 0 0 0-2-2H4" />
                <path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
            </svg>
            <span>Add New Item</span>
        </button>
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

<div id="create-order-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>New Order</h1>
            </div>
            <div class="modal-body">
                <div class="gallery"></div>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button class="continue-btn disabled">Continue</button>
            </div>
        </div>
    </div>
</div>

<div id="sconce-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-options">
                <span class="modal-close">×</span>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img src="/assets/images/sconces/single/IMG_9516.jpg" alt="">
                </div>
                <div class="info-container">
                    <div class="info-section">
                        <h3 data-name></h3>
                        <span data-base_price>
                            $
                            <span></span>
                            <sub>(usd)</sub>
                        </span>
                        <span data-dimensions></span>
                        <p>Made to order<br>Ships in 4 - 6 weeks<br>SKU - <span data-sku></span></p>
                    </div>
                    <div class="info-section">
                        <h5>Cutouts</h5>
                        <p>In our ceramic sconces, a "cutout" refers to a design element where specific shapes or patterns are carved into the sconce's surface. These cutouts not only enhance the aesthetic appeal by introducing intricate designs but also allow light to pass through, creating captivating patterns and shadows in your space. You can choose from our existing range of cutout motifs or opt for no cutout for a sleek, minimalist look.</p>
                        <button class="continue-btn" data-cutout="">
                            <span>No Cutout Selected</span>
                            <img src="/assets/images/icons/right-arrow.svg" alt="">
                        </button>
                    </div>
                    <div class="info-section sconce-add-ons"></div>
                    <div class="info-section">
                        <h5>Quantity</h5>
                        <input data-quantity type="text" name="" id="">
                    </div>
                    <div class="info-section final-price">
                        <h5>Total Price</h5>
                        <div>
                            <div data-total_price>
                                $
                                <span></span>
                                <sub>(usd)</sub>
                            </div>
                            <button class="continue-btn" id="add-to-order">Add to Order</button>
                        </div>
                    </div>
                    <div class="info-section collapsible">
                        <h5>Overview</h5>
                        <div class="sconce-spec-pair">
                            <span>Description:</span>
                            <span data-description></span>
                        </div>
                    </div>
                    <div class="info-section collapsible">
                        <h5>Specification</h5>
                        <div class="sconce-spec-pair">
                            <span>Size:</span>
                            <span data-dimensions></span>
                        </div>
                        <div class="sconce-spec-pair">
                            <span>Material:</span>
                            <span data-material></span>
                        </div>
                        <div class="sconce-spec-pair">
                            <span>Colour:</span>
                            <span data-color></span>
                        </div>
                        <div class="sconce-spec-pair">
                            <span>Finish:</span>
                            <span data-finish></span>
                        </div>
                        <div class="sconce-spec-pair">
                            <span>Mounting Type:</span>
                            <span data-mounting_type></span>
                        </div>
                        <div class="sconce-spec-pair">
                            <span>Fitting Type:</span>
                            <span data-fitting_type></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cutout-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-options">
                <span class="modal-close">×</span>
            </div>
            <div class="modal-body">
                <div id="cutout-selection-container">
                    <h3>Select a Cutout</h3>
                    <div id="cutout-list">
                        <div class="cutout-list-item selected no-cutout">
                            <div class="cutout-list-item-img-container"></div>
                            <div class="cutout-list-item-info">
                                <span>No Cutout</span>
                            </div>
                        </div>
                    </div>
                    <button class="continue-btn">Confirm Selection</button>
                </div>
                <div id="img-preview-container">
                    <img style="display: none;" src="" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="confirmation-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h2>Client Info</h2>
                <p>Provide the client's details below. An email will be sent to them once the order has been created.</p>
            </div>
            <div class="modal-body">
                <form id="create-order-form" action="">
                    <h3>Contact Info</h3>
                    <div class="multiple-input-container">
                        <div class="input-container">
                            <input type="text" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="input-container">
                            <input type="text" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="multiple-input-container">
                        <div class="input-container">
                            <input type="text" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-container">
                            <input type="text" name="phone" placeholder="Phone" required>
                        </div>
                    </div>
                    <h3>Address Info</h3>
                    <div class="input-container">
                        <input type="text" name="address_1" placeholder="Street Address" required>
                    </div>
                    <div class="input-container">
                        <input type="text" name="town_or_city" placeholder="Town / City" required>
                    </div>
                    <div class="input-container">
                        <input type="text" name="state" placeholder="State" required>
                    </div>
                    <div class="input-container">
                        <input type="text" name="country" placeholder="Country" required>
                    </div>
                    <div class="input-container">
                        <textarea name="message" placeholder="Client's Message (optional)" required></textarea>
                    </div>
                    <h3>Internal</h3>
                    <div class="input-container">
                        <textarea name="internal_notes" placeholder="Any notes you may like to record (optional)" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn" for="create-order-form">Create Order</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        STATE.orders = [];
        STATE.cart = [];
        STATE.emailRegEx = /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;

        STATE.dTable = new DataTable("#orders-table", {
            ...STATE.dtDefaultOpts,
            ajax: {
                url: "/orders/getAll",
                dataSrc: function(response) {
                    console.log("response:", response);
                    let res = [];
                    STATE.ordersLookup = response.data;
                    if (response && response.data) {
                        STATE.orders = structuredClone(Object.values(response.data));
                        res = Object.values(response.data).map(order => {
                            order.internal_notes = order.internal_notes ? order.internal_notes : "-";
                            order.total_amount = "$" + formatPrice(order.total_amount);
                            return order;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }
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
                    data: 'current_status',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('status');
                    }
                },
                {
                    data: 'created_at',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('dt-type-date');
                    }
                }
            ],
            initComplete: async function() {
                setTimeout(() => {
                    handleInitTableRowEvents();
                    loadSconces();
                    loadCutouts();
                    loadAddOns();
                    this.api().on('draw', function() {
                        handleInitTableRowEvents();
                    });
                }, 100);
            }
        });

        function handleInvalidFormData() {
            const data = $("#create-order-form").serializeObject();
            let text;

            if (data.first_name === '') {
                text = "Please enter the client's first name.";
                element = $('input[name="first_name"]');
            } else if (data.last_name === '') {
                text = "Please enter the client's last name.";
                element = $('input[name="last_name"]');
            } else if (data.email === '') {
                text = "Please enter the client's email address.";
                element = $('input[name="email"]');
            } else if (!STATE.emailRegEx.test(data.email)) {
                text = "Please enter a valid email address.";
                element = $('input[name="email"]');
            } else if (data.phone === '') {
                text = "Please enter the client's phone number.";
                element = $('input[name="phone"]');
            } else if (data.address_1 === '') {
                text = "Please enter the client's address.";
                element = $('input[name="address_1"]');
            } else if (data.town_or_city === '') {
                text = "Please enter the client's town or city.";
                element = $('input[name="town_or_city"]');
            } else if (data.state === '') {
                text = "Please enter the client's state.";
                element = $('input[name="state"]');
            } else if (data.country === '') {
                text = "Please enter the client's country.";
                element = $('input[name="country"]');
            }

            if (text) {
                Swal.fire({
                    text,
                    title: "Incomplete form",
                    icon: "warning",
                });
                element.addClass('form-error');
            }

            return !text;
        }

        function parseType(item) {
            if (item.sconce_id) {
                return "sconce";
            } else if (item.one_of_a_kind_id) {
                return "one of a kind";
            } else if (item.cutout_id) {
                return "cutout";
            }
        }

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

                $(rowNode).addClass(`${data.current_status}_order`);

                rowNode.onclick = () => {
                    const modal = $("#order-details-modal");

                    modal.attr('data-status', data.current_status);
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

        function recalculateCartCount() {
            $(".sconce-panel .counter").html("");
            STATE.cart.forEach(item => {
                const id = item.item.sconce_id;
                const counter = $(`.sconce-panel[data-id="${id}"] .counter`);
                const currentCount = Number(counter.html());
                counter.html(currentCount + item.quantity);
            });

            const cartIsEmpty = !STATE.cart.length;
            $("#create-order-modal .modal-footer .continue-btn:not(.cancel)").toggleClass('disabled', cartIsEmpty);
        }

        async function loadAddOns() {
            await $.ajax({
                type: "GET",
                url: "/add-ons/getAll",
                contentType: "application/json",
                dataType: "json",
                success: res => {
                    if (res.status === 200 && res.data) {
                        STATE.addOnsLookup = res.data;
                        $(".info-section.sconce-add-ons").html("<h5>Add Ons</h5>");
                        Object.values(res.data).forEach(addOn => {
                            addOn = formatResource(addOn);
                            if ($(".info-section.sconce-add-ons").length) {
                                const addOnIdHTML = `${addOn.name.replaceAll(" ", "_").toLowerCase()}_add_on`;
                                const addOnEl = $(`
                                    <div class="input-container">
                                        <input id="${addOnIdHTML}" class="sconce-add-on" type="checkbox" value="${addOn.add_on_id}">
                                        <label for="${addOnIdHTML}"><span>${addOn.name}: </span>${addOn.description} ($${addOn.price})</label>
                                    </div>
                                `);

                                addOnEl.on('change', () => calculateNewTotal());

                                $(".info-section.sconce-add-ons").append(addOnEl);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "There was a problem"
                        });
                    }
                },
                error: function(_a, _b, errTxt) {
                    console.error(errTxt);
                }
            });
        }

        function getSortedSconces() {
            return Object.values(STATE.sconces).sort((a, b) => {
                // Extract the first character and numeric part from the 'name' field
                const nameA = a.name;
                const nameB = b.name;

                // Compare the first letter of the name
                const firstCharA = nameA.charAt(0).toLowerCase();
                const firstCharB = nameB.charAt(0).toLowerCase();

                if (firstCharA < firstCharB) return -1;
                if (firstCharA > firstCharB) return 1;

                // If first letters are the same, compare the numeric part
                const numericPartA = parseInt(nameA.slice(1), 10) || 0;
                const numericPartB = parseInt(nameB.slice(1), 10) || 0;

                return numericPartA - numericPartB;
            });
        }

        async function loadSconces() {
            await $.ajax({
                type: "GET",
                url: "/sconces/getAll?only_active=true",
                contentType: "application/json",
                dataType: "json",
                success: res => {
                    if (res.status === 200) {
                        if (res && res.data) {
                            STATE.sconcesLookup = structuredClone(res.data);
                            STATE.sconces = Object.values(res.data).map(s => {
                                s.base_price = formatPrice(s.base_price);
                                s.description = s.description ? s.description : "-";
                                s.deleted_at = s.deleted_at ? s.deleted_at : "-";
                                s.updated_by_email = s.updated_by_email ? s.updated_by_email : "-";
                                return s;
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                },
                error: function() {
                    console.log(arguments);
                }
            });

            $(".gallery").html("");

            getSortedSconces().forEach(sconce => {
                sconce = formatResource(sconce);
                STATE.sconcesLookup[sconce.sconce_id] = sconce;
                const sconceEl = $(`
                    <div data-id="${sconce.sconce_id}" class="sconce-panel">
                        <span class="counter"></span>
                        <span class="cancel">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        </span>
                        <img src="${sconce.image_url}" alt="Oops">
                        <div>
                            <h4>${sconce.name}</h4>
                            <span>${sconce.dimensions} (D/W/H)</span>
                            <div>
                                <span>$${sconce.base_price}<sub>(usd)</sub></span>
                                <span>View More...</span>
                            </div>
                        </div>
                    </div>
                `);

                sconceEl.on('click', () => setActiveSconce(sconce));

                sconceEl.find("span.cancel").on('click', async function(e) {
                    e.stopImmediatePropagation();
                    const id = $(this).closest('.sconce-panel').data('id');
                    const copiedCart = structuredClone(STATE.cart);

                    if (copiedCart.length > 1) {
                        var html = `
                            <p style="margin: 0 0 30px;">Please select which item(s) you'd like to remove from this order:</p>
                            <form id="remove-item-from-order-form">
                                ${copiedCart.reduce((itemsStr, item, idx) => {
                                    if (item.item.sconce_id !== id) return itemsStr;
                                    return itemsStr + `
                                        <div class="input-container">
                                            <input id="cancel-item-${idx}" style="width: 20px;" type="checkbox" value="${idx}">
                                            <label for="cancel-item-${idx}" style="max-width: 100%;">${item.lineItemDesc}</label>
                                        </div>
                                    `;
                                }, "")}
                            </form>
                        `;
                    } else {
                        var html = `Please confirm that you'd like to remove the following item from the order:<br><br> <strong>${copiedCart[0].lineItemDesc}</strong>`;
                    }

                    const choice = await Swal.fire({
                        icon: "warning",
                        title: "Removing Item Fom Order",
                        html,
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        preConfirm: () => {
                            try {
                                const indexesToRemove = [];
                                if (copiedCart.length > 1) {
                                    $("#remove-item-from-order-form input:checked").each((_idx, el) => {
                                        const idx = Number($(el).val());
                                        indexesToRemove.push(idx);
                                    });
                                } else {
                                    indexesToRemove.push(0);
                                }

                                if (!indexesToRemove.length) {
                                    throw new Error('Please select at least one item, or click "Cancel".');
                                }

                                let needToClarify = false;

                                const newCart = copiedCart.filter((item, idx) => {
                                    let res = true;
                                    if (indexesToRemove.includes(idx)) {
                                        if (item.quantity > 1) needToClarify = true;
                                        res = false;
                                    }

                                    return res;
                                });

                                if (needToClarify) {
                                    return indexesToRemove;
                                } else if (indexesToRemove.length) {
                                    STATE.cart = newCart;

                                    Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: `Item${indexesToRemove.length > 1 ? "s" : ""} successfully removed from the order`
                                    });

                                    recalculateCartCount();

                                    return null;
                                }
                            } catch ($e) {
                                return Swal.showValidationMessage($e.message);
                            }
                        }
                    });

                    if (!choice.isConfirmed || choice.value === null) return;

                    let indexesToRemove = choice.value;

                    const quantitiesChoice = await Swal.fire({
                        icon: "warning",
                        title: "Select Quantities",
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        html: `
                            <p style="margin: 0 0 30px;">Please select the quantity of each item listen below that you'd like to remove from this order:</p>
                            <form id="remove-item-from-order-form-quantity">
                                ${copiedCart.reduce((itemsStr, item, idx) => {
                                    if (!indexesToRemove.includes(idx)) return itemsStr;
                                    return itemsStr + `
                                        <div class="input-container">
                                            <input placeholder="" data-idx="${idx}" id="cancel-item-${idx}-quantity" type="number" value="${item.quantity}">
                                            <label for="cancel-item-${idx}-quantity">${item.lineItemDesc}</label>
                                        </div>
                                    `;
                                }, "")}
                            </form>
                        `,
                        didOpen: () => {
                            $("#remove-item-from-order-form-quantity input").on('input', function(evt) {
                                const idx = $(this).data('idx');
                                const maxQuantity = STATE.cart[idx].quantity;
                                const currentQuantity = $(this).val();
                                const match = currentQuantity.match(/\d+/g);
                                let newQuantity = match === null ? "" : match.join("");
                                if (newQuantity > maxQuantity) newQuantity = maxQuantity;
                                $(this).val(newQuantity);
                            });
                        },
                        preConfirm: () => {
                            let emptyInputs = false;
                            $("#remove-item-from-order-form-quantity input").each((_idx, el) => {
                                if (el.value === "") emptyInputs = true;
                            })

                            if (emptyInputs) {
                                Swal.showValidationMessage("All inputs need a value.");
                                setTimeout(() => {
                                    $('#remove-item-from-order-form-quantity input:placeholder-shown').first().focus();
                                }, 300);
                            } else {
                                const test = $("#remove-item-from-order-form-quantity input")
                                    .toArray()
                                    .reduce((lookup, input) => {
                                        lookup[$(input).data('idx')] = $(input).val();
                                        return lookup;
                                    }, {});
                                return test;
                            }
                        },
                    });

                    if (!quantitiesChoice.isConfirmed) return;

                    let unchangedItemsCount = 0;
                    let updatedItemsCount = 0;
                    let deletedItemsCount = 0;

                    STATE.cart = STATE.cart.reduce((newCart, item, idx) => {
                        const newQuantity = item.quantity - Number(quantitiesChoice.value[idx]);
                        if (isNaN(newQuantity)) {
                            // not editing this item's quantity in the cart
                            newCart.push(item);
                        } else {
                            let staysInCart = true;

                            if (newQuantity === item.quantity) {
                                unchangedItemsCount++;
                            } else if (newQuantity > 0) {
                                updatedItemsCount++;
                                item = {
                                    ...structuredClone(item),
                                    quantity: newQuantity,
                                    lineItemDesc: getLineItemDescription(newQuantity)
                                };
                            } else {
                                deletedItemsCount++;
                                staysInCart = false;
                            }

                            if (staysInCart) newCart.push(item);
                        }

                        return newCart;
                    }, []);

                    const unS = unchangedItemsCount === 1 ? "" : "s";
                    const upS = updatedItemsCount === 1 ? "" : "s";
                    const deS = deletedItemsCount === 1 ? "" : "s";

                    const unPlural = unchangedItemsCount === 1 ? "s" : "";
                    const upPlural = updatedItemsCount === 1 ? "its" : "their";
                    const dePlural = deletedItemsCount === 1 ? "was" : "were";

                    const text = `${unchangedItemsCount} item${unS} remain${unPlural} unchanged, ${updatedItemsCount} item${upS} had ${upPlural} quantity updated, and ${deletedItemsCount} item${deS} ${dePlural} removed from the order.`;

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text
                    });

                    recalculateCartCount();
                });

                $(".gallery").append(sconceEl);
            });
        }

        async function loadCutouts() {
            await $.ajax({
                type: "GET",
                url: "/cutouts/getAll",
                contentType: "application/json",
                dataType: "json",
                success: res => {
                    if (res.status === 200) {
                        if (res && res.data) {
                            STATE.cutoutsLookup = structuredClone(res.data);
                            STATE.cutouts = Object.values(res.data).map(c => {
                                c.price = formatPrice(c.price);
                                c.description = c.description ? c.description : "-";
                                c.deleted_at = c.deleted_at ? c.deleted_at : "-";
                                c.updated_by_email = c.updated_by_email ? c.updated_by_email : "-";
                                return c;
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                },
                error: function() {
                    console.log(arguments);
                }
            });

            STATE.cutouts.forEach(cutout => {
                cutout = formatResource(cutout);
                STATE.cutoutsLookup[cutout.cutout_id] = cutout;
                const cutoutEl = $(`
                    <div data-id="${cutout.cutout_id}" class="cutout-list-item">
                        <div class="cutout-list-item-img-container">
                            <img src="${cutout.image_url}" alt="">
                        </div>
                        <div class="cutout-list-item-info">
                            <span>${cutout.name}</span>
                            <div>
                                <span>$${cutout.base_price}</span>
                                <sub>(usd)</sub>
                            </div>
                        </div>
                    </div>
                `);

                $("#cutout-list").append(cutoutEl);
            });

            $(".cutout-list-item").on('click', function() {
                const selectedCutoutImg = $(this).find(".cutout-list-item-img-container img").attr('src');
                $(".cutout-list-item").removeClass('selected');
                $(this).addClass('selected');
                if ($(this).hasClass('no-cutout')) {
                    $("#img-preview-container img").hide();
                } else {
                    $("#img-preview-container img").attr('src', selectedCutoutImg).show();
                }
            });
        }

        function resetSconceModal() {
            $("#sconce-modal [data-quantity]").val(1);
            $(".cutout-list-item.no-cutout").trigger('click');
            $("#cutout-selection-container button").trigger('click');
            $(".sconce-add-on").each((_, el) => $(el).is(":checked") && $(el).trigger('click'));
        }

        function setActiveSconce(item, editingCart = false) {
            $("#create-order-modal .modal-close").trigger('click');
            $("#sconce-modal").addClass('showing');
            const sconce = editingCart ? item.item : item;
            const quantity = editingCart ? item.quantity : 1;

            if (sconce.sconce_id === STATE.activeSconce?.sconce_id && !editingCart) return;

            resetSconceModal();

            $("#sconce-modal .img-container img").attr("src", sconce.image_url);
            $("#sconce-modal [data-name]").text(sconce.name);
            $("#sconce-modal [data-base_price]>span").text(sconce.base_price);
            $("#sconce-modal [data-sku]").text("#" + sconce.sconce_id);
            $("#sconce-modal [data-description]").text(sconce.description || "This item has no description.");
            $("#sconce-modal [data-dimensions]").text(`${sconce.dimensions} (D/W/H)`);
            $("#sconce-modal [data-material]").text(sconce.material);
            $("#sconce-modal [data-color]").text(sconce.color);
            $("#sconce-modal [data-quantity]").val(quantity);
            $("#sconce-modal [data-total_price]>span").text(sconce.base_price);
            $("#sconce-modal [data-finish]").text(sconce.finish || "-");
            $("#sconce-modal [data-mounting_type]").text(sconce.mounting_type || "-");
            $("#sconce-modal [data-fitting_type]").text(sconce.fitting_type || "-");

            if (editingCart) {
                $("[data-cutout] span").text(sconce.cutout?.name || "No Cutout Selected");
                const cutoutId = sconce.cutout?.cutout_id;
                const cutoutEl = cutoutId ? $(`.cutout-list-item[data-id="${cutoutId}"]`) : $(".cutout-list-item.no-cutout");
                cutoutEl.trigger('click');
                $("[data-cutout] span").text(STATE.cutoutsLookup[cutoutId]?.name || "No Cutout Selected");
            }

            STATE.activeSconce = sconce;
        }

        function setActiveCutout(cutout) {
            STATE.activeCutout = cutout;
            $("[data-cutout] span").text(cutout?.name || "No Cutout Selected");
        }

        function calculateNewTotal() {
            const quantity = Number($("#sconce-modal [data-quantity]").val());
            const sconcePrice = Number(STATE?.activeSconce?.base_price);
            const cutoutPrice = Number(STATE?.activeCutout?.base_price) || 0;
            const basePrice = Object.values(getSelectedAddOnsInfo()).reduce((price, addOn) => {
                if (addOn.checked) price += Number(addOn.price);
                return price;
            }, sconcePrice + cutoutPrice);
            const newPrice = formatPrice(basePrice * quantity);
            $("#sconce-modal [data-total_price]>span").text(newPrice);
        }

        function getLineItemDescription(quantity) {
            const addOnsInfo = getSelectedAddOnsInfo();
            const cutoutStr = STATE.activeCutout ? `With "${STATE.activeCutout.name} Cutout"` : "Without Cutout";
            let initialDesc = `${quantity} x "${STATE.activeSconce.name}" sconce, ${cutoutStr}`;

            return Object.values(addOnsInfo).reduce((lineItemDesc, addOn) => {
                const addOnStr = (addOn.checked ? `With ` : `Without `) + addOn.name;
                return `${lineItemDesc}, ${addOnStr}`;
            }, initialDesc);
        };

        function getSelectedAddOnsInfo() {
            return $(".sconce-add-on").toArray().reduce((lookup, input) => {
                const id = $(input).val();
                lookup[id] = {
                    checked: $(input).is(":checked"),
                    ...STATE.addOnsLookup[id]
                }
                return lookup;
            }, {});
        }

        function generateOrderItemPrice(item) {
            const itemPrice = Number(item?.item?.base_price || 0);
            const cutoutPrice = Number(item?.item?.cutout?.base_price) || 0;
            const quantity = Number(item.quantity);
            const basePrice = Object.values(item.item.addOnIds || []).reduce((price, id) => {
                const addOn = STATE.addOnsLookup[id];
                return price + Number(addOn.price);
            }, itemPrice + cutoutPrice);

            return basePrice * quantity;
        }

        $(".info-container .info-section.collapsible h5").on("click", function() {
            $(this).closest('.info-section').toggleClass("collapsed");
        });

        $("button[for='create-order-form']").on('click', function() {
            if (!handleInvalidFormData()) return;

            const data = {
                action: "create",
                first_name: $('input[name="first_name"]').val().trim(),
                last_name: $('input[name="last_name"]').val().trim(),
                email: $('input[name="email"]').val().trim(),
                phone: $('input[name="phone"]').val().trim(),
                internal_notes: $('textarea[name="internal_notes"]').val().trim(),
                message: $('textarea[name="message"]').val().trim(),
                address_1: $('input[name="address_1"]').val().trim(),
                town_or_city: $('input[name="town_or_city"]').val().trim(),
                state: $('input[name="state"]').val().trim(),
                country: $('input[name="country"]').val().trim(),
                total_amount: STATE.cart.reduce((total, item) => (total + generateOrderItemPrice(item)), 0),
                order_items: STATE.cart.map(item => ({
                    item_type: item.type,
                    sconce_id: item.item.sconce_id || null,
                    cutout_id: item.item.cutout ? item.item.cutout.cutout_id : null,
                    quantity: item.quantity,
                    price: generateOrderItemPrice(item),
                    description: item.lineItemDesc,
                    add_on_ids: item.item.addOnIds
                }))
            };

            $.ajax({
                url: "/orders",
                method: "POST",
                dataType: "JSON",
                data,
                success: async (res) => {
                    await Swal.fire({
                        icon: res.status === 200 ? "success" : "error",
                        title: res.status === 200 ? "Success" : "Error",
                        text: res.message,
                    });

                    if (res.status === 200) {
                        STATE.cart = [];
                        recalculateCartCount();
                        $(".modal").removeClass('showing');
                        reloadOrdersTable();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(arguments);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorThrown,
                    });
                }
            });
        });

        $("#create-order-modal .modal-footer .continue-btn.cancel").on('click', function() {
            STATE.cart = [];
            recalculateCartCount();
            $("#create-order-modal .modal-close").trigger('click');
        });

        $("#create-order-modal .modal-footer .continue-btn:not(.cancel)").on('click', function() {
            if (!STATE.cart.length) {
                return Swal.fire({
                    icon: "warning",
                    title: "No Items in Order",
                    text: "Please add at least one item to the order before continuing."
                });
            }
            $(this).closest('.modal').find('.modal-close').trigger('click');
            $("#confirmation-modal").addClass('showing');
        });

        $("#add-to-order").on('click', function() {
            const quantity = Number($("#sconce-modal [data-quantity]").val());
            if (quantity < 1) {
                return Swal.fire({
                    icon: "warning",
                    title: "No Quantity",
                    text: "In order to add a sconce to your cart, you must have a quantity of 1 more."
                });
            }

            const lineItemDesc = getLineItemDescription(quantity);
            const addOnsInfo = getSelectedAddOnsInfo();
            let title = "Success";
            let text = `${lineItemDesc} successfully added to order!`;
            const addOnIds = Object.values(addOnsInfo).reduce((arr, addOn) => {
                if (addOn.checked) arr.push(addOn.add_on_id);
                return arr;
            }, []);

            try {
                const itemInCartIdx = STATE.cart.findIndex(item => {
                    return (
                        item.item.sconce_id === STATE.activeSconce.sconce_id &&
                        item?.item?.cutout?.cutout_id === STATE?.activeCutout?.cutout_id &&
                        arraysAreEqual(item?.item.addOnIds, addOnIds)
                    );
                });

                if (itemInCartIdx > -1) {
                    const currentQuantity = STATE.cart[itemInCartIdx].quantity;
                    const newQuantity = currentQuantity + quantity;
                    text = `The item (${getLineItemDescription(currentQuantity)}) is already in the order so we updated the quantity to "${newQuantity}"!`;
                    STATE.cart[itemInCartIdx] = {
                        ...structuredClone(STATE.cart[itemInCartIdx]),
                        quantity: newQuantity,
                        lineItemDesc: getLineItemDescription(newQuantity)
                    }
                } else {
                    STATE.cart.push({
                        type: "sconce",
                        item: {
                            ...structuredClone(STATE.activeSconce),
                            cutout: !STATE.activeCutout ? null : {
                                ...structuredClone(STATE.activeCutout)
                            },
                            addOnIds
                        },
                        quantity: Number(quantity),
                        lineItemDesc
                    });
                }

                resetSconceModal();
                recalculateCartCount();
            } catch (err) {
                title = "Error";
                text = err;
                console.log(err);
            }

            Swal.fire({
                title,
                text,
                icon: title.toLocaleLowerCase()
            });
        });

        $(".sconce-add-on").on('change', function() {
            calculateNewTotal();
        });

        $("[data-quantity]").on('input', function(evt) {
            const currentQuantity = $(this).val();
            const match = currentQuantity.match(/\d+/g);
            let newQuantity = match === null ? "" : match.join("");
            if (newQuantity > 100) newQuantity = 100;
            $(this).val(newQuantity);
            calculateNewTotal();
        });

        $("#cutout-list + button").on('click', function() {
            const selectedCutout = $(".cutout-list-item.selected");
            const cutoutId = selectedCutout.data('id');
            $("#cutout-modal .modal-close").trigger('click');
            setActiveCutout(STATE.cutoutsLookup[cutoutId]);
            calculateNewTotal();
        });

        $("[data-cutout]").on('click', async function(evt) {
            if ($(".cutout-list-item").length <= 1) await loadCutouts();
            $(".cutout-list-item").removeClass('selected');
            const activeId = STATE.activeCutout?.cutout_id;
            if (Number(activeId)) {
                $(`.cutout-list-item[data-id="${activeId}"]`).trigger('click');
            } else {
                $(`.cutout-list-item.no-cutout`).trigger('click');
            }
            $("#cutout-modal").addClass('showing');
        });

        $(".create-btn").on("click", () => {
            $("#create-order-modal").addClass("showing");
        });

        $(".order-option[data-status]").on('click', async function() {
            const statusData = {
                current_status: STATE.activeOrder.current_status,
                new_status: $(this).data('status'),
            };

            const css = 'style="text-transform: capitalize;"';

            if (statusData.current_status === statusData.new_status) {
                return Swal.fire({
                    icon: "info",
                    title: "Same Status",
                    html: `<strong>Order #${STATE.activeOrder.order_id}</strong> already has a status of <strong ${css}>"${statusData.new_status}"</strong>`,
                })
            }

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
                        $("#order-details-modal").attr('data-status', data.current_status);

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

        $("#confirmation-modal .modal-close, #sconce-modal .modal-close").on("click", function() {
            $("#create-order-modal").addClass("showing");
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
                console.log(item);
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
                                            <span>Description:</span>
                                            <span>${item.description || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Mounting Type:</span>
                                            <span>${item.mounting_type || "-"}</span>
                                        </div>
                                        <div>
                                            <span>Fitting Type:</span>
                                            <span>${item.fitting_type || "-"}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
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
                        <hr>
                        <div class="line-item add-ons" data-type="add-ons">
                            <div>
                                <h3>Add Ons</h3>
                            </div>
                            <div>
                                <div class="line-item-info">
                                    <div class="bottom">
                                        ${Object.values(STATE.addOnsLookup).map(addOn => {
                                            const addOnIds = orderItem.add_ons.map(addOn => addOn.add_on_id);
                                            const addOnIsApplied = addOnIds.includes(addOn.add_on_id);
                                            const finalAddOnStr = (addOnIsApplied ? "With" : "Without") + ` ${addOn.name}`
                                            return `
                                                <div>
                                                    <span>${finalAddOnStr}:</span>
                                                    <div>
                                                        <span>$${addOnIsApplied ? addOn.price : 0}</span>
                                                        <sub>(usd)</sub>
                                                    </div>
                                                </div>
                                            `;
                                        }).join('')}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line-item-total">
                            <p>${orderItem.description}</p>
                            <span data-price>$${formattedItemSubTotal}</span>
                        </div>
                    </div>
                `;

                $("#cart-list").append(lineItemContainer);

            });

        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>