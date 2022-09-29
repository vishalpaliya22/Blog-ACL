function validateAndSubmitForm(form) {
	if(!validateEmailAddressFormat())
		return false;
	
	if(!validateCharacters('#first_name, #last_name, #phone_number'))
		return false;
	
	return submitForm(form);
}

function updateRole(chkRole) {
	showLoading();
	
	$.ajax({
		method: 'post',
		url: updateRoleUrl,
		data: { role: chkRole.value }
	})
	.done(function() {
		swal('Role ' + (chkRole.checked ? 'assigned.' : 'unassigned.'), '', 'info');
	})
	.fail(function() {
		swal('Unable to ' + (chkRole.checked ? 'assign' : 'unassign') + ' the role.', '', 'error');
		chkRole.checked = !chkRole.checked;
	})
	.always(hideLoading);
}
