$(document).ready(function () {
    $("#ham-btn").on('click', function () {
        $("#ham-menu").toggleClass('viewing'); s
    });

    const table = new DataTable("#users-table");

    $(".password-eye-container").on("click", function () {
        const passwordInput = $(this).closest('.password-container').children('input');
        const viewingPassWord = passwordInput.prop("type") === "text";
        const newInputType = viewingPassWord ? "password" : "text";
        passwordInput.prop("type", newInputType);
    });

    $(".modal-close").on("click", function () {
        $(this).closest(".modal").removeClass("showing");
    });

    $(document).off('click').on("click", function (e) {
        const target = $(e.target);
        const modal = $("#create-user-modal");

        if (
            modal.hasClass("showing") && // Modal is showing
            !$(".swal2-container").length && // No sweetalert modal showing
            !target.closest(".modal-dialog").length && // Click is not inside modal dialog
            !target.is(".modal-dialog") && // Target is not modal dialog
            !target.closest(".open-modal-btn").length && // CLick is not inside open modal button
            !target.is(".open-modal-btn") // Target is not open modal button
        ) {
            modal.removeClass("showing");
        }
    });
});