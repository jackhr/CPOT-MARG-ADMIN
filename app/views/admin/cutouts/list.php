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
            <span>Create Cutout</span>
        </button>
        <table>
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Image</th>
                    <th>Name</th>
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
                    <div class="input-container cutout-img-container">
                        <input type="file" name="cutout-img" class="cutout-img-input" id="create-cutout-img-input" style="display: none;">
                        <div class="cutout-preview-container"></div>
                        <div class="cutout-img-options">
                            <label for="create-cutout-img-input" class="continue-btn">Add Image</label>
                            <label for="create-cutout-img-input" class="continue-btn other">Change Image</label>
                            <label class="continue-btn danger">Remove Image</label>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="New Cutout" required>
                        </div>
                        <div class="input-container">
                            <label for="cutout_type">Cutout Type</label>
                            <input type="text" name="cutout_type" placeholder="Nature" required>
                        </div>
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
            <div id="drop-alert">Drop Image To Add</div>
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
                    </div>
                    <hr style="border: solid 0.5px #d3d3d3;margin: 24px 0;">
                    <div class="input-container cutout-img-container">
                        <input type="file" name="cutout-img" class="cutout-img-input" id="edit-cutout-img-input" style="display: none;">
                        <div class="cutout-preview-container"></div>
                        <div class="cutout-img-options">
                            <label for="edit-cutout-img-input" class="continue-btn other">Change Image</label>
                        </div>
                    </div>
                    <div class="mutiple-input-container">
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="New Cutout" required>
                        </div>
                        <div class="input-container">
                            <label for="cutout_type">Cutout Type</label>
                            <input type="text" name="cutout_type" placeholder="Nature" required>
                        </div>
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
            <div class="modal-footer" style="margin-top: 18px;">
                <button class="continue-btn danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const dTable = new DataTable("table", {
            ...STATE.dtDefaultOpts,
            ajax: {
                url: "/cutouts/getAll",
                dataSrc: function(response) {
                    let res = [];
                    console.log("response:", response);
                    if (response && response.data) {
                        STATE.oneOfAKinds = structuredClone(Object.values(response.data));
                        res = Object.values(response.data).map(cutout => {
                            cutout.price = formatPrice(cutout.price);
                            cutout.description = cutout.description ? cutout.description : "-";
                            cutout.deleted_at = cutout.deleted_at ? cutout.deleted_at : "-";
                            cutout.updated_by_email = cutout.updated_by_email ? cutout.updated_by_email : "-";
                            return cutout;
                        });
                    } else {
                        console.error("Invalid response format", response);
                    }

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
        });

        setTimeout(() => dTable.draw(), 1000);

        $(".create-btn").on("click", () => $("#create-cutout-modal").addClass("showing"));

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

            const formData = new FormData(form[0]);
            if (STATE.imageToUpload) {
                formData.set("cutout-img", STATE.imageToUpload);
            } else {
                formData.delete("cutout-img");
            }

            $.ajax({
                url: `/cutouts/${cutoutId}`,
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
            if (STATE.imageToUpload) {
                formData.set("cutout-img", STATE.imageToUpload);
            } else {
                formData.delete("cutout-img");
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
                    }).then(() => {
                        success && location.reload();
                    });
                },
                error: function() {
                    console.log("arguments:", arguments);
                }
            });
        });

        $("table").on("click", "tbody tr", function() {
            const modal = $("#edit-cutout-modal");
            const cutoutId = $(this).find('td').eq(0).text();
            const imgSrc = $(this).find('td').eq(1).find('img').attr('src');
            const name = $(this).find('td').eq(2).text();
            const description = $(this).find('td').eq(3).text();
            const cutoutType = $(this).find('td').eq(4).text();

            delete STATE.imageToUpload;

            modal.find('#edit-cutout-id').text(cutoutId);
            modal.find('input[name="name"]').val(name);
            modal.find('.cutout-preview-container').html(`
                <img title="${name}" src="${imgSrc}" alt="${name}">
            `);
            modal.find('input[name="cutout_type"]').val(cutoutType);
            modal.find('textarea[name="description"]').val(description);

            modal.addClass("showing");
        });

        $("#edit-cutout-modal button.cancel").on("click", function() {
            $(this).closest('.modal').removeClass('showing');
        });

        $("#edit-cutout-modal button.danger").on("click", async function() {
            const form = $("#edit-cutout-form");
            const data = form.serializeObject();
            data.cutout_id = $("#edit-cutout-id").text();

            const res = await Swal.fire({
                icon: "warning",
                title: `Deleting "${data.name}"`,
                text: "Are you sure that you would like to delete this cutout?",
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No'
            });

            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Loading...",
                html: `Deleting cutout, <strong>"${data.name}"</strong>.`,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/cutouts/${data.cutout_id}`,
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

    $(".cutout-img-options .continue-btn.danger").on("click", async function() {
        const choice = await Swal.fire({
            icon: "warning",
            title: "Removing Image",
            text: "Are you sure you'd like to remove this image?",
            confirmButtonText: "Yes, Remove It",
            showCancelButton: true
        });

        if (!choice.isConfirmed) return;

        delete STATE.imageToUpload;
        $(this).closest('.cutout-img-container').find(".cutout-preview-container").html("");
    });

    $(".cutout-img-input").on('change', function() {
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
            $(this).siblings(".cutout-preview-container").html(`
                <img title="${file.name}" src="${imgSrc}" alt="${file.name}">
            `);
            $(this).closest('form').find('input[name="name"]').val(newFileName);
        });
        $(this).val('');
    });

    $("#create-cutout-modal").on('drop', async function(evt) {
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
                    $(this).find(".cutout-preview-container").html(`
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
                $(this).find(".cutout-preview-container").html(`
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
            console.log("data:", data);
            if (!STATE.imageToUpload && type === "create") {
                errMsg = "You need to upload an image";
            } else if (!data.name.length) {
                errMsg = "Please provide your cutout with a name.";
            } else if (!data.cutout_type.length) {
                errMsg = "Please provide your cutout with a type.";
            }
        }

        return errMsg || null;
    }
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>