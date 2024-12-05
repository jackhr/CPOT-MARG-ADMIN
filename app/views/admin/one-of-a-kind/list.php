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
                        <div class="one-of-a-kind-preview-container">
                            <div class="carousel"></div>
                        </div>
                        <div class="one-of-a-kind-img-options">
                            <label for="create-one-of-a-kind-img-input" class="continue-btn">Add Images</label>
                        </div>
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
                    </div>
                    <hr style="border: solid 0.5px #d3d3d3;margin: 24px 0;">
                    <div class="input-container one-of-a-kind-img-container">
                        <input multiple type="file" name="one-of-a-kind-imgs" class="one-of-a-kind-img-input" id="edit-one-of-a-kind-img-input" style="display: none;">
                        <div class="one-of-a-kind-preview-container"></div>
                        <div class="one-of-a-kind-img-options">
                            <label for="edit-one-of-a-kind-img-input" class="continue-btn other">Change Image</label>
                        </div>
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
            <div class="modal-footer" style="margin-top: 18px;">
                <button class="continue-btn danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        (function initSTATE() {
            STATE.upload = {
                maxImageCount: 10,
                currentIdx: 0,
                imageCount: 0,
                images: {},
            };
            STATE.activeId = null;
        })();
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

        function handleInitTableRowEvents() {
            dTable.rows().every(function(idx) {
                const rowNode = this.node();
                if (!rowNode) {
                    console.warn(`Row node not found for index ${idx}`);
                    return;
                }

                const id = this.data().one_of_a_kind_id;
                const data = STATE.oneOfAKinds.find(x => x.one_of_a_kind_id === id);
                $(rowNode)
                    .find('td')
                    .eq(1)
                    .addClass("one-of-a-kind-thumb-td")
                    .html(`
                        <div>
                            <img src="${data.image_url}" alt="${data.name}">
                        </div>
                    `);
                const dimensions = data.dimensions
                    .split(" x ")
                    .map(x => x.replace(/in|cm/gi, ""));

                rowNode.onclick = () => {
                    const modal = $("#edit-one-of-a-kind-modal");

                    modal.find('#edit-one-of-a-kind-id').text(data.one_of_a_kind_id);
                    modal.find('input[name="name"]').val(data.name);
                    modal.find('input[name="width"]').val(dimensions[0]);
                    modal.find('input[name="height"]').val(dimensions[1]);
                    modal.find('input[name="depth"]').val(dimensions[2]);
                    modal.find('input[name="material"]').val(data.material);
                    modal.find('input[name="color"]').val(data.color);
                    modal.find('input[name="weight"]').val(data.weight);
                    modal.find('input[name="base_price"]').val(data.price);
                    modal.find('input[name="stock_quantity"]').val(data.stock_quantity);
                    modal.find('textarea[name="description"]').val(data.description);

                    modal.addClass('showing');
                };
            });

        }

        setTimeout(() => dTable.draw(), 1000);

        $(".create-btn").on("click", () => $("#create-one-of-a-kind-modal").addClass("showing"));

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

            const formData = new FormData(form[0]);
            if (STATE.imageToUpload) {
                formData.set("one-of-a-kind-img", STATE.imageToUpload);
            } else {
                formData.delete("one-of-a-kind-img");
            }

            $.ajax({
                url: `/one-of-a-kind/${oneOfAKindId}`,
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
            if (STATE.upload.imageCount) {
                for (const idx in STATE.upload.images) {
                    const file = STATE.upload.images[idx];
                    formData.append(`one-of-a-kind-imgs[${idx}]`, file);
                    if ($(`.carousel-cell[data-idx="${idx}"] .make-primary-button`).hasClass("is-primary")) {
                        formData.append('primary_image_idx', idx);
                    }
                }
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

        $("#edit-one-of-a-kind-modal button.cancel").on("click", function() {
            $(this).closest('.modal').removeClass('showing');
        });

        $("#edit-one-of-a-kind-modal button.danger").on("click", async function() {
            const form = $("#edit-one-of-a-kind-form");
            const data = form.serializeObject();
            data.one_of_a_kind_id = $("#edit-one-of-a-kind-id").text();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${data.name}"`,
                text: "Are you sure that you would like to delete this one of a kind?",
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No'
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
    });

    function getJSONDataFromForm(form) {
        return form.serializeObject();
    }

    function initPageDots() {
        const selectedIdx = $(".carousel-cell:has(.is-primary)").index();
        const dots = $(".flickity-page-dots .dot");
        if (selectedIdx === -1) {
            return $(".carousel-cell:first-child .make-primary-button").trigger('click');
        }

        dots.removeClass("is-primary");
        dots.eq(selectedIdx).addClass("is-primary");
    }

    $(".one-of-a-kind-img-options .continue-btn.danger").on("click", async function() {
        const choice = await Swal.fire({
            icon: "warning",
            title: "Removing Image",
            text: "Are you sure you'd like to remove this image?",
            confirmButtonText: "Yes, Remove It",
            showCancelButton: true
        });

        if (!choice.isConfirmed) return;

        delete STATE.imageToUpload;
        $(this).closest('.one-of-a-kind-img-container').find(".one-of-a-kind-preview-container").html("");
    });

    $(".carousel").on("click", ".flickity-prev-next-button", function(e) {
        initPageDots();
    });

    $(".carousel").on("click", ".make-primary-button", function(e) {
        e.preventDefault();
        if ($(this).hasClass('is-primary')) return;

        $(".make-primary-button").removeClass('is-primary');
        $(this).addClass('is-primary');
        initPageDots();
    });

    $(".carousel").on("click", ".remove-image-btn", function(e) {
        const cell = $(this).closest('.carousel-cell');
        const idx = cell.data('idx');

        setTimeout(() => {
            /**
             * Need this function to be asynchronous since it removes
             * the cell before the click event is called which triggers
             * a click event on the document while the the target is
             * removed from the dom. Basically it marks this condition as
             * true: !target.closest(".modal-dialog").length in main.js
             */
            STATE.upload.carousel.flickity('remove', cell);
            STATE.upload.imageCount--;
            delete STATE.upload.images[idx];
            initPageDots();
        }, 100);
    });

    $(".one-of-a-kind-img-input").on('change', function() {
        const incorrectFiles = [];
        let hitMaxCount = false;
        let carouselContainer = $(this).closest('form').find('.carousel'); // Target carousel container

        [...this.files].forEach(file => {
            if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
                return incorrectFiles.push(file);
            } else if (STATE.upload.imageCount === STATE.upload.maxImageCount) {
                return hitMaxCount = true;
            }

            const idx = STATE.upload.currentIdx++;
            const imagesCount = ++STATE.upload.imageCount;
            const imgSrc = URL.createObjectURL(file);
            STATE.upload.images[idx] = file;
            carouselContainer.append(`
                <div class="carousel-cell" data-idx="${idx}">
                    <button class="continue-btn make-primary-button ${imagesCount === 1 ? "is-primary" : ""}"></button>
                    <div class="remove-image-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </div>
                    <img src="${imgSrc}" alt="${file.name}" title="${file.name}">
                </div>
            `);
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

        // Reinitialize Flickity
        if (carouselContainer.children().length) {
            if (carouselContainer.data('flickity')) {
                carouselContainer.flickity('destroy'); // Destroy existing Flickity instance
            }
            STATE.upload.carousel = carouselContainer.flickity({
                cellAlign: 'left',
                contain: true,
                wrapAround: true,
                autoPlay: false, // Add your preferences
                arrowShape: "M 57.5,75 L 32.5,50 L 57.5,25",
            });

            initPageDots();
        }
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

    function getFormValidationMsg(data, type = "create") {
        let errMsg = "";

        if (type === "create" || type === "edit") {
            if (!STATE.upload.imageCount && type === "create") {
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
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>