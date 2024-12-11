<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <button class="create-btn continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2v5.632c0 .424-.272.795-.653.982A6 6 0 0 0 6 14c.006 4 3 7 5 8" />
                <path d="M10 5H8a2 2 0 0 0 0 4h.68" />
                <path d="M14 2v5.632c0 .424.272.795.652.982A6 6 0 0 1 18 14c0 4-3 7-5 8" />
                <path d="M14 5h2a2 2 0 0 1 0 4h-.68" />
                <path d="M18 22H6" />
                <path d="M9 2h6" />
            </svg>
            <span>Add New Item</span>
        </button>
        <table id="one-of-a-kind-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Thumb</th>
                    <th>Name</th>
                    <th>Dimensions</th>
                    <th>Material</th>
                    <th>Color</th>
                    <th>Weight</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Availability</th>
                    <th>Created</th>
                    <th>Last updated</th>
                    <?php if ($user['role_id'] === 1) { ?>
                        <th>Deleted At</th>
                    <?php } ?>
                    <th>Created By</th>
                    <th>Updated By</th>
                </tr>
            </thead>
        </table>
    </div>
</main>

<div id="create-one-of-a-kind-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Adding One of a Kind</h1>
            </div>
            <div class="modal-body">
                <form id="create-one-of-a-kind-form">
                    <div class="input-container one-of-a-kind-img-container">
                        <input multiple type="file" name="one-of-a-kind-imgs" class="one-of-a-kind-img-input" id="create-one-of-a-kind-img-input" style="display: none;">
                        <div class="one-of-a-kind-preview-container"></div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New One of a Kind" required>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="width">Width</label>
                            <input type="text" name="width" placeholder="12" required>
                        </div>
                        <div class="input-container">
                            <label for="height">Height</label>
                            <input type="text" name="height" placeholder="24" required>
                        </div>
                        <div class="input-container">
                            <label for="depth">Depth</label>
                            <input type="text" name="depth" placeholder="6" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label>Dimension Units</label>
                        <select name="dimension-units">
                            <option value="cm">cm</option>
                            <option value="in">in</option>
                        </select>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="material">Material</label>
                            <input type="text" name="material" placeholder="Porcelain" required>
                        </div>
                        <div class="input-container">
                            <label for="color">Color</label>
                            <input type="text" name="color" placeholder="Pearl white" required>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" placeholder="10" required>
                        </div>
                        <div class="input-container">
                            <label for="weight-units">Weight Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="text" name="base_price" placeholder="75" required>
                        </div>
                        <div class="input-container">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="text" name="stock_quantity" placeholder="100" required>
                        </div>
                        <div class="input-container">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="My most valuable one-of-a-kind!" required aria-required /></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-one-of-a-kind-form" type="submit" class="continue-btn">Submit</button>
            </div>
            <div id="drop-alert">Drop Image To Add</div>
        </div>
    </div>
</div>

