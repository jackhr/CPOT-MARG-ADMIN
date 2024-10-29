<?php include_once __DIR__ . "/../../partials/header.php"; ?>
<?php include_once __DIR__ . "/../../partials/navbar.php"; ?>

<div id="users-main">
    <div id="users-table-wrapper">
        <button id="create-user-btn" class="continue-btn open-modal-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" x2="19" y1="8" y2="14" />
                <line x1="22" x2="16" y1="11" y2="11" />
            </svg>
            <span>Create User</span>
        </button>
        <table id="users-table">
            <thead>
                <tr>
                    <th>Id #</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u) { ?>
                    <tr data-id="<?php echo $u['user_id']; ?>">
                        <td><?php echo $u['user_id']; ?></td>
                        <td><?php echo $u['username']; ?></td>
                        <td><?php echo $u['email']; ?></td>
                        <td><?php echo $u['created_at']; ?></td>
                        <td><?php echo $u['updated_at']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="create-user-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Adding User</h1>
            </div>
            <div class="modal-body">
                <form id="create-user-form">
                    <div class="input-container">
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="NewUser1" pattern="\w{5,}" required>
                    </div>
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="new_user@gmail.com" required>
                    </div>
                    <div class="input-container password-container">
                        <label for="new-password">New Password</label>
                        <input type="password" name="new-password" required>
                        <div class="password-eye-container">
                            <svg class="show-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="hide-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                <path d="m2 2 20 20" />
                            </svg>
                        </div>
                    </div>
                    <div class="input-container password-container">
                        <label for="confirm-new-password">Confirm New Password</label>
                        <input type="password" name="confirm-new-password" required>
                        <div class="password-eye-container">
                            <svg class="show-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="hide-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                <path d="m2 2 20 20" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="create-user-form" type="submit" class="continue-btn disabled">Submit</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-user-modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-options">
                    <span class="modal-close">×</span>
                </div>
                <h1>Editing User</h1>
            </div>
            <div class="modal-body">
                <form id="edit-user-form">
                    <div class="input-container">
                        <label>Id #</label>
                        <span id="edit-user-id"></span>
                    </div>
                    <hr style="border: solid 0.5px #d3d3d3;margin: 24px 0;">
                    <div class="input-container">
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="CurrentUser" pattern="\w{5,}" required>
                    </div>
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="current_user@gmail.com" required>
                    </div>
                    <!-- <div class="input-container password-container">
                        <label for="new-password">New Password</label>
                        <input type="password" name="new-password" required>
                        <div class="password-eye-container">
                            <svg class="show-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="hide-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                <path d="m2 2 20 20" />
                            </svg>
                        </div>
                    </div>
                    <div class="input-container password-container">
                        <label for="confirm-new-password">Confirm New Password</label>
                        <input type="password" name="confirm-new-password" required>
                        <div class="password-eye-container">
                            <svg class="show-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="hide-pass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                <path d="m2 2 20 20" />
                            </svg>
                        </div>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button class="continue-btn cancel">Cancel</button>
                <button form="edit-user-form" type="submit" class="continue-btn">Update</button>
            </div>
            <div class="modal-footer" style="margin-top: 18px;">
                <button class="continue-btn danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#create-user-btn").on("click", () => $("#create-user-modal").addClass("showing"))

    $(".password-container input").on("input", function() {
        const {
            "new-password": newPass,
            "confirm-new-password": confirmNewPass,
        } = $("#create-user-form").serializeObject();

        if (!newPass.length || !confirmNewPass.length) {
            // no need to validate if no value
            $(".password-container input").removeClass("error success");
            return;
        }

        const differentPasswords = newPass !== confirmNewPass;
        const passwordIsTooShort = newPass.length < 5;
        const toggleSuccess = !differentPasswords && !passwordIsTooShort;

        $(".password-container input")
            .toggleClass("error", (differentPasswords || passwordIsTooShort))
            .toggleClass("success", toggleSuccess);
    });

    $("#create-user-modal input").on('input', () => checkFormIsValid());

    $('button[form="edit-user-form"]').on("click", function(e) {
        e.preventDefault();

        const form = $("#edit-user-form");
        const data = form.serializeObject();
        data.user_id = $("#edit-user-id").text();

        if (!data.username.length || !form.find('input[name="username"]')[0].checkValidity()) {
            return form.find('input[name="username"]')[0].reportValidity(),
                Swal.fire({
                    icon: "error",
                    title: "Username is Too Short",
                    text: "A username must be at least 5 characters"
                });
        }

        if (!data.email.length || !form.find('input[name="email"]')[0].checkValidity()) {
            return form.find('input[name="email"]')[0].reportValidity();
        }

        $.ajax({
            url: `/users/${data.user_id}`,
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

    $('button[form="create-user-form"]').on("click", function(e) {
        e.preventDefault();

        const form = $("#create-user-form");
        const data = form.serializeObject();

        if (!data.username.length || !form.find('input[name="username"]')[0].checkValidity()) {
            return form.find('input[name="username"]')[0].reportValidity(),
                Swal.fire({
                    icon: "error",
                    title: "Username is Too Short",
                    text: "A new user's username must be at least 5 characters"
                });
        }

        if (!data.email.length || !form.find('input[name="email"]')[0].checkValidity()) {
            return form.find('input[name="email"]')[0].reportValidity();
        }

        if ($(this).hasClass('disabled')) {
            const icon = "error";
            let title = "";
            if ((data['new-password'] !== data['confirm-new-password'])) {
                title = "Passwords must match.";
            } else if (data['new-password'].length < 5) {
                title = "Password must be at least 5 characters.";
            }
            return Swal.fire({
                icon,
                title
            });
        }

        if (!checkFormIsValid()) return;

        $.ajax({
            url: "/users",
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
        const data = $("#create-user-form").serializeObject();
        let disableTheBtn = false;
        for (const key in data) {
            if (Object.prototype.hasOwnProperty.call(data, key)) {
                // check to see if any value has been at all for inputs
                if (!data[key].length) disableTheBtn = true;
            }
        }

        if (data['new-password'] !== data['confirm-new-password']) {
            disableTheBtn = true;
        }

        if (data['new-password'].length < 5 || data['confirm-new-password'].length < 5) {
            disableTheBtn = true;
        }

        $('button[form="create-user-form"]').toggleClass('disabled', disableTheBtn);

        return !disableTheBtn;
    }

    $("#users-table tbody tr").on("click", function() {
        const modal = $("#edit-user-modal");
        modal.find('#edit-user-id').text($(this).find('td').eq(0).text());
        modal.find('input[name="username"]').val($(this).find('td').eq(1).text());
        modal.find('input[name="email"]').val($(this).find('td').eq(2).text());

        modal.addClass("showing");
    });

    $("#edit-user-modal button.cancel").on("click", function() {
        $(this).closest('.modal').removeClass('showing');
    });

    $("#edit-user-modal button.danger").on("click", async function() {
        const form = $("#edit-user-form");
        const data = form.serializeObject();
        data.user_id = $("#edit-user-id").text();

        const res = await Swal.fire({
            icon: "warning",
            title: `Deleting "${data.username}"`,
            text: "Are you sure that you would like to delete this user?",
            showDenyButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No'
        });

        if (!res.isConfirmed) return;

        $.ajax({
            url: `/users/${data.user_id}`,
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