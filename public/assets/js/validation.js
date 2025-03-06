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


//============ Function to check dropdown is selected  ===============
function selectDropdown(controlId, msg)
{
    var ddlVal = $('#' + controlId).val();
    if (ddlVal == '0' || ddlVal == '' || ddlVal == null)
    {
        Swal.fire({
            icon: "error",
            text: msg,
            confirmButtonColor: "#d33",
        });
        $('#' + controlId).focus();
        return false;
    }
    return true;
}


//============ Function to check field value is decimal ===============
function checkDecimal(controlId)
{
    var data = $('#' + controlId).val();

    if(data != ' ')
    {
        var reg = new RegExp(/^[0-9]+(\.[0-9]{1,2})?$/);
        if (reg.test(data) == true)
            return true;
        else
        {
            if(data != ''){
                Swal.fire({
                    icon: "error",
                    text: "Enter only decimal values having 2 digit after decimal",
                    confirmButtonColor: "#d33",
                });
                $('#' + controlId).focus();
                return false;
            }else{
                return true;
            }
        }
    }
}

function maxLength(controlId, ctrlLen, fieldName)
{
    if ($('#' + controlId).val().length > ctrlLen && $('#' + controlId).val().length > 0)
    {
        viewAlert(fieldName + ' should not more than ' + ctrlLen + ' charater !!!', controlId);
        $('#' + controlId).focus();
        return false;
    }
    return true;
}

/* Start - Add and/or Delete Row in jQuery */
$(document.body).on('click', '.addrowbtn', function () {
	var rowindex = $(this).closest("tr")[0].rowIndex;
	var clone = $("#addRowTable tr:last").clone();
	var i = $("#addRowTable > tbody > tr").length;

	a = new Array();
	$('a[name="del[]"]').each(function () {
		var thisidsplt = this.id.split("_");
		a.push(thisidsplt[1]);
	});
	if (!(i >= 1)) { a.push(-1); }
	var max_of_array = Math.max.apply(null, a);
	i = parseInt(max_of_array) + 1;

	clone.find("td").each(function () {
		$(this).find('input, select, img, a').each(function () {
			var id = $(this).attr('id') || null;
			if (id) {
				var alsplt = id.split("_");
				var prefix = alsplt[0];

				$(this).attr('id', prefix + '_' + (+i));

				//if((prefix == "taxname") || (prefix == "cdepartment") || (prefix == "cdesignation")) { $(this).val('0'); }
				//else if(prefix == "taxtype") { }
				//else { $(this).val(''); }
				$(this).val('');

				$(this).removeAttr('value');
				$(this).removeAttr("disabled");

				/* Start-Rename the error elements */
				clone.find("td").find('label').each(function () {
					if ($(this).attr('for') === id) {
						$(this).attr('for', prefix + '_' + (+t));
						$(this).html("");
					}
				});
				/* End-Rename the error elements */
			}
		});
	});
	$("#addRowTable tr:eq(" + rowindex + ")").after(clone);
	//$("#addRowTable").append(clone);
});

$(document.body).on('click', '.delrowbtn', function () {
	var getid = $(this).attr('id');
	var j = $("#addRowTable > tbody > tr").length;
	if (j <= 1) {
		alert("There should be at least one row");
	}
	else {
		var cnf = confirm("Are you sure to delete the row ?");
		if (cnf) {
			$("#" + getid).closest('tr').remove();
		}
	}
});


/* End - Add and/or Delete Row in jQuery */


//============ Function to check field value is only numeric with custom message ===============
function onlyNumeric(controlId,msg)
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
                text: msg,
                confirmButtonColor: "#d33",
            });
            $('#' + controlId).focus();
            return false;
        }
    }
    else
        return true;
}

function validateFilePresence(controlId, msg) {
    var fileInput = document.getElementById(controlId);
    var file = fileInput.files[0];

    if (!file) {
        Swal.fire({
            icon: "error",
            text: msg,
            confirmButtonColor: "#d33",
        });
        return false;
    }
    return true;
}