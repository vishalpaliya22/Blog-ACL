function validateAndSubmitForm(form) {
	if(!validateEmailAddressFormat())
		return false;
	
	if(!validateCharacters('#name'))
		return false;
	
	return submitForm(form);
}
