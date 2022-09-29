$(function($) {
	$(".toggle-password").on('click', function() {
		$(this).find('i').toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).data("toggle"));

		if (input.attr("type") == "password")
			input.attr("type", "text");
		else
			input.attr("type", "password");
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(window).on('keyup', function(event) {
		if(event.key == 'Escape')
			if($('#loading-container').css('display') == 'block')
				hideLoading();
	});
});

// encode Less Than character to prevent intentional/unintentional HTML injection
function encLT(str) { return str.replace(/</g, '&lt;') }

/* generate random password*/
function randomPassword(length) {
	var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
	var pass = "";
	for (var x = 0; x < length; x++) {
		var i = Math.floor(Math.random() * chars.length);
		pass += chars.charAt(i);
	}
	return pass;
}

function generate() {
	adminfrm.password.value = randomPassword(adminfrm.length.value);
}

function previewMedia(file, previewEl) {
	var reader = new FileReader();

	reader.onload = function() {
		previewEl.src = reader.result;
	}

	reader.readAsDataURL(file);
}

function chkFileExt(elFile) {
	var allowedExts = elFile.getAttribute('data-allowed-ext').toLowerCase().split(',');
	var valid = [];

	for(var i = 0; i < elFile.files.length; i++) {
		var fileExt = elFile.files[i].name.substr(elFile.files[i].name.lastIndexOf('.') + 1).toLowerCase();
		valid[i] = 0;

		for(var j = 0; j < allowedExts.length; j++) {
			if(fileExt == allowedExts[j]) {
				valid[i] = 1;
				break;
			}
		}
	}

	if(valid.join('').indexOf('0') != -1) {
		swal('Invalid file selected', 'Please select file(s) of allowed type.', 'error');
		elFile.value = '';
		return false;
	}

	return true;
}

function getStates(selCountry, selStatesSelector) {
	var countryId = selCountry.options[selCountry.selectedIndex].value;

	if(countryId == '') {
		$(selStatesSelector).html('<option value="">Select a Country First</option>');
		$('#city').html('<option value="">Select a State First</option>');
		return;
	}

	showLoading();
	
	$.getJSON(getStatesUrl + countryId)
		.done(function(states) {
			$('#city').html('<option value="">Select a State First</option>');
			var arStates = [ '<option value="">Select State</option>' ];

			for(var i = 0; i < states.length; i++)
				arStates.push('<option value="' + states[i].id + '">' + states[i].name + '</option>');
		
			$(selStatesSelector).html(arStates.join(''));
		})
		.fail(function() {
			swal('Error occurred', 'Unable to get states of the country from server.', 'error');
		})
		.always(hideLoading);
}

 

function showLoading() {
    $('#loading-container').css('display', 'block');
}

function hideLoading() {
    $('#loading-container').css('display', 'none');
}

function submitForm(form) {
	var $form = $(form);
	showLoading();

	$.ajax({
		headers: { Accept: 'application/json' },
		dataType: 'json',
		type: 'POST',
		url: form.action,
		data: $form.serialize(),
	})
		.done(function(data) {
			if(typeof $form.data('call-on-success') !== 'undefined')
				window[$form.data('call-on-success')](form, data);
			
			if(typeof $form.data('reset-form-on-success') !== 'undefined')
				form.reset();
			
			if(typeof $form.data('on-success-blank-inputs') != 'undefined')
				$($form.data('on-success-blank-inputs')).val('');
			
			if(typeof $form.data('on-success-msg') !== 'undefined') {
				if(typeof $form.data('redirect-on-success') !== 'undefined') {
					swal($form.data('on-success-msg'), '', 'success')
						.then(function() {
							showLoading();
							location = $form.data('redirect-on-success');
						});
					
					return;
				} else
					swal($form.data('on-success-msg'), '', 'success');
			}

			if(typeof $form.data('redirect-on-success') !== 'undefined') {
				showLoading();
				location = $form.data('redirect-on-success');
			}
		})
		.fail(showSubmissionError)
		.always(hideLoading);

	return false;
}

function showSubmissionError(data) {
	try {
		JSON.parse(data.responseText);
	}
	catch {
		swal('', 'Unable to perform the action. Error occurred on server.', 'error');
		return;
	}

	if(typeof data.responseJSON.errors != 'undefined') {
		var errors = data.responseJSON.errors;
		var div = document.createElement('div');

		for(err in errors) {
			for(var i = 0; i < errors[err].length; i++) {
				var p = document.createElement('p');
				p.innerHTML = errors[err][i];
				div.appendChild(p);
			}
		}

		swal({
			title: 'Error(s) Occurred',
			content: div
		});

		return;		
	}

	swal('Error occurred', 'Unable to perform the action', 'error');
}

function formatDate(strDate) {
	if(strDate == '0000-00-00')
		return '-';
	
	if(! (strDate[4] == '-' && strDate[7] == '-'))
		return strDate;
	
	var arDt = strDate.split('-');
	return arDt[1] + '/' + arDt[2] + '/' + arDt[0];
}

