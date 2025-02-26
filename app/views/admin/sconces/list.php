<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <button class="create-btn continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4h6l3 7H8l3-7Z"></path>
                <path d="M14 11v5a2 2 0 0 1-2 2H8"></path>
                <path d="M4 15h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4v-6Z"></path>
            </svg>
            <span>Add New Item</span>
        </button>
        <table id="sconces-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Thumb</th>
                    <th>Name</th>
                    <th>Dimensions</th>
                    <th>Material</th>
                    <th>Color</th>
                    <th>Weight</th>
                    <th>Base Price</th>
                    <th>Status</th>
                    <th>Description</th>
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

<div id="create-sconce-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Adding Sconce</h1>
            </div>
            <div class="modal-body">
                <form id="create-sconce-form">
                    <div class="input-container">
                        <div class="option-btns-container">
                            <div class="option-btn images">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 22H4a2 2 0 0 1-2-2V6" />
                                    <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18" />
                                    <circle cx="12" cy="8" r="2" />
                                    <rect width="16" height="16" x="6" y="2" rx="2" />
                                </svg>
                            </div>
                            <div class="option-btn reset">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5" />
                                </svg>
                            </div>
                            <div class="options-border"></div>
                        </div>
                        <div class="option-btn toggle-options">
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
                    <div class="input-container img-container">
                        <div class="img-preview-container"></div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New Sconce" required>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="depth">Depth</label>
                            <input type="text" name="depth" placeholder="6" required>
                        </div>
                        <div class="input-container">
                            <label for="width">Width</label>
                            <input type="text" name="width" placeholder="12" required>
                        </div>
                        <div class="input-container">
                            <label for="height">Height</label>
                            <input type="text" name="height" placeholder="24" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="dimension-units">Units</label>
                        <select name="dimension-units" id="dimension-units">
                            <option value="in">in</option>
                            <option value="cm">cm</option>
                        </select>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="material">Material</label>
                            <input type="text" name="material" placeholder="Porcelain" value="Ceramic" required>
                        </div>
                        <div class="input-container">
                            <label for="color">Color</label>
                            <input type="text" name="color" placeholder="Pearl white" value="Off White" required>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" placeholder="10" required>
                        </div>
                        <div class="input-container">
                            <label for="weight-units">Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="number" name="base_price" placeholder="75" required>
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
                        <textarea name="description" id="description" placeholder="My most valuable sconce!" required aria-required /></textarea>
                    </div>
                    <hr>
                    <div class="collapsible-container cutouts">
                        <div class="collapsible-container-title">
                            <h4>Cutouts</h4>
                            <svg class="toggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </div>
                        <span class="cutouts-associated"></span>
                        <span>(click icon to toggle)</span>
                        <div class="collapsible-options">
                            <div class="continue-btn">Select All</div>
                            <div class="continue-btn other">Deselect All</div>
                        </div>
                        <div class="collapsible-container-content"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-sconce-form" type="submit" class="continue-btn">Submit</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-sconce-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Editing Sconce</h1>
            </div>
            <div class="modal-body">
                <form id="edit-sconce-form">
                    <div class="input-container">
                        <label>Id #</label>
                        <span id="edit-sconce-id"></span>
                        <div class="option-btns-container">
                            <div class="option-btn images">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 22H4a2 2 0 0 1-2-2V6" />
                                    <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18" />
                                    <circle cx="12" cy="8" r="2" />
                                    <rect width="16" height="16" x="6" y="2" rx="2" />
                                </svg>
                            </div>
                            <div class="option-btn reset">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5" />
                                </svg>
                            </div>
                            <div class="option-btn delete">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </div>
                            <div class="option-btn restore">
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
                        <div class="option-btn toggle-options">
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
                    <div class="input-container img-container">
                        <input multiple type="file" class="img-input" id="edit-img-input">
                        <div class="img-preview-container"></div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New Sconce" required>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="depth">Depth</label>
                            <input type="text" name="depth" placeholder="6" required>
                        </div>
                        <div class="input-container">
                            <label for="width">Width</label>
                            <input type="text" name="width" placeholder="12" required>
                        </div>
                        <div class="input-container">
                            <label for="height">Height</label>
                            <input type="text" name="height" placeholder="24" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="dimension-units">Units</label>
                        <select name="dimension-units" id="dimension-units">
                            <option value="in">in</option>
                            <option value="cm">cm</option>
                        </select>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="material">Material</label>
                            <input type="text" name="material" placeholder="Ceramic" value="Ceramic" required>
                        </div>
                        <div class="input-container">
                            <label for="color">Color</label>
                            <input type="text" name="color" placeholder="Off White" value="Off White" required>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="weight">Weight</label>
                            <input type="text" name="weight" placeholder="10" required>
                        </div>
                        <div class="input-container">
                            <label for="weight-units">Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="number" name="base_price" placeholder="75" required>
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
                        <textarea name="description" id="description" placeholder="My most valuable sconce!" required aria-required /></textarea>
                    </div>
                    <hr>
                    <div class="collapsible-container cutouts">
                        <div class="collapsible-container-title">
                            <h4>Cutouts</h4>
                            <svg class="toggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </div>
                        <span class="cutouts-associated"></span>
                        <span>(click icon to toggle)</span>
                        <div class="collapsible-options">
                            <div class="continue-btn">Select All</div>
                            <div class="continue-btn other">Deselect All</div>
                        </div>
                        <div class="collapsible-container-content"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button form="edit-sconce-form" type="submit" class="continue-btn">Update</button>
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
                <div class="images-grid"></div>
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

        STATE.dTable = new DataTable("table", {
            ...STATE.dtDefaultOpts,
            columnDefs: [{
                type: 'natural',
                target: 2
            }],
            order: [
                [2, 'asc']
            ],
            ajax: {
                url: "/sconces/getAll",
                dataSrc: function(response) {
                    let res = [];
                    if (response && response.data) {
                        STATE.sconces = structuredClone(Object.values(response.data));
                        res = Object.values(response.data).map(s => {
                            s.base_price = formatPrice(s.base_price);
                            s.description = s.description ? s.description : "-";
                            s.created_at = s.created_at ? formatReadableDate(s.created_at, false) : "-";
                            s.updated_at = s.updated_at ? formatReadableDate(s.updated_at, false) : "-";
                            s.deleted_at = s.deleted_at ? formatReadableDate(s.deleted_at, false) : "-";
                            s.updated_by_email = s.updated_by_email ? s.updated_by_email : "-";
                            return s;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }
                    return res;
                }
            },
            columns: [{
                    data: 'sconce_id'
                },
                {
                    data: 'image_url'
                },
                {
                    data: 'name'
                },
                {
                    data: 'dimensions',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('dt-dimensions');
                    }
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
                    data: 'base_price'
                },
                {
                    data: 'status'
                },
                {
                    data: 'description',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('dt-description');
                    }
                },
                {
                    data: 'created_at',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('dt-type-date');
                    }
                },
                {
                    data: 'updated_at',
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Add class based on current_status value
                        $(td).addClass('dt-type-date');
                    }
                },
                <?php if ($user['role_id'] === 1) { ?> {
                        data: 'deleted_at',
                        createdCell: function(td, cellData, rowData, row, col) {
                            // Add class based on current_status value
                            $(td).addClass('dt-type-date');
                        }
                    },
                <?php } ?> {
                    data: 'created_by_email'
                },
                {
                    data: 'updated_by_email'
                },
            ],
            initComplete: async function() {
                handleInitTableRowEvents();
                this.api().on('draw', function() {
                    handleInitTableRowEvents();
                });
                fetchCutouts().then(() => {
                    renderCutoutAssociations();
                    calculateSelectedCutouts("#create-sconce-modal");
                    calculateSelectedCutouts("#edit-sconce-modal");
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
            resetImagesModal();

            setTimeout(() => STATE.dTable.draw(), 1000);
        })();

        function reloadTable(populateForm = false) {
            STATE.dTable.ajax.reload(null, false); // false ensures the current paging stays the same
            if (!populateForm) return;

            STATE.fetchingData = true;
            const populateFormInterval = setInterval(() => {
                if (STATE.fetchingData === false) {
                    populateEditForm(STATE.activeId, true);
                    clearInterval(populateFormInterval);
                }
            }, 250);
        }

        async function fetchCutouts() {
            await $.ajax({
                url: "/cutouts/getAll?include_sconce_relations=true",
                method: "GET",
                dataType: "JSON",
                success: res => {
                    const {
                        data,
                        status,
                        message
                    } = res;
                    const success = status === 200;

                    if (status !== 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: message,
                        });
                    } else {
                        STATE.cutoutsLookup = data;
                    }
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        }

        function renderCutoutAssociations() {
            $(".collapsible-container.cutouts .collapsible-container-content").html("");
            Object.values(STATE.cutoutsLookup).forEach(cutout => {
                $(".collapsible-container.cutouts .collapsible-container-content").append(`
                    <div data-id="${cutout.cutout_id}" class="sconce-cutout-container">
                        <input type="hidden" value="1" name="cutout_ids[${cutout.cutout_id}]" />
                        <div>
                            <img src="${cutout.image_url}" />
                            <span>${cutout.code}</span>
                        </div>
                    </div>
                `);
            });

            $(".sconce-cutout-container").on('click', function() {
                const input = $(this).find("input");
                const oldVal = Number(input.val());
                const newVal = Number(!oldVal);
                input.val(newVal);
                const modal = $(this).closest(".modal");
                calculateSelectedCutouts(modal);
            });
        }

        function handleInitTableRowEvents(reset = false) {
            STATE.dTable.rows().every(function(idx) {
                const rowNode = this.node();
                if (!rowNode) {
                    console.warn(`Row node not found for index ${idx}`);
                    return;
                }

                const id = this.data().sconce_id;
                const [imageName, imageUrl] = getImageNameAndUrl(id);
                $(rowNode)
                    .find('td')
                    .eq(1)
                    .addClass("sconce-thumb-td")
                    .html(`
                        <div>
                            <img src="${imageUrl}" alt="${imageName}">
                        </div>
                    `);

                rowNode.onclick = () => {
                    $(".option-btn.toggle-options").removeClass('active');
                    populateEditForm(id);
                    $("#edit-sconce-modal").addClass('showing');
                };

                if (this.data().deleted_at !== "-") $(rowNode).addClass('deleted_item');
            });

        }

        function getImageNameAndUrl(id) {
            const data = STATE.sconces.find(x => x.sconce_id === id);
            const imageData = data.images?.[data.primary_image_id];
            const imageName = `${data.name}_${id}_${imageData?.image_id}`;
            const imageUrl = imageData ? imageData?.image_url : data.image_url;
            return [imageName, imageUrl];
        }

        function populateEditForm(id, reset = false) {
            const data = STATE.sconces.find(x => x.sconce_id === id);
            const modal = $("#edit-sconce-modal");
            const dimensions = data.dimensions
                .split(" x ")
                .map(x => x.replace(/\D+/gi, ""));
            const weight = data.weight.replace(/\D+/gi, "");

            modal.find('#edit-sconce-id').text(id);
            modal.find('input[name="name"]').val(data.name);
            modal.find('input[name="depth"]').val(dimensions[0]);
            modal.find('input[name="width"]').val(dimensions[1]);
            modal.find('input[name="height"]').val(dimensions[2]);
            modal.find('input[name="material"]').val(data.material);
            modal.find('input[name="color"]').val(data.color);
            modal.find('input[name="weight"]').val(weight);
            modal.find('input[name="base_price"]').val(data.base_price);
            modal.find('textarea[name="description"]').val(data.description);

            // handle rendering option buttons
            const isDeleted = data.deleted_at !== null;
            $(".option-btn.restore").toggle(isDeleted);
            $(".option-btn:not(.restore):not(.toggle-options)").toggle(!isDeleted);

            // handle sconce associations
            $(".sconce-cutout-container").each((_i, container) => {
                const cutout_id = $(container).data('id');
                const sconceIsRelated = STATE.cutoutsLookup[cutout_id].sconce_ids.includes(id);
                const newVal = Number(sconceIsRelated);
                $(container).find('input').val(newVal);
            });

            calculateSelectedCutouts("#edit-sconce-modal");
            populateImagesModal(data, reset);
        }

        function calculateSelectedCutouts(modal, id = STATE.activeId) {
            const selectedCutouts = $(modal).find(".sconce-cutout-container input[type='hidden'][value='1']");
            const notSelectedCount = Object.keys(STATE.cutoutsLookup).length - selectedCutouts.length;
            $(modal).find(".cutouts-associated").html(`Selected: <b>${selectedCutouts.length}</b>. Not selected: <b>${notSelectedCount}</b>`);
        }

        function populateImagesModal(data, reset = false) {
            const id = data?.sconce_id || null;
            const imagesContainer = $(".images-grid");
            let cellsHTML = "";

            if (STATE.activeId !== id || reset === true) {
                // Store existing images
                STATE.upload.existingImages = data.images ? data.images : {};
                STATE.upload.imageCount = Object.values(STATE.upload.existingImages).length;
                STATE.upload.newImages = {};
                STATE.upload.deletedImages = {};
                STATE.activeId = id;
                let idx = -1;

                for (const image_id in data.images) {
                    idx++;
                    const image = data.images[image_id];
                    const imageName = `${data.name}_${data.sconce_id}_${image.image_id}`;
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
                        $("#edit-sconce-modal .img-preview-container").html(`<img src="${image.image_url}" alt="${imageName}" title="${imageName}">`);
                        cellsHTML = cellHTML + cellsHTML;
                    } else {
                        cellsHTML += cellHTML;
                    }
                }
            }

            if (STATE.upload?.sortable?.el) {
                STATE.upload.sortable.destroy();
            }

            imagesContainer.html(cellsHTML);

            if (STATE.upload.imageCount !== STATE.upload.maxImageCount) {
                imagesContainer.append('<label for="edit-img-input" class="images-grid-item non-draggable">+</label>');
            }

            // Initialize Sortable
            STATE.upload.sortable = new Sortable(imagesContainer[0], {
                animation: 150, // Smooth animation when dragging
                ghostClass: 'sortable-ghost', // Class applied to ghost element
                draggable: ".images-grid-item:not(.non-draggable)",
                filter: ".non-draggable",
                onEnd: function(evt) {
                    handleSetPreviewImage()
                }
            });
        }

        function handleSetPreviewImage() {
            const modal = $("#create-sconce-modal");
            if (!modal.hasClass('showing')) return;
            const idx = $(".images-grid-item:not(.non-draggable)").first().data('idx');
            const file = STATE.upload.newImages[idx];
            const imgSrc = URL.createObjectURL(file);
            modal.find(".img-preview-container")
                .html(`<img src="${imgSrc}" alt="${file.name}" title="${file.name}">`);
        }

        function resetImagesModal() {
            const imagesContainer = $(".images-grid");

            if (STATE.upload?.sortable?.el) STATE.upload.sortable.destroy();

            imagesContainer.html('<label for="edit-img-input" class="images-grid-item non-draggable">+</label>');

            // Initialize Sortable
            STATE.upload.sortable = new Sortable(imagesContainer[0], {
                animation: 150, // Smooth animation when dragging
                ghostClass: 'sortable-ghost', // Class applied to ghost element
                draggable: ".images-grid-item:not(.non-draggable)",
                filter: ".non-draggable",
                onEnd: () => handleSetPreviewImage()
            });

            STATE.upload.existingImages = {};
            STATE.upload.imageCount = 0;
            STATE.upload.newImages = {};
            STATE.upload.deletedImages = {};
            STATE.activeId = null;
        }

        function resetModal(modal) {
            modal.find('input[name="name"]').val("");
            modal.find('input[name="depth"]').val("");
            modal.find('input[name="width"]').val("");
            modal.find('input[name="height"]').val("");
            modal.find('input[name="material"]').val("Ceramic");
            modal.find('input[name="color"]').val("Off White");
            modal.find('input[name="weight"]').val("");
            modal.find('input[name="base_price"]').val("");
            modal.find('textarea[name="description"]').val("");
            modal.find('.img-preview-container').html("");

            resetImagesModal();
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
                    errMsg = "Please provide your sconce with a name.";
                } else if (!data.depth.length) {
                    errMsg = "Please provide your sconce with a depth.";
                } else if (!data.depth.match(STATE.regEx.decimal)) {
                    errMsg = `Depth can only be a number. You entered: "${data.depth}"`;
                } else if (!data.width.length) {
                    errMsg = "Please provide your sconce with a width.";
                } else if (!data.width.match(STATE.regEx.decimal)) {
                    errMsg = `Width can only be a number. You entered: "${data.width}"`;
                } else if (!data.height.length) {
                    errMsg = "Please provide your sconce with a height.";
                } else if (!data.height.match(STATE.regEx.decimal)) {
                    errMsg = `Height can only be a number. You entered: "${data.height}"`;
                } else if (!data.material.length) {
                    errMsg = "Please provide your sconce with a material.";
                } else if (!data.color.length) {
                    errMsg = "Please provide your sconce with a color.";
                } else if (!data.weight.length) {
                    errMsg = "Please provide your sconce with a weight.";
                } else if (!data.weight.match(STATE.regEx.decimal)) {
                    errMsg = `Weight can only be a number. You entered: "${data.weight}"`;
                } else if (!data.base_price.length) {
                    errMsg = "Please provide your sconce with a price.";
                } else if (!data.base_price.match(STATE.regEx.decimal)) {
                    errMsg = `Price can only be a number. You entered: "${data.base_price}"`;
                } else if (!data.name.length) {
                    errMsg = "Please provide your sconce with a name.";
                }
            }

            return errMsg || null;
        }

        function handleMakePrimary(formData, idx, type) {
            const dataType = type.replace("Images", "");
            if (
                $(".images-grid .images-grid-item").first().data('idx') == idx &&
                $(".images-grid .images-grid-item").first().data(dataType)
            ) {
                formData.append('primary_image_idx', idx);
                formData.append('primary_image_type', type);
            }
        }

        $(".collapsible-options .continue-btn:not(.other)").on('click', function() {
            const modal = $(this).closest('.modal');
            modal.find(".sconce-cutout-container").each((_, container) => {
                const input = $(container).find("input");
                const currentVal = Number(input.val());
                if (!currentVal) $(container).trigger('click');
            })
        });

        $(".collapsible-options .continue-btn.other").on('click', function() {
            const modal = $(this).closest('.modal');
            modal.find(".sconce-cutout-container").each((_, container) => {
                const input = $(container).find("input");
                const currentVal = Number(input.val());
                if (currentVal) $(container).trigger('click');
            })
        });

        $(".collapsible-container-title").on("click", function() {
            $(this).closest('.collapsible-container').toggleClass('hidden');
        });

        $(".option-btn.toggle-options").on("click", function() {
            $(this).toggleClass('active');
        });

        $(".create-btn").on("click", () => {
            $("#create-sconce-modal").addClass("showing");
            if (STATE.activeId !== null) {
                resetImagesModal();
                $("#create-sconce-modal").find(".img-preview-container").html("");
            }
        });

        $(".images-modal button.cancel").on('click', function(e) {
            e.preventDefault();
            $(this).closest('.modal').find('.modal-close').trigger('click');
            let data = {};
            if ($("#edit-sconce-modal").hasClass("showing")) {
                const sconceId = $("#edit-sconce-id").text();
                data = STATE.sconces.find(x => x.sconce_id === Number(sconceId));
            } else if ($("#create-sconce-modal").hasClass("showing")) {
                $("#create-sconce-modal .img-preview-container").html("");
            }
            setTimeout(() => populateImagesModal(data, true), 400);
        });

        $(".images-modal button.confirm").on('click', function(e) {
            e.preventDefault();
            if ($("#create-sconce-modal").hasClass("showing")) {
                return $(this).closest('.modal').find(".modal-close").trigger("click");
            };

            const sconceId = $("#edit-sconce-id").text();
            const name = $("#edit-sconce-form [name='name']").val();

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
                url: `/sconces/${sconceId}/images`,
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
                    });

                    reloadTable(true);
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('button[form="edit-sconce-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#edit-sconce-form");
            const data = getJSONDataFromForm(form);
            const sconceId = $("#edit-sconce-id").text();
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
                html: `Updating sconce, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/sconces/${sconceId}`,
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
                    });

                    reloadTable(true);
                    fetchCutouts();
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('button[form="create-sconce-form"]').off('click').on("click", function(e) {
            e.preventDefault();

            const form = $("#create-sconce-form");
            const data = getJSONDataFromForm(form);
            const formValidationMsg = getFormValidationMsg(data);

            console.log("data:", data);
            
            if (formValidationMsg) {
                return Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: formValidationMsg
                });
            }

            Swal.fire({
                title: "Loading...",
                html: `Creating sconce, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form[0]);

            // Include new images
            for (const idx in STATE.upload.newImages) {
                const file = STATE.upload.newImages[idx];
                formData.append(`newImages[${idx}]`, file);
                handleMakePrimary(formData, idx, 'newImages');
            }

            $.ajax({
                url: "/sconces",
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
                    });

                    reloadTable();
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('[name="dimension-units"]').on('change', function() {
            const form = $(this).closest('form');
            const depthEl = form.find('[name="depth"]');
            const widthEl = form.find('[name="width"]');
            const heightEl = form.find('[name="height"]');

            const toIn = $(this).val() === "in";

            depthEl.val(convertUnits('length', depthEl.val(), toIn));
            widthEl.val(convertUnits('length', widthEl.val(), toIn));
            heightEl.val(convertUnits('length', heightEl.val(), toIn));
        });

        $('[name="weight-units"]').on('change', function() {
            const form = $(this).closest('form');
            const weightEl = form.find('[name="weight"]');

            const toKg = $(this).val() === "kgs";

            weightEl.val(convertUnits('weight', weightEl.val(), toKg));
        });

        $("#edit-sconce-modal .modal-close").on("click", function() {
            $(this)
                .closest('.modal')
                .find('.option-btn.toggle-options')
                .removeClass('active');
        });

        $("#edit-sconce-modal button.cancel").on("click", function() {
            $(this)
                .closest('.modal')
                .find('.modal-close')
                .trigger('click');
        });

        $(".option-btn.reset").on("click", async function() {
            const res = await Swal.fire({
                icon: "warning",
                title: "Reseting Form",
                text: "Are you sure that you would like to reset this form? All of your changes will be lost.",
                showDenyButton: true,
                focusDeny: true, // Focuses on the "No" button when the dialog opens
            });

            if (!res.isConfirmed) return;

            if ($("#create-sconce-modal").hasClass("showing")) {
                resetModal($("#create-sconce-modal"));
            } else {
                populateEditForm(STATE.activeId, true);
            }

        });

        $(".option-btn.delete").on("click", async function() {
            const sconceId = $("#edit-sconce-id").text();
            const name = $("#edit-sconce-form [name='name']").val();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${name}"`,
                text: "Are you sure that you would like to delete this sconce?",
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
                html: `Deleting sconce, <strong>"${name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/sconces/${sconceId}`,
                method: "DELETE",
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
                    });

                    reloadTable();
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $(".option-btn.images").on("click", function() {
            $(".modal.images-modal").addClass('showing');
        });

        $(".option-btn.restore").on("click", async function() {
            const id = $("#edit-sconce-id").text();
            const name = $("#edit-sconce-form [name='name']").val();

            const res = await Swal.fire({
                icon: "warning",
                title: `Restoring "${name}"`,
                text: "Are you sure that you would like to restore this sconce?",
                showCancelButton: true,
                confirmButtonText: 'Restore',
                reverseButtons: true, // Swaps the positions of the buttons
                focusCancel: true, // Focuses on the "No" button when the dialog opens
            });

            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Loading...",
                html: `Restoring sconce, <strong>"${name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/sconces/${id}/restore`,
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
                    });

                    reloadTable(true);
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $(".images-grid").on("click", ".remove-image-btn", function(e) {
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

                const imagesContainer = $(".images-grid");
                if (
                    STATE.upload.imageCount < STATE.upload.maxImageCount &&
                    imagesContainer.has('label[for="edit-img-input"]').length === 0
                ) {
                    imagesContainer.append('<label for="edit-img-input" class="images-grid-item non-draggable">+</label>')
                }
            }, 100);
        });

        $(".img-input").on('change', function() {
            // only ever for adding
            const incorrectFiles = [];
            const imagesContainer = $(".images-grid");
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
                imagesContainer.append('<label for="edit-img-input" class="images-grid-item non-draggable">+</label>')
            }

            STATE.upload.sortable = new Sortable(imagesContainer[0], {
                animation: 150, // Smooth animation when dragging
                ghostClass: 'sortable-ghost', // Class applied to ghost element
                draggable: ".images-grid-item:not(.non-draggable)",
                filter: ".non-draggable",
                onEnd: function(evt) {
                    handleSetPreviewImage()
                }
            });
            $(this).val('');
            if ($("#create-sconce-modal").hasClass("showing")) {
                handleSetPreviewImage();
            }
        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>