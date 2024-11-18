function showEditModal(email, name, role) {
	$("#edit_email").val(email);
	$("#modal_title").text(`User : ${email}`);
	$("#edit_name").val(name);
	$("div.modal-select select").val(role).change();

	$.magnificPopup.open({
		items: {
			src: '#modalForm' // ID of modal that you want to show
		},

		type: 'inline'
	});
}

function showNewUserModal() {
	$.magnificPopup.open({
		items: {
			src: '#newModalForm' // ID of modal that you want to show
		},

		type: 'inline'
	});

	let usernameError = true;
	let nameError     = true;
	let passError     = true;

	$('#new_email').on('change', function () {
		var username = $('#new_email').val();

		if (username.length === 0) {
			setError($('#new_email'), $('#email_error_msg'), "This field is required");
			usernameError = true;
		} else {
			if (/\s/.exec(username)) {
				setError($('#new_email'), $('#email_error_msg'), "No white space is allowed");
				usernameError = true;
			} else {
				removeError($('#new_email'), $('#email_error_msg'));
				usernameError = false;
			}
		}
	});

	$('#new_name').on('change', function () {
		var name = $('#new_name').val();
		if (name.length === 0) {
			setError($('#new_name'), $('#name_error_msg'), "This field is required");
			nameError = true;
		} else {
			removeError($('#new_name'), $('#name_error_msg'));
			nameError = false;
		}
	});

	$('#new_password').on('change', function () {
		var password = $('#new_password').val();

		if (password.length < 6) {
			setError($('#new_password'), $('#pass_error_msg'), "Minimum 6 character is required");
			passError = true;
		} else {
			removeError($('#new_password'), $('#pass_error_msg'));
			passError = false;
		}
	});
}

function setError(field, msgId, msg) {
	field.css('border-color', 'red');
	msgId.text(msg);
}

function removeError(field, msgId) {
	field.css('border-color', '');
	msgId.text('');
}
