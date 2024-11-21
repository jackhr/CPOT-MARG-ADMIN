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
            <span>Create Sconce</span>
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
            <tbody>
                <?php foreach ($sconces as $s) {
                    $created_at = new DateTime($s['created_at']);
                    $updated_at = new DateTime($s['updated_at']);
                    $created_at = $created_at->format('M j, Y \@ g:i A T');
                    $updated_at = $updated_at->format('M j, Y \@ g:i A T');

                    if ($user['role_id'] === 1) {
                        $deleted_at = "-";
                        if (isset($s['deleted_at'])) {
                            $deleted_at = new DateTime($s['deleted_at']);
                            $deleted_at = $deleted_at->format('M j, Y \@ g:i A T');
                        }
                    }
                ?>
                    <tr data-id="<?php echo $s['sconce_id']; ?>">
                        <td><?php echo $s['sconce_id']; ?></td>
                        <td class="sconce-thumb-td">
                            <div>
                                <img src="<?php echo $s['image_url']; ?>" alt="<?php echo $s['name']; ?>">
                            </div>
                        </td>
                        <td><?php echo $s['name']; ?></td>
                        <td><?php echo $s['dimensions']; ?></td>
                        <td><?php echo $s['material']; ?></td>
                        <td><?php echo $s['color']; ?></td>
                        <td><?php echo $s['weight']; ?></td>
                        <td><?php echo $s['base_price']; ?></td>
                        <td><?php echo $s['stock_quantity']; ?></td>
                        <td><?php echo $s['status']; ?></td>
                        <td><?php echo $s['description']; ?></td>
                        <td><?php echo $s['availability']; ?></td>
                        <td class="dt-type-date"><?php echo $created_at; ?></td>
                        <td class="dt-type-date"><?php echo $updated_at; ?></td>
                        <?php if ($user['role_id'] === 1) { ?>
                            <td class="dt-type-date"><?php echo $deleted_at; ?></td>
                        <?php } ?>
                        <td><?php echo $s['created_by_email']; ?></td>
                        <td><?php echo $s['updated_by_email']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
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
                    <div class="input-container sconce-img-container">
                        <input type="file" name="sconce-img" class="sconce-img-input" id="create-sconce-img-input" style="display: none;">
                        <div class="sconce-preview-container"></div>
                        <div class="sconce-img-options">
                            <label for="create-sconce-img-input" class="continue-btn">Add Image</label>
                            <label for="create-sconce-img-input" class="continue-btn other">Change Image</label>
                            <label class="continue-btn danger">Remove Image</label>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New Sconce" required>
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
                            <label for="breadth">Breadth</label>
                            <input type="text" name="breadth" placeholder="6" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="dimension-units">Units</label>
                        <select name="dimension-units" id="dimension-units">
                            <option value="cm">cm</option>
                            <option value="mm">mm</option>
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
                            <label for="weight-units">Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                                <option value="ozs">ozs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="number" name="base_price" placeholder="75" required>
                        </div>
                        <div class="input-container">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" name="stock_quantity" placeholder="100" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-sconce-form" type="submit" class="continue-btn">Submit</button>
            </div>
            <div id="drop-alert">Drop Image To Add</div>
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
                    </div>
                    <hr style="border: solid 0.5px #d3d3d3;margin: 24px 0;">
                    <div class="input-container sconce-img-container">
                        <input type="file" name="sconce-img" class="sconce-img-input" id="edit-sconce-img-input" style="display: none;">
                        <div class="sconce-preview-container"></div>
                        <div class="sconce-img-options">
                            <label for="edit-sconce-img-input" class="continue-btn other">Change Image</label>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New Sconce" required>
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
                            <label for="breadth">Breadth</label>
                            <input type="text" name="breadth" placeholder="6" required>
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="dimension-units">Units</label>
                        <select name="dimension-units" id="dimension-units">
                            <option value="cm">cm</option>
                            <option value="mm">mm</option>
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
                            <label for="weight-units">Units</label>
                            <select name="weight-units" id="weight-units">
                                <option selected value="lbs">lbs</option>
                                <option value="kgs">kgs</option>
                                <option value="ozs">ozs</option>
                            </select>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="price">Price</label>
                            <input type="number" name="base_price" placeholder="75" required>
                        </div>
                        <div class="input-container">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" name="stock_quantity" placeholder="100" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button form="edit-sconce-form" type="submit" class="continue-btn">Update</button>
            </div>
            <div class="modal-footer" style="margin-top: 18px;">
                <button class="continue-btn danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const dTable = new DataTable("#sconces-table", {
            ...STATE.dtDefaultOpts,
        });

        setTimeout(() => dTable.draw(), 1000);

        $(".create-btn").on("click", () => $("#create-sconce-modal").addClass("showing"));

        $('button[form="edit-sconce-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#edit-sconce-form");
            const data = getJSONDataFromForm(form);
            const sconceId = $("#edit-sconce-id").text();
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
                html: `Editing sconce, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form[0]);
            if (STATE.imageToUpload) {
                formData.set("sconce-img", STATE.imageToUpload);
            } else {
                formData.delete("sconce-img");
            }

            $.ajax({
                url: `/sconces/${sconceId}`,
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

        $('button[form="create-sconce-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#create-sconce-form");
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
                html: `Creating sconce, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form[0]);
            if (STATE.imageToUpload) {
                formData.set("sconce-img", STATE.imageToUpload);
            } else {
                formData.delete("sconce-img");
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $("#sconces-table").on("click", "tbody tr", function() {
            const modal = $("#edit-sconce-modal");
            const sconceId = $(this).find('td').eq(0).text();
            const imgSrc = $(this).find('td').eq(1).find('img').attr('src');
            const name = $(this).find('td').eq(2).text();
            const dimensions = $(this).find('td').eq(3).text()
                .split(" x ").map(x => {
                    let res = x.replace("mm", "");
                    res = x.replace("in", "");
                    res = x.replace("cm", "");
                    return res;
                });
            const material = $(this).find('td').eq(4).text();
            const color = $(this).find('td').eq(5).text();
            const weight = $(this).find('td').eq(6).text()
                .replace("lbs", "")
                .replace("kgs", "")
                .replace("ozs", "");
            const base_price = $(this).find('td').eq(7).text();
            const stock_quantity = $(this).find('td').eq(8).text();
            const description = $(this).find('td').eq(10).text();

            delete STATE.imageToUpload;

            modal.find('#edit-sconce-id').text(sconceId);
            modal.find('input[name="name"]').val(name);
            modal.find('.sconce-preview-container').html(`
                <img title="${name}" src="${imgSrc}" alt="${name}">
            `);
            modal.find('input[name="width"]').val(dimensions[0]);
            modal.find('input[name="height"]').val(dimensions[1]);
            modal.find('input[name="breadth"]').val(dimensions[2]);
            modal.find('input[name="material"]').val(material);
            modal.find('input[name="color"]').val(color);
            modal.find('input[name="weight"]').val(weight);
            modal.find('input[name="base_price"]').val(base_price);
            modal.find('input[name="stock_quantity"]').val(stock_quantity);
            modal.find('textarea[name="description"]').val(description);

            modal.addClass("showing");
        });

        $("#edit-sconce-modal button.cancel").on("click", function() {
            $(this).closest('.modal').removeClass('showing');
        });

        $("#edit-sconce-modal button.danger").on("click", async function() {
            const form = $("#edit-sconce-form");
            const data = form.serializeObject();
            data.sconce_id = $("#edit-sconce-id").text();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${data.name}"`,
                text: "Are you sure that you would like to delete this sconce?",
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No'
            });

            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Loading...",
                html: `Deleting sconce, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/sconces/${data.sconce_id}`,
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

    $(".sconce-img-options .continue-btn.danger").on("click", async function() {
        const choice = await Swal.fire({
            icon: "warning",
            title: "Removing Image",
            text: "Are you sure you'd like to remove this image?",
            confirmButtonText: "Yes, Remove It",
            showCancelButton: true
        });

        if (!choice.isConfirmed) return;

        delete STATE.imageToUpload;
        $(this).closest('.sconce-img-container').find(".sconce-preview-container").html("");
    });

    $(".sconce-img-input").on('change', function() {
        [...this.files].forEach(file => {
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
            $(this).siblings(".sconce-preview-container").html(`
                <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
            `);
            $(this).closest('form').find('input[name="name"]').val(newFileName);
        });
        $(this).val('');
    });

    $("#create-sconce-modal").on('drop', async function(evt) {
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
                    $(this).find(".sconce-preview-container").html(`
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
                $(this).find(".sconce-preview-container").html(`
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

    function validateForm(data, type = "create") {
        if (type === "create") {

        } else {

        }
    }

    function getFormValidationMsg(data, type = "create") {
        let errMsg = "";

        if (type === "create" || type === "edit") {
            if (!STATE.imageToUpload && type === "create") {
                errMsg = "You need to upload an image";
            } else if (!data.name.length) {
                errMsg = "Please provide your ceramic with a name.";
            } else if (!data.width.length) {
                errMsg = "Please provide your ceramic with a width.";
            } else if (!data.width.match(STATE.regEx.decimal)) {
                errMsg = `Width can only be a number. You entered: "${data.width}"`;
            } else if (!data.height.length) {
                errMsg = "Please provide your ceramic with a height.";
            } else if (!data.height.match(STATE.regEx.decimal)) {
                errMsg = `Height can only be a number. You entered: "${data.height}"`;
            } else if (!data.breadth.length) {
                errMsg = "Please provide your ceramic with a breadth.";
            } else if (!data.breadth.match(STATE.regEx.decimal)) {
                errMsg = `Breadth can only be a number. You entered: "${data.breadth}"`;
            } else if (!data.material.length) {
                errMsg = "Please provide your ceramic with a material.";
            } else if (!data.color.length) {
                errMsg = "Please provide your ceramic with a color.";
            } else if (!data.weight.length) {
                errMsg = "Please provide your ceramic with a weight.";
            } else if (!data.weight.match(STATE.regEx.decimal)) {
                errMsg = `Weight can only be a number. You entered: "${data.weight}"`;
            } else if (!data.base_price.length) {
                errMsg = "Please provide your ceramic with a price.";
            } else if (!data.base_price.match(STATE.regEx.decimal)) {
                errMsg = `Price can only be a number. You entered: "${data.base_price}"`;
            } else if (!data.stock_quantity.length) {
                errMsg = "Please provide your ceramic with a stock quantity.";
            } else if (!data.stock_quantity.match(STATE.regEx.decimal)) {
                errMsg = `Stock quantity can only be a number. You entered: "${data.stock_quantity}"`;
            } else if (!data.name.length) {
                errMsg = "Please provide your ceramic with a name.";
            }
        }

        return errMsg || null;
    }
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>