function formatTime(strTime) {
	if(strTime == null)
		return '-';
	
	if(! (strTime[2] == ':' && strTime[5] == ':' && strTime.length == 8))
		return strTime;
	
	var ap = 'pm';
	var arTm = strTime.split(':');
	arTm[0] = parseInt(arTm[0]);

	if(arTm[0] < 12) {
		ap = 'am';

		if(arTm[0] == 0) // 12 am/pm
			arTm[0] = 12;
	}
	else if(arTm[0] > 12)
		arTm[0] = arTm[0] - 12;

	return arTm[0] + ':' + arTm[1] + ' ' + ap;
}

function formatDates($arElDates) {
	if(typeof $arElDates == 'undefined')
		var $arElDates = $('.locale-date');
	
	$arElDates.each(function(index, el) {
		el.innerHTML = formatDate(el.innerHTML);
	});
}

function formatTimes($arElTimes) {
	if(typeof $arElTimes == 'undefined')
		var $arElTimes = $('.locale-time');
	
	$arElTimes.each(function(index, el) {
		el.innerHTML = formatTime(el.innerHTML);
	});
}

// opt : a JavaScript object : { inputId: 'email', showMsg: 1 }
function validateEmailAddressFormat(opt) {
	if(typeof opt == 'undefined')
		var opt = { inputId: 'email', showMsg: 1 };
	else {
		if(typeof opt.inputId == 'undefined')
			opt.inputId = 'email';

		if(typeof opt.showMsg == 'undefined')
			opt.showMsg = 1;
	}

	try {
		var emailAddress = $('#' + opt.inputId).val();
	}
	catch(ex) {
		if(opt.showMsg)
			swal('Input control for entering email address not found.', '', 'warning');
		else
			console.log('Input control for entering email address not found.');
		
		return false;
	}

	if(emailAddress === '' && typeof $('#' + opt.inputId).attr('required') == 'undefined')
		return true;
	
	var atPosition = emailAddress.lastIndexOf('@');

	if(atPosition == -1) {
		if(opt.showMsg)
			swal('Please enter a valid email address.', '', 'warning');
		
		return false;
	}

	var dotPosition = emailAddress.indexOf('.', atPosition + 1);

	if(dotPosition == -1 || dotPosition == emailAddress.length - 1) {
		// dot not found after '@' or dot is as last character
		if(opt.showMsg)
			swal('Please enter a valid email address.', '', 'warning');
		
		return false;
	}

	return true;
}

// inputIds : jQuery supported selector format
function validateCharacters(inputIds) {
	var $inputs = $(inputIds);

	for(var a = 0; a < $inputs.length; a++) {
		if($inputs[a].getAttribute('data-allowed-characters') == null)
			continue;
		
		// in input tag, data-allowed-characters attribute value should contain characters being allowed
		// write allowed characters separated by spaces in the attrib value
		// write string 'space' in the attrib value to allow space
		// write string 'A-Z a-z' in attrib value to allow alphabets
		// write string '0-9' in the attrib value to allow numbers
		// set attrib value to blank (data-allowed-characters="") to allow only english alphabets
		
		var allowedChars = $inputs[a].getAttribute('data-allowed-characters');
		var isAlphabetAllowed = allowedChars.indexOf('A-Z a-z');
		var isNumberAllowed = allowedChars.indexOf('0-9');
		var isSpaceAllowed = allowedChars.toLowerCase().indexOf('space');
		var char = '';

		if(isAlphabetAllowed != -1)
			allowedChars = allowedChars.replace('A-Z a-z', '');
		
		if(isNumberAllowed != -1)
			allowedChars = allowedChars.replace('0-9', '0123456789');
		
		if(isSpaceAllowed != -1)
			allowedChars = allowedChars.replace('space', ' ');
		
		for(var b = 0; b <  $inputs[a].value.length; b++) {
			char =  $inputs[a].value[b];
			
			if(! (
				(isAlphabetAllowed != -1 && ( (char >= 'A' && char <= 'Z') || (char >= 'a' && char <= 'z') ) ) ||
				allowedChars.indexOf(char) != -1
			) ) {
				var label = '';

				// label for the input field to display to the user in popup/alert message
				if($inputs[a].getAttribute('data-user-display-label') != null)
					label = ' in ' + $inputs[a].getAttribute('data-user-display-label');
				else {
					// get label for the input
					var $inputLabel = $('label[for="' +  $inputs[a].id + '"]');
					
					if($inputLabel.length)
						label = ' in ' + $inputLabel[0].innerText.trim().replace('*', '');
				}

				swal({
					title: 'Only the following characters are allowed' + label + ':',
					text: $inputs[a].getAttribute('data-allowed-characters'),
					icon: "warning"
				})
					.then(function() {
						$inputs[a].focus();
					});
			
				return false;
			}
		}
	}

	return true;
}
