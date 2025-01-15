<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <button class="create-btn continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5.42 9.42 8 12" />
                <circle cx="4" cy="8" r="2" />
                <path d="m14 6-8.58 8.58" />
                <circle cx="4" cy="16" r="2" />
                <path d="M10.8 14.8 14 18" />
                <path d="M16 12h-2" />
                <path d="M22 12h-2" />
            </svg>
            <span>Add New Item</span>
        </button>
        <table>
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Cutout Type</th>
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

<div id="create-cutout-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Adding Cutout</h1>
            </div>
            <div class="modal-body">
                <form id="create-cutout-form">
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
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="New Cutout" required>
                        </div>
                        <div class="input-container">
                            <label for="code">Code</label>
                            <input type="text" name="code" placeholder="C54" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="cutout_type">Cutout Type</label>
                        <input type="text" name="cutout_type" placeholder="Nature" required>
                    </div>
                    <div class="input-container">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="My most valuable cutout!" required aria-required /></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-cutout-form" type="submit" class="continue-btn">Submit</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-cutout-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Editing Cutout</h1>
            </div>
            <div class="modal-body">
                <form id="edit-cutout-form">
                    <div class="input-container">
                        <label>Id #</label>
                        <span id="edit-cutout-id"></span>
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
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="New Cutout" required>
                        </div>
                        <div class="input-container">
                            <label for="code">Code</label>
                            <input type="text" name="code" placeholder="C54" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="cutout_type">Cutout Type</label>
                        <input type="text" name="cutout_type" placeholder="Nature" required>
                    </div>
                    <div class="input-container">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="My most valuable cutout!" required aria-required /></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button form="edit-cutout-form" type="submit" class="continue-btn">Update</button>
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
            ajax: {
                url: "/cutouts/getAll",
                dataSrc: function(response) {
                    console.log("herererer");
                    let res = [];
                    if (response && response.data) {
                        STATE.cutouts = structuredClone(Object.values(response.data));
                        res = Object.values(response.data).map(cutout => {
                            cutout.price = formatPrice(cutout.price);
                            cutout.code = cutout.code ? cutout.code : "-";
                            cutout.description = cutout.description ? cutout.description : "-";
                            cutout.deleted_at = cutout.deleted_at ? cutout.deleted_at : "-";
                            cutout.updated_by_email = cutout.updated_by_email ? cutout.updated_by_email : "-";
                            return cutout;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }

                    STATE.fetchingData = false;
                    return res;
                }
            },
            columns: [{
                    data: 'cutout_id'
                },
                {
                    data: 'image_url'
                },
                {
                    data: 'name'
                },
                {
                    data: 'code'
                },
                {
                    data: 'description'
                },
                {
                    data: 'cutout_type'
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
            STATE.fetchingData = false;
            STATE.activeId = null;
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
            resetImagesModal();

            setTimeout(() => dTable.draw(), 1000);
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

        function handleInitTableRowEvents(reset = false) {
            STATE.dTable.rows().every(function(idx) {
                const rowNode = this.node();
                if (!rowNode) {
                    console.warn(`Row node not found for index ${idx}`);
                    return;
                }

                const id = this.data().cutout_id;
                const [imageName, imageUrl] = getImageNameAndUrl(id);
                $(rowNode)
                    .find('td')
                    .eq(1)
                    .addClass("cutout-thumb-td")
                    .html(`
                        <div>
                            <img src="${imageUrl}" alt="${imageName}">
                        </div>
                    `);

                rowNode.onclick = () => {
                    $(".option-btn.toggle-options").removeClass('active');
                    populateEditForm(id);
                    $("#edit-cutout-modal").addClass('showing');
                };

                if (this.data().deleted_at !== "-") $(rowNode).addClass('deleted_item');
            });
        }

        function getImageNameAndUrl(id) {
            const data = STATE.cutouts.find(x => x.cutout_id === id);
            const imageData = data.images?.[data.primary_image_id];
            const imageName = `${data.name}_${id}_${imageData?.image_id}`;
            const imageUrl = imageData ? imageData?.image_url : data.image_url;
            return [imageName, imageUrl];
        }

        function populateEditForm(id, reset = false) {
            const data = STATE.cutouts.find(x => x.cutout_id === id);
            const modal = $("#edit-cutout-modal");
            modal.find('#edit-cutout-id').text(id);
            modal.find('input[name="name"]').val(data.name);
            modal.find('input[name="code"]').val(data.code);
            modal.find('input[name="cutout_type"]').val(data.cutout_type);
            modal.find('textarea[name="description"]').val(data.description);

            // handle rendering option buttons
            const isDeleted = data.deleted_at !== null;
            $(".option-btn.restore").toggle(isDeleted);
            $(".option-btn:not(.restore):not(.toggle-options)").toggle(!isDeleted);

            populateImagesModal(data, reset);
        }

        function populateImagesModal(data, reset = false) {
            const id = data?.cutout_id || null;
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
                    const imageName = `${data.name}_${data.cutout_id}_${image.image_id}`;
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
                        $("#edit-cutout-modal .img-preview-container").html(`<img src="${image.image_url}" alt="${imageName}" title="${imageName}">`);
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
            const modal = $("#create-cutout-modal");
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
            modal.find('input[name="code"]').val("");
            modal.find('input[name="width"]').val("");
            modal.find('input[name="height"]').val("");
            modal.find('input[name="depth"]').val("");
            modal.find('input[name="material"]').val("");
            modal.find('input[name="color"]').val("");
            modal.find('input[name="weight"]').val("");
            modal.find('input[name="base_price"]').val("");
            modal.find('input[name="stock_quantity"]').val("");
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
                    errMsg = "Please provide your cutout with a name.";
                } else if (!data.cutout_type.length) {
                    errMsg = "Please provide your cutout with a type.";
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

        $(".option-btn.toggle-options").on("click", function() {
            $(this).toggleClass('active');
        });

        $(".create-btn").on("click", () => {
            $("#create-cutout-modal").addClass("showing");
            if (STATE.activeId !== null) {
                resetImagesModal();
                $("#create-cutout-modal").find(".img-preview-container").html("");
            }
        });

        $(".images-modal button.cancel").on('click', function(e) {
            e.preventDefault();
            $(this).closest('.modal').find('.modal-close').trigger('click');
            let data = {};
            if ($("#edit-cutout-modal").hasClass("showing")) {
                const cutoutId = $("#edit-cutout-id").text();
                data = STATE.cutouts.find(x => x.one_of_a_kind_id === Number(cutoutId));
            } else if ($("#create-cutout-modal").hasClass("showing")) {
                $("#create-cutout-modal .img-preview-container").html("");
            }
            setTimeout(() => populateImagesModal(data, true), 400);
        });

        $(".images-modal button.confirm").off('click').on('click', function(e) {
            e.preventDefault();
            if ($("#create-cutout-modal").hasClass("showing")) {
                return $(this).closest('.modal').find(".modal-close").trigger("click");
            };

            const cutoutId = $("#edit-cutout-id").text();
            const name = $("#edit-cutout-form [name='name']").val();

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
                url: `/cutouts/${cutoutId}/images`,
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

        $('button[form="edit-cutout-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#edit-cutout-form");
            const data = getJSONDataFromForm(form);
            const cutoutId = $("#edit-cutout-id").text();
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
                html: `Updating cutout, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/cutouts/${cutoutId}`,
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
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $('button[form="create-cutout-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#create-cutout-form");
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
                html: `Creating cutout, <strong>"${data.name}"</strong>.`,
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
                url: "/cutouts",
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

        $("#edit-cutout-modal .modal-close").on("click", function() {
            $(this)
                .closest('.modal')
                .find('.option-btn.toggle-options')
                .removeClass('active');
        });

        $("#edit-cutout-modal button.cancel").on("click", function() {
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

            if ($("#create-cutout-modal").hasClass("showing")) {
                resetModal($("#create-cutout-modal"));
            } else {
                populateEditForm(STATE.activeId, true);
            }

        });

        $(".option-btn.delete").on("click", async function() {
            const cutoutId = $("#edit-cutout-id").text();
            const name = $("#edit-cutout-form [name='name']").val();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${name}"`,
                text: "Are you sure that you would like to delete this cutout?",
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
                html: `Deleting cutout, <strong>"${name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/cutouts/${cutoutId}`,
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
            const id = $("#edit-cutout-id").text();
            const name = $("#edit-cutout-form [name='name']").val();

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
                url: `/cutouts/${id}/restore`,
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
            if ($("#create-cutout-modal").hasClass("showing")) {
                handleSetPreviewImage();
            }
        });
    });
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>