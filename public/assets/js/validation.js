// validation.js
function validateForm() {
    let oldPassword = document.getElementById("old_password").value;
    let newPassword = document.getElementById("new_password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (oldPassword.trim() === "") {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Old Password is required!", confirmButtonColor: "#d33" });
        return false;
    }

    if (newPassword.trim() === "") {
        Swal.fire({ icon: "error", title: "Validation Error", text: "New Password is required!", confirmButtonColor: "#d33" });
        return false;
    }

    if (newPassword.length < 6) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "New Password must be at least 6 characters long!", confirmButtonColor: "#d33" });
        return false;
    }

    if (confirmPassword.trim() === "") {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Confirm Password is required!", confirmButtonColor: "#d33" });
        return false;
    }

    if (confirmPassword.length < 6) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Confirm Password must be at least 6 characters long!", confirmButtonColor: "#d33" });
        return false;
    }

    if (newPassword !== confirmPassword) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "New & Confirm Passwords do not match!", confirmButtonColor: "#d33" });
        return false;
    }

    if (newPassword == oldPassword) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "New & Old Passwords cannot be same!", confirmButtonColor: "#d33" });
        return false;
    }

    return true; // Allow form submission
}
function validateFormAddUser() {
    let uname = document.getElementById("uname").value.trim();
    let utype = document.querySelector('input[name="utype"]:checked'); // Get selected radio
    let contact = document.getElementById("contact").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let cpassword = document.getElementById("cpassword").value.trim();

    // Name validation (No numbers allowed)
    let nameRegex = /^[A-Za-z\s]+$/;
    if (uname === "" || !nameRegex.test(uname)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Name is required and should not contain numbers!", confirmButtonColor: "#d33" });
        return false;
    }

    // User Type validation
    if (!utype) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Please select a User Type!", confirmButtonColor: "#d33" });
        return false;
    }

    // Contact number validation (10-digit only)
    let contactRegex = /^[6-9]\d{9}$/;
    if (contact === "" || !contactRegex.test(contact)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Enter a valid 10-digit mobile number!", confirmButtonColor: "#d33" });
        return false;
    }

    // Email validation
    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email === "" || !emailRegex.test(email)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Enter a valid email address!", confirmButtonColor: "#d33" });
        return false;
    }

    // Password validation (min 6 chars)
    if (password.length < 6) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Password must be at least 6 characters long!", confirmButtonColor: "#d33" });
        return false;
    }

    // Confirm Password validation
    if (cpassword.length < 6) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Confirm Password must be at least 6 characters long!", confirmButtonColor: "#d33" });
        return false;
    }

    // Password match validation
    if (password !== cpassword) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Passwords do not match!", confirmButtonColor: "#d33" });
        return false;
    }

    return true; // Allow form submission
}
function validateFormEditUser() {
    let uname = document.getElementById("uname").value.trim();
    let utype = document.querySelector('input[name="utype"]:checked'); // Get selected radio
    let contact = document.getElementById("contact").value.trim();
    let email = document.getElementById("email").value.trim();

    // Name validation (No numbers allowed)
    let nameRegex = /^[A-Za-z\s]+$/;
    if (uname === "" || !nameRegex.test(uname)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Name is required and should not contain numbers!", confirmButtonColor: "#d33" });
        return false;
    }

    // User Type validation
    if (!utype) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Please select a User Type!", confirmButtonColor: "#d33" });
        return false;
    }

    // Contact number validation (10-digit only)
    let contactRegex = /^[6-9]\d{9}$/;
    if (contact === "" || !contactRegex.test(contact)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Enter a valid 10-digit mobile number!", confirmButtonColor: "#d33" });
        return false;
    }

    // Email validation
    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email === "" || !emailRegex.test(email)) {
        Swal.fire({ icon: "error", title: "Validation Error", text: "Enter a valid email address!", confirmButtonColor: "#d33" });
        return false;
    }

    return true; // Allow form submission
}

//============ Function to check field having no value ===============
function blankCheck(controlId, msg)
{
    
    if ($('#' + controlId).val() == '')
    {
        Swal.fire({
            icon: "error",
            title: "Validation Error",
            text: msg,
            confirmButtonColor: "#d33",
        });
        
        $('#' + controlId).focus();
        return false;
    }
    return true;
}

//============ Function to check field value is only numeric ===============
function onlyNumeric(controlId)
{
    var numPattern = new RegExp(/^\d+$/);
    var txtVal = $('#' + controlId).val();
    
    if (txtVal != '')
    {
        if (numPattern.test(txtVal) == true)
            return true;
        else
        {
            Swal.fire({
                icon: "error",
                title: "Validation Error",
                text: "Enter only numeric values",
                confirmButtonColor: "#d33",
            });
            $('#' + controlId).focus();
            return false;
        }
    }
    else
        return true;
}
