
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
    });
});

$(document).ready(function () {
    $(".date-picker-no-validation").datepicker({
        autoclose: true,
        todayHighlight: true,
        changeMonth: true, // Allow month selection
        changeYear: true, // Allow year selection
    });
});





