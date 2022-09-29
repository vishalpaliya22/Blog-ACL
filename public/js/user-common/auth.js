function forgotPwdSubmitReply(form, response) {
	$('.hide-after-form-submit').hide();
	$('.show-after-form-submit').removeClass('d-none');

	$('#user-email-addr')
		.attr('href', 'mailto:' + $('#email').val())
		.html($('#email').val());
}

function resetPwdSubmitReply(form, response) {
	$('.hide-after-form-submit').hide();
	$('.show-after-form-submit').removeClass('d-none');
}
