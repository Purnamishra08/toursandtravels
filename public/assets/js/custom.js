
window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

$(document).ready(function () {
    $(".date-picker").datepicker({
        autoclose: true,
        todayHighlight: true,
        changeMonth: true, // Allow month selection
        changeYear: true, // Allow year selection
        maxDate: 0, // Restrict to current date and earlier
        showButtonPanel: true, // Show footer buttons
        closeText: "Close", // Customize close button text
        currentText: "Today", // Customize today button text
        clearText: "Clear", // Customize clear button text
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find(".ui-datepicker-close").hide(); // Hide default close button
                if (!$(inst.dpDiv).find(".ui-datepicker-clear").length) {
                    $(inst.dpDiv)
                        .find(".ui-datepicker-buttonpane")
                        .append(
                            '<button type="button" class="ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all">Clear</button>'
                        ); // Add Clear button
                }
            }, 1);
        },
    });
});

$(document).ready(function () {
    $(".date-picker-no-validation").datepicker({
        autoclose: true,
        todayHighlight: true,
        changeMonth: true, // Allow month selection
        changeYear: true, // Allow year selection
        showButtonPanel: true, // Show footer buttons
        closeText: "Close", // Customize close button text
        currentText: "Today", // Customize today button text
        clearText: "Clear", // Customize clear button text
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find(".ui-datepicker-close").hide(); // Hide default close button
                if (!$(inst.dpDiv).find(".ui-datepicker-clear").length) {
                    $(inst.dpDiv)
                        .find(".ui-datepicker-buttonpane")
                        .append(
                            '<button type="button" class="ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all">Clear</button>'
                        ); // Add Clear button
                }
            }, 1);
        },
    });
});

$(document).ready(function () {
    $(".date-picker-min-today").datepicker({
        autoclose: true,
        todayHighlight: true,
        changeMonth: true, // Allow month selection
        changeYear: true, // Allow year selection
        minDate: +1, // Restrict to current date and earlier
        showButtonPanel: true, // Show footer buttons
        closeText: "Close", // Customize close button text
        currentText: "Today", // Customize today button text
        clearText: "Clear", // Customize clear button text
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find(".ui-datepicker-close").hide(); // Hide default close button
                if (!$(inst.dpDiv).find(".ui-datepicker-clear").length) {
                    $(inst.dpDiv)
                        .find(".ui-datepicker-buttonpane")
                        .append(
                            '<button type="button" class="ui-datepicker-clear ui-state-default ui-priority-secondary ui-corner-all">Clear</button>'
                        ); // Add Clear button
                }
            }, 1);
        },
    });
});
// Clear only the selected date field
$(document).on("click", ".ui-datepicker-clear", function() {
    var inputField = $.datepicker._curInst.input; // Get the currently active input
    inputField.val(""); // Clear only the selected input field
    inputField.datepicker("hide"); // Hide datepicker after clearing
});

// Ensure "Today" button selects today's date
$(document).on("click", ".ui-datepicker-current", function() {
    var inputField = $.datepicker._curInst.input; // Get the currently active input
    var today = new Date();
    today.setHours(0, 0, 0, 0); // Set time to midnight
    inputField.datepicker("setDate", today); // Set the date to today
});

