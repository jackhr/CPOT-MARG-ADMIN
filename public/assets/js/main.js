const STATE = {
    dtDefaultOpts: {
        scrollX: true
    },
    regEx: {
        doubleOrInt: /^\d*\.?\d{1,2}$/,
        decimal: /^\d*\.?\d+$/,
        email: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
    },
    modalDelay: 400,
    weightConst: 2.20462,
    lengthConst: 2.54,
}

const convertUnits = (type, value, convertUp = true) => {
    const unitConst = STATE[`${type}Const`];
    return convertUp ? value / unitConst : value * unitConst;
};

function formatPrice(price) {
    // Convert to number and then to a string and use toLocaleString for formatting
    return Number(price).toLocaleString('en-US', {
        minimumFractionDigits: 2, // Ensures two decimal places
        maximumFractionDigits: 2 // Prevents more than two decimal places
    });
}

function formatResource(resource) {
    return {
        ...resource,
        base_price: formatPrice(resource.base_price)
    }
}

$(document).ready(function () {
    $("#ham-btn").on('click', function () {
        $("#ham-menu").toggleClass('viewing'); s
    });

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
        const modal = $(".modal.showing");

        if (
            modal.hasClass("showing") // Modal is showing
            && !target.is(".modal-dialog") // Target is not modal dialog
            && !target.is(".open-modal-btn") // Target is not open modal button
            && !$(".swal2-container").length // No sweetalert modal showing
            && !target.closest("table").length // Target is not inside a table
            && !target.closest(".modal-dialog").length // Click is not inside modal dialog
            && !target.closest(".open-modal-btn").length // CLick is not inside open modal button
        ) {
            modal.find(".modal-close").trigger("click");
        }
    });
});