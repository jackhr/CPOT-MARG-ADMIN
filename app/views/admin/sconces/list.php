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
                    <th>Name</th>
                    <th>Dimensions</th>
                    <th>Material</th>
                    <th>Color</th>
                    <th>Weight</th>
                    <th>Base Price</th>
                    <th>Stock Quantity</th>
                    <th>Status</th>
                    <th>Installation Type</th>
                    <th>Style</th>
                    <th>Image Url</th>
                    <th>Description</th>
                    <th>Availability</th>
                    <th>Care Instructions</th>
                    <th>Release Date</th>
                    <th>Custom Options</th>
                    <th>Created</th>
                    <th>Last updated</th>
                    <th>Deleted At</th>
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
                        <td><?php echo $s['name']; ?></td>
                        <td><?php echo $s['dimensions']; ?></td>
                        <td><?php echo $s['material']; ?></td>
                        <td><?php echo $s['color']; ?></td>
                        <td><?php echo $s['weight']; ?></td>
                        <td><?php echo $s['base_price']; ?></td>
                        <td><?php echo $s['stock_quantity']; ?></td>
                        <td><?php echo $s['status']; ?></td>
                        <td><?php echo $s['installation_type']; ?></td>
                        <td><?php echo $s['style']; ?></td>
                        <td><?php echo $s['image_url']; ?></td>
                        <td><?php echo $s['description']; ?></td>
                        <td><?php echo $s['availability']; ?></td>
                        <td><?php echo $s['care_instructions']; ?></td>
                        <td><?php echo $s['release_date']; ?></td>
                        <td><?php echo $s['custom_options']; ?></td>
                        <td class="dt-type-date"><?php echo $created_at; ?></td>
                        <td class="dt-type-date"><?php echo $updated_at; ?></td>
                        <?php if ($user['role_id'] === 1) { ?>
                            <td class="dt-type-date"><?php echo $deleted_at; ?></td>
                        <?php } ?>
                        <td><?php echo $s['created_by']; ?></td>
                        <td><?php echo $s['updated_by']; ?></td>
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
                        <input type="file" name="sconce-img" id="sconce-img-input" style="display: none;">
                        <div id="sconce-preview-container"></div>
                        <div id="sconce-img-options">
                            <label for="sconce-img-input" class="continue-btn">Add Image</label>
                            <label for="sconce-img-input" class="continue-btn other">Change Image</label>
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
                <button form="create-sconce-form" type="submit" class="continue-btn disabled">Submit</button>
            </div>
            <div id="sconce-drop-alert">Drop Image To Add</div>
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
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Current sconce" required>
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
        new DataTable("#sconces-table", {
            ...STATE.dtDefaultOpts,
        });

        $(".create-btn").on("click", () => $("#create-sconce-modal").addClass("showing"));

        $("#create-sconce-modal input, #create-sconce-modal textarea").on('input', () => {
            const formIsValid = checkFormIsValid($("#create-sconce-form"));
            $('button[form="create-sconce-form"]').toggleClass("disabled", !formIsValid);
        });

        $('button[form="edit-sconce-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#edit-sconce-form");
            const data = form.serializeObject();
            data.sconce_id = $("#edit-sconce-id").text();

            if (!data.name.length || !form.find('input[name="name"]')[0].checkValidity()) {
                return form.find('input[name="name"]')[0].reportValidity();
            }

            $.ajax({
                url: `/sconces/${data.sconce_id}`,
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

        $('button[form="create-sconce-form"]').on("click", function(e) {
            e.preventDefault();

            const form = $("#create-sconce-form");
            const data = getJSONDataFromForm(form);

            if (checkFormIsValid(form)) {
                $(this).removeClass("disabled");
            } else {
                return $(this).addClass("disabled");
            }

            const formData = new FormData(form[0]);
            formData.set("sconce-img", STATE.imageToUpload)

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

        $("#sconces-table tbody tr").on("click", function() {
            const modal = $("#edit-sconce-modal");
            const sconceId = $(this).find('td').eq(0).text();
            const sconceName = $(this).find('td').eq(1).text();

            modal.find('#edit-sconce-id').text(sconceId);
            modal.find('input[name="name"]').val(sconceName);

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
        const data = form.serializeObject();
        data["sconce-img"] = STATE.imageToUpload;
        return data;
    }

    $("#sconce-img-options .continue-btn.danger").on("click", async function() {
        const choice = await Swal.fire({
            icon: "warning",
            title: "Removing Image",
            text: "Are you sure you'd like to remove this image?",
            confirmButtonText: "Yes, Remove It",
            showCancelButton: true
        });

        if (!choice.isConfirmed) return;

        STATE.imageToUpload = undefined;
        $("#sconce-preview-container").html("");
        const formIsValid = checkFormIsValid($("#create-sconce-form"));
        $('button[form="create-sconce-form"]').toggleClass("disabled", !formIsValid);
    });

    $("#sconce-img-input").on('change', function() {
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
            $("#sconce-preview-container").html(`
                <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
            `);

        });
        $(this).val('');
        const formIsValid = checkFormIsValid($("#create-sconce-form"));
        $('button[form="create-sconce-form"]').toggleClass("disabled", !formIsValid);
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
                    $("#sconce-preview-container").html(`
                        <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
                    `);
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
                $("#sconce-preview-container").html(`
                    <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
                `);
            });
        }

        $("#sconce-drop-alert").removeClass('showing');
    }).on('dragover', function(evt) {
        evt.preventDefault();

        $("#sconce-drop-alert").addClass('showing');
    });

    function validateForm(data, type = "create") {
        if (type === "create") {

        } else {

        }
    }

    function checkFormIsValid(form, data = null) {
        data = data ? data : getJSONDataFromForm(form);
        let valid = true;
        for (const key in data) {
            if (Object.prototype.hasOwnProperty.call(data, key)) {
                if (!data[key]?.length && !(data[key] instanceof File)) {
                    valid = false;
                    break;
                }
            }
        }
        return valid;
    }
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>