<div id="edit-one-of-a-kind-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Editing One of a Kind</h1>
            </div>
            <div class="modal-body">
                <form id="edit-one-of-a-kind-form">
                    <div class="input-container">
                        <label>Id #</label>
                        <span id="edit-one-of-a-kind-id"></span>
                        <div class="edit-options-container">
                            <div class="edit-one-of-a-kind-option images">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 22H4a2 2 0 0 1-2-2V6" />
                                    <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18" />
                                    <circle cx="12" cy="8" r="2" />
                                    <rect width="16" height="16" x="6" y="2" rx="2" />
                                </svg>
                            </div>
                            <div class="edit-one-of-a-kind-option reset">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5" />
                                </svg>
                            </div>
                            <div class="edit-one-of-a-kind-option delete">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </div>
                            <div class="edit-one-of-a-kind-option restore">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="5" x="2" y="3" rx="1" />
                                    <path d="M4 8v11a2 2 0 0 0 2 2h2" />
                                    <path d="M20 8v11a2 2 0 0 1-2 2h-2" />
                                    <path d="m9 15 3-3 3 3" />
                                    <path d="M12 12v9" />
                                </svg>
                            </div>
                            <div class="options-border"></div>
                        </div>
                        <div class="edit-one-of-a-kind-option toggle-options">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" />
                                <path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                <path d="M12 2v2" />
                                <path d="M12 22v-2" />
                                <path d="m17 20.66-1-1.73" />
                                <path d="M11 10.27 7 3.34" />
                                <path d="m20.66 17-1.73-1" />
                                <path d="m3.34 7 1.73 1" />
                                <path d="M14 12h8" />
                                <path d="M2 12h2" />
                                <path d="m20.66 7-1.73 1" />
                                <path d="m3.34 17 1.73-1" />
                                <path d="m17 3.34-1 1.73" />
                                <path d="m11 13.73-4 6.93" />
                            </svg>
                        </div>
                    </div>
                    <hr style="border: solid 0.5px #d3d3d3;margin: 24px 0;">
                    <div class="input-container one-of-a-kind-img-container">
                        <input multiple type="file" name="one-of-a-kind-imgs" class="one-of-a-kind-img-input" id="edit-one-of-a-kind-img-input" style="display: none;">
                        <div class="one-of-a-kind-preview-container"></div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New One of a Kind" required>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="width">Width</label>
                            <input type="text" name="width" placeholder="12" required>
                        </div>
                        <div class="input-container">
                            <label for="height">Height</label>
                            <input type="text" name="height" placeholder="24" required>
                        </div>
                        <div class="input-container">
                            <label for="depth">Depth</label>
                            <input type="text" name="depth" placeholder="6" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label>Dimension Units</label>
                        <select name="dimension-units">
                            <option value="cm">cm</option>
                            <option value="in">in</option>
                        </select>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="material">Material</label>
                            <input type="text" name="material" placeholder="Porcelain" required>
                        </div>
                        <div class="input-container">
                            <label for="color">Color</label>
                            <input type="text" name="color" placeholder="Pearl white" required>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" placeholder="10" required>
                        </div>
                        <div class="input-container">
                            <label for="weight-units">Weight Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="text" name="base_price" placeholder="75" required>
                        </div>
                        <div class="input-container">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="text" name="stock_quantity" placeholder="100" required>
                        </div>
                        <div class="input-container">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="My most valuable one-of-a-kind!" required aria-required /></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button form="edit-one-of-a-kind-form" type="submit" class="continue-btn">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal images-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Images</h1>
            </div>
            <div class="modal-body">
                <div id="images-grid"></div>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button class="continue-btn confirm">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const dTable = new DataTable("#one-of-a-kind-table", {
            ...STATE.dtDefaultOpts,
            ajax: {
                url: "/one-of-a-kind/getAll",
                dataSrc: function(response) {
                    let res = [];
                    if (response && response.data) {
                        STATE.oneOfAKinds = structuredClone(Object.values(response.data));
                        res = Object.values(response.data).map(oak => {
                            oak.price = formatPrice(oak.price);
                            oak.description = oak.description ? oak.description : "-";
                            oak.deleted_at = oak.deleted_at ? oak.deleted_at : "-";
                            oak.updated_by_email = oak.updated_by_email ? oak.updated_by_email : "-";
                            return oak;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }

                    return res;
                }
            },
            columns: [{
                    data: 'one_of_a_kind_id'
                },
                {
                    data: 'image_url'
                },
                {
                    data: 'name'
                },
                {
                    data: 'dimensions'
                },
                {
                    data: 'material'
                },
                {
                    data: 'color'
                },
                {
                    data: 'weight'
                },
                {
                    data: 'price'
                },
                {
                    data: 'stock_quantity'
                },
                {
                    data: 'status'
                },
                {
                    data: 'description'
                },
                {
                    data: 'availability'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                <?php if ($user['role_id'] === 1) {
                    echo "{
                        data: 'deleted_at'
                    },";
                } ?> {
                    data: 'created_by_email'
                },
                {
                    data: 'updated_by_email'
                },
            ],
            initComplete: function() {
                handleInitTableRowEvents()
                this.api().on('draw', function() {
                    handleInitTableRowEvents();
                });
            }
        });

        (function init() {
            STATE.upload = {
                maxImageCount: 9,
                currentIdx: 0,
                imageCount: 0,
                carousel: null,
                images: {},
                existingImages: {},
                newImages: {},
                deletedImages: {},
            };
            STATE.activeId = null;

            setTimeout(() => dTable.draw(), 1000);
        })();

        function getImageNameAndUrl(id) {
            const data = STATE.oneOfAKinds.find(x => x.one_of_a_kind_id === id);
            const imageData = data.images?.[data.primary_image_id];
            const imageName = `${data.name}_${id}_${imageData?.image_id}`;
            const imageUrl = imageData ? imageData?.image_url : data.image_url;
            return [imageName, imageUrl];
        }

        function populateEditForm(id, reset = false) {
            const data = STATE.oneOfAKinds.find(x => x.one_of_a_kind_id === id);
            const modal = $("#edit-one-of-a-kind-modal");
            const imagesContainer = $("#images-grid");
            const [imageName, imageUrl] = getImageNameAndUrl(id);
            const dimensions = data.dimensions
                .split(" x ")
                .map(x => x.replace(/\D+/gi, ""));
            const weight = data.weight.replace(/\D+/gi, "");
            let cellsHTML = "";
            imagesContainer.children('.non-draggable').remove();

            modal.find('#edit-one-of-a-kind-id').text(id);
            modal.find('input[name="name"]').val(data.name);
            modal.find('input[name="width"]').val(dimensions[0]);
            modal.find('input[name="height"]').val(dimensions[1]);
            modal.find('input[name="depth"]').val(dimensions[2]);
            modal.find('input[name="material"]').val(data.material);
            modal.find('input[name="color"]').val(data.color);
            modal.find('input[name="weight"]').val(weight);
            modal.find('input[name="base_price"]').val(data.price);
            modal.find('input[name="stock_quantity"]').val(data.stock_quantity);
            modal.find('textarea[name="description"]').val(data.description);

            // handle rendering option buttons
            const isDeleted = data.deleted_at !== null;
            $(".edit-one-of-a-kind-option.restore").toggle(isDeleted);
            $(".edit-one-of-a-kind-option.delete").toggle(!isDeleted);

            if (STATE.activeId !== id || reset === true) {
                // Store existing images
                STATE.upload.existingImages = data.images ? data.images : {};
                STATE.upload.imageCount = Object.values(STATE.upload.existingImages).length;
                STATE.upload.newImages = {};
                STATE.upload.deletedImages = {};
                STATE.activeId = id;
                let idx = -1;

                if (data.images) {
                    for (const image_id in data.images) {
                        idx++;
                        const image = data.images[image_id];
                        const imageName = `${data.name}_${data.one_of_a_kind_id}_${image.image_id}`;
                        const isPrimary = image.image_id == data.primary_image_id;
                        const cellHTML = `
                            <div class="images-grid-item" data-idx="${image.image_id}" data-existing="true" data-image-id="${image.image_id}">
                                <div class="remove-image-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18"/>
                                        <path d="m6 6 12 12"/>
                                    </svg>
                                </div>
                                <img src="${image.image_url}" alt="${imageName}" title="${imageName}">
                            </div>
                        `;

                        if (isPrimary) {
                            $("#edit-one-of-a-kind-modal .one-of-a-kind-preview-container").html(`<img src="${image.image_url}" alt="${imageName}" title="${imageName}">`);
                            cellsHTML = cellHTML + cellsHTML;
                        } else {
                            cellsHTML += cellHTML;
                        }
                    }
                }
            }

            if (STATE.upload?.sortable?.el) {
                STATE.upload.sortable.destroy();
            }

            imagesContainer.html(cellsHTML);

            if (STATE.upload.imageCount !== STATE.upload.maxImageCount) {
                imagesContainer.append('<label for="edit-one-of-a-kind-img-input" class="images-grid-item non-draggable">+</label>');
            }

            // Initialize Sortable
            STATE.upload.sortable = new Sortable(imagesContainer[0], {
                animation: 150, // Smooth animation when dragging
                ghostClass: 'sortable-ghost', // Class applied to ghost element
                draggable: ".images-grid-item:not(.non-draggable)",
                filter: ".non-draggable",
                onEnd: function(evt) {
                    // Example: Logging new order of items
                }
            });
        }

        function handleInitTableRowEvents(reset = false) {
            dTable.rows().every(function(idx) {
                const rowNode = this.node();
                if (!rowNode) {
                    console.warn(`Row node not found for index ${idx}`);
                    return;
                }

                const id = this.data().one_of_a_kind_id;
                const [imageName, imageUrl] = getImageNameAndUrl(id);
                $(rowNode)
                    .find('td')
                    .eq(1)
                    .addClass("one-of-a-kind-thumb-td")
                    .html(`
                        <div>
                        <img src="${imageUrl}" alt="${imageName}">
                        </div>
                    `);

                rowNode.onclick = () => {
                    $(".edit-one-of-a-kind-option.toggle-options").removeClass('active');
                    populateEditForm(id);
                    $("#edit-one-of-a-kind-modal").addClass('showing');
                };

                if (this.data().deleted_at !== "-") $(rowNode).addClass('deleted_item');
            });

        }

        function getJSONDataFromForm(form) {
            return form.serializeObject();
        }

        function getFormValidationMsg(data, type = "create") {
            let errMsg = "";

            if (type === "create" || type === "edit") {
                if (!STATE.upload.imageCount) {
                    errMsg = "You need to upload at least one image";
                } else if (!data.name.length) {
                    errMsg = "Please provide your one of a kind with a name.";
                } else if (!data.width.length) {
                    errMsg = "Please provide your one of a kind with a width.";
                } else if (!data.width.match(STATE.regEx.decimal)) {
                    errMsg = `Width can only be a number. You entered: "${data.width}"`;
                } else if (!data.height.length) {
                    errMsg = "Please provide your one of a kind with a height.";
                } else if (!data.height.match(STATE.regEx.decimal)) {
                    errMsg = `Height can only be a number. You entered: "${data.height}"`;
                } else if (!data.depth.length) {
                    errMsg = "Please provide your one of a kind with a depth.";
                } else if (!data.depth.match(STATE.regEx.decimal)) {
                    errMsg = `Depth can only be a number. You entered: "${data.depth}"`;
                } else if (!data.material.length) {
                    errMsg = "Please provide your one of a kind with a material.";
                } else if (!data.color.length) {
                    errMsg = "Please provide your one of a kind with a color.";
                } else if (!data.weight.length) {
                    errMsg = "Please provide your one of a kind with a weight.";
                } else if (!data.weight.match(STATE.regEx.decimal)) {
                    errMsg = `Weight can only be a number. You entered: "${data.weight}"`;
                } else if (!data.base_price.length) {
                    errMsg = "Please provide your one of a kind with a price.";
                } else if (!data.base_price.match(STATE.regEx.decimal)) {
                    errMsg = `Price can only be a number. You entered: "${data.base_price}"`;
                } else if (!data.stock_quantity.length) {
                    errMsg = "Please provide your one of a kind with a stock quantity.";
                } else if (!data.stock_quantity.match(STATE.regEx.decimal)) {
                    errMsg = `Stock quantity can only be a number. You entered: "${data.stock_quantity}"`;
                } else if (!data.name.length) {
                    errMsg = "Please provide your one of a kind with a name.";
                }
            }

            return errMsg || null;
        }

        function handleMakePrimary(formData, idx, type) {
            const dataType = type.replace("Images", "");
            if (
                $("#images-grid .images-grid-item").first().data('idx') == idx &&
                $("#images-grid .images-grid-item").first().data(dataType)
            ) {
                formData.append('primary_image_idx', idx);
                formData.append('primary_image_type', type);
            }
        }

        $(".edit-one-of-a-kind-option.toggle-options").on("click", function() {
            $(this).toggleClass('active');
        });

        $(".create-btn").on("click", () => $("#create-one-of-a-kind-modal").addClass("showing"));

        $(".images-modal button.cancel").on('click', function(e) {
            e.preventDefault();
            $(this).closest('.modal').find('.modal-close').trigger('click');
        });

        $(".images-modal button.confirm").on('click', function(e) {
            e.preventDefault();
            const oneOfAKindId = $("#edit-one-of-a-kind-id").text();
            const name = $("#edit-one-of-a-kind-form [name='name']").val();

            const formData = new FormData();

            // Include existing image IDs to retain
            for (const idx in STATE.upload.existingImages) {
                const img = STATE.upload.existingImages[idx];
                formData.append(`existingImages[${idx}]`, img.image_id);
                handleMakePrimary(formData, idx, 'existingImages');
            }

            // Include new images
            for (const idx in STATE.upload.newImages) {
                const file = STATE.upload.newImages[idx];
                formData.append(`newImages[${idx}]`, file);
                handleMakePrimary(formData, idx, 'newImages');
            }

            // Include deleted image IDs
            for (const idx in STATE.upload.deletedImages) {
                const img = STATE.upload.deletedImages[idx];
                formData.append(`deletedImages[${idx}]`, img.image_id);
            }

            Swal.fire({
                icon: "warning",
                title: `Updating Images For "${name}"`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/one-of-a-kind/${oneOfAKindId}/images`,
                method: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-HTTP-Method-Override": "PUT" // Set custom header to tell server it's a PUT request
                },
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('button[form="edit-one-of-a-kind-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#edit-one-of-a-kind-form");
            const data = getJSONDataFromForm(form);
            const oneOfAKindId = $("#edit-one-of-a-kind-id").text();
            const formValidationMsg = getFormValidationMsg(data, "edit");

            if (formValidationMsg) {
                return Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: formValidationMsg
                });
            }

            Swal.fire({
                title: "Loading...",
                html: `Updating one of a kind, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/one-of-a-kind/${oneOfAKindId}`,
                method: "PUT",
                dataType: "JSON",
                contentType: "application/json",
                data: JSON.stringify(data),
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('button[form="create-one-of-a-kind-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#create-one-of-a-kind-form");
            const data = getJSONDataFromForm(form);
            const formValidationMsg = getFormValidationMsg(data);

            if (formValidationMsg) {
                return Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: formValidationMsg
                });
            }

            Swal.fire({
                title: "Loading...",
                html: `Creating one of a kind, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form[0]);
            formData.delete("one-of-a-kind-imgs");

            // Include new images
            for (const idx in STATE.upload.newImages) {
                const file = STATE.upload.newImages[idx];
                formData.append(`newImages[${idx}]`, file);
                handleMakePrimary(formData, idx, 'newImages');
            }

            $.ajax({
                url: "/one-of-a-kind",
                method: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('[name="dimension-units"]').on('change', function() {
            const form = $(this).closest('form');
            const widthEl = form.find('[name="width"]');
            const heightEl = form.find('[name="height"]');
            const depthEl = form.find('[name="depth"]');

            const toIn = $(this).val() === "in";

            widthEl.val(convertUnits('length', widthEl.val(), toIn));
            heightEl.val(convertUnits('length', heightEl.val(), toIn));
            depthEl.val(convertUnits('length', depthEl.val(), toIn));
        });

        $('[name="weight-units"]').on('change', function() {
            const form = $(this).closest('form');
            const weightEl = form.find('[name="weight"]');

            const toKg = $(this).val() === "kgs";

            weightEl.val(convertUnits('weight', weightEl.val(), toKg));
        });

        $("#edit-one-of-a-kind-modal .modal-close").on("click", function() {
            $(this)
                .closest('.modal')
                .find('.edit-one-of-a-kind-option.toggle-options')
                .removeClass('active');
        });

        $("#edit-one-of-a-kind-modal button.cancel").on("click", function() {
            $(this)
                .closest('.modal')
                .find('.modal-close')
                .trigger('click');
        });

        $(".edit-one-of-a-kind-option.reset").on("click", async function() {
            const res = await Swal.fire({
                icon: "warning",
                title: "Reseting Form",
                text: "Are you sure that you would like to reset this form? All of your changes will be lost.",
                showDenyButton: true,
                focusDeny: true, // Focuses on the "No" button when the dialog opens
            });

            if (!res.isConfirmed) return;

            populateEditForm(STATE.activeId, true);
        });

        $(".edit-one-of-a-kind-option.delete").on("click", async function() {
            const form = $("#edit-one-of-a-kind-form");
            const data = form.serializeObject();
            data.one_of_a_kind_id = $("#edit-one-of-a-kind-id").text();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${data.name}"`,
                text: "Are you sure that you would like to delete this one of a kind?",
                showDenyButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: 'No',
                reverseButtons: true, // Swaps the positions of the buttons
                focusDeny: true, // Focuses on the "No" button when the dialog opens
                customClass: {
                    confirmButton: 'swal-confirm-red',
                    denyButton: 'swal-deny-gray'
                }
            });

            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Loading...",
                html: `Deleting one of a kind, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/one-of-a-kind/${data.one_of_a_kind_id}`,
                method: "DELETE",
                dataType: "JSON",
                data,
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $(".edit-one-of-a-kind-option.images").on("click", function() {
            $(".modal.images-modal").addClass('showing');
        });

        $(".edit-one-of-a-kind-option.restore").on("click", async function() {
            const id = $("#edit-one-of-a-kind-id").text();
            const name = $("#edit-one-of-a-kind-form [name='name']");

            const res = await Swal.fire({
                icon: "warning",
                title: `Restoring "${name}"`,
                text: "Are you sure that you would like to restore this one of a kind?",
                showCancelButton: true,
                confirmButtonText: 'Restore',
                reverseButtons: true, // Swaps the positions of the buttons
                focusCancel: true, // Focuses on the "No" button when the dialog opens
            });

            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Loading...",
                html: `Restoring one of a kind, <strong>"${name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/one-of-a-kind/${id}/restore`,
                method: "PUT",
                dataType: "JSON",
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $("#images-grid").on("click", ".remove-image-btn", function(e) {
            const container = $(this).closest('.images-grid-item');
            const idx = container.data('idx');
            const isExisting = container.data("existing");
            const isNew = container.data("new");

            setTimeout(() => {
                /**
                 * Need this function to be asynchronous since it removes
                 * the container before the click event is called which triggers
                 * a click event on the document while the the target is
                 * removed from the dom. Basically it marks this condition as
                 * true: !target.closest(".modal-dialog").length in main.js
                 */
                if (isExisting) {
                    const imageId = container.data("image-id");
                    const img = STATE.upload.existingImages[imageId];
                    STATE.upload.deletedImages[imageId] = img; // Track for deletion
                }

                if (isNew) {
                    const newImgIdx = container.data("idx");
                    delete STATE.upload.newImages[newImgIdx]; // Remove from new images
                }

                container.remove();
                STATE.upload.imageCount = Math.max(STATE.upload.imageCount - 1, 0);

                const imagesContainer = $("#images-grid");
                if (
                    STATE.upload.imageCount < STATE.upload.maxImageCount &&
                    imagesContainer.has('label[for="edit-one-of-a-kind-img-input"]').length === 0
                ) {
                    imagesContainer.append('<label for="edit-one-of-a-kind-img-input" class="images-grid-item non-draggable">+</label>')
                }
            }, 100);
        });

        $(".one-of-a-kind-img-input").on('change', function() {
            // only ever for adding
            const incorrectFiles = [];
            const imagesContainer = $("#images-grid");
            let hitMaxCount = false;
            let cellsHTML = "";
            let selectedCellIdx = NaN;

            // first remove add button and check how many images can be added;
            imagesContainer.children(".non-draggable").remove();

            [...this.files].forEach(file => {
                if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
                    return incorrectFiles.push(file);
                } else if (STATE.upload.imageCount === STATE.upload.maxImageCount) {
                    return hitMaxCount = true;
                }

                const idx = STATE.upload.currentIdx++;
                const imagesCount = ++STATE.upload.imageCount;
                const imgSrc = URL.createObjectURL(file);
                STATE.upload.newImages[idx] = file;
                if (isNaN(selectedCellIdx)) {
                    selectedCellIdx = imagesCount - 1;
                }
                cellsHTML += `
                    <div class="images-grid-item" data-idx="${idx}" data-new="true">
                        <div class="remove-image-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        </div>
                        <img src="${imgSrc}" alt="${file.name}" title="${file.name}">
                    </div>
                `;
            });

            let html = "";
            let showSwal = false;

            if (incorrectFiles.length) {
                showSwal = true;
                html += `The following files are the wrong type:<br><ul>${incorrectFiles.reduce((lis, file) => {
                    lis +=`<li>${file.name}</li>`;
                    return lis;
                }, "")}</ul>`;
            }
            if (hitMaxCount) {
                showSwal = true;
                html += `You can only upload ${STATE.upload.maxImageCount} images at one time`;
            }

            if (showSwal) {
                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    html
                });
            }

            if (STATE.upload?.sortable?.el) {
                STATE.upload.sortable.destroy();
            }

            imagesContainer.append(cellsHTML);

            if (STATE.upload.imageCount !== STATE.upload.maxImageCount) {
                imagesContainer.append('<label for="edit-one-of-a-kind-img-input" class="images-grid-item non-draggable">+</label>')
            }

            STATE.upload.sortable = new Sortable(imagesContainer[0], {
                animation: 150, // Smooth animation when dragging
                ghostClass: 'sortable-ghost', // Class applied to ghost element
                draggable: ".images-grid-item:not(.non-draggable)",
                filter: ".non-draggable",
                onEnd: function(evt) {
                    // Example: Logging new order of items
                }
            });
            $(this).val('');
        });

        $("#create-one-of-a-kind-modal").on('drop', async function(evt) {
            evt.preventDefault();

            const origEvt = evt.originalEvent;

            if (origEvt.dataTransfer.items) {
                // Use DataTransferItemList interface to access the file(s)
                [...origEvt.dataTransfer.items].forEach(item => {
                    // If dropped items aren't files, reject them
                    if (item.kind === "file") {
                        const file = item.getAsFile();
                        if (file.type === 'application/pdf') {
                            return Swal.fire({
                                icon: "warning",
                                title: "Incorrect File Type",
                                text: "Please choose a file that is not a pdf."
                            });
                        }

                        STATE.imageToUpload = file;

                        const newFileName = file.name.replaceAll(/\.(png|jpeg|jpg)/gi, '');
                        const imgSrc = URL.createObjectURL(file);
                        $(this).find(".one-of-a-kind-preview-container").html(`
                        <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
                    `);
                        $(this).find('input[name="name"]').val(newFileName);
                    }
                });
            } else {
                // Use DataTransfer interface to access the file(s)
                [...origEvt.dataTransfer.files].forEach(file => {
                    if (file.type === 'application/pdf') {
                        return Swal.fire({
                            icon: "warning",
                            title: "Incorrect File Type",
                            text: "Please choose a file that is not a pdf."
                        });
                    }

                    STATE.imageToUpload = file;

                    const newFileName = file.name.replaceAll(/\.(png|jpeg|jpg)/gi, '');
                    const imgSrc = URL.createObjectURL(file);
                    $(this).find(".one-of-a-kind-preview-container").html(`
                    <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
                `);
                    $(this).find('input[name="name"]').val(newFileName);
                });
            }

            $("#drop-alert").removeClass('showing');
        }).on('dragover', function(evt) {
            evt.preventDefault();

            $("#drop-alert").addClass('showing');
        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>