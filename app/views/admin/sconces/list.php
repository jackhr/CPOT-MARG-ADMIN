<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<main>
    <div class="table-wrapper">
        <button class="create-btn continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" x2="19" y1="8" y2="14" />
                <line x1="22" x2="16" y1="11" y2="11" />
            </svg>
            <span>Create Sconce</span>
        </button>
        <table id="sconces-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Name</th>
                    <th>Slug</th>
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
                <?php foreach ($sconces as $s) { ?>
                    <tr data-id="<?php echo $s['sconce_id']; ?>">
                        <td><?php echo $s['sconce_id']; ?></td>
                        <td><?php echo $s['name']; ?></td>
                        <td><?php echo $s['slug']; ?></td>
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
                        <td><?php echo $s['created_at']; ?></td>
                        <td><?php echo $s['updated_at']; ?></td>
                        <td><?php echo $s['deleted_at']; ?></td>
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
                    <div class="input-container">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="New Sconce" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-sconce-form" type="submit" class="continue-btn disabled">Submit</button>
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
        new DataTable("#sconces-table");
    })

    $(".create-btn").on("click", () => $("#create-sconce-modal").addClass("showing"));

    $("#create-sconce-modal input").on('input', () => checkFormIsValid());

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
        const data = form.serializeObject();

        if (!data.name.length || !form.find('input[name="name"]')[0].checkValidity()) {
            return form.find('input[name="name"]')[0].reportValidity();
        }

        if (!checkFormIsValid()) return;

        $.ajax({
            url: "/sconces",
            method: "POST",
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

    function checkFormIsValid() {
        const data = $("#create-sconce-form").serializeObject();
        let disableTheBtn = false;
        for (const key in data) {
            if (Object.prototype.hasOwnProperty.call(data, key)) {
                // check to see if any value has been at all for inputs
                if (!data[key].length) disableTheBtn = true;
            }
        }

        $('button[form="create-sconce-form"]').toggleClass('disabled', disableTheBtn);

        return !disableTheBtn;
    }

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
</script>

<?php include_once __DIR__ . "/../../partials/footer.php"; ?>