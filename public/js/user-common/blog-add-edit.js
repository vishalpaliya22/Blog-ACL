// used for individual forms of age/rate group in edit page,
// for validating characters in age/rate group title when its form is submitted
var ageRateGrpFormNum = 0;

$(function() {
	
    new Tagify($('#tag')[0], { delimiters: null });
    // Summernote
    $('#long_description').summernote({
      height: 150,
    });
});

function checkHeaderImgAndShowPreview(elFile) {
	if(!chkFileExt(elFile)) {
		$('#img-header').attr('src', '');
		return;
	}
	
	if(elFile.value)
		previewMedia(elFile.files[0], $('#img-header')[0]);
	else
		$('#img-header').attr('src', '');
}

function checkFilesAndShowPreview(elFile) {
	var tmpl = $('#tmpl-img-pckg')[0];
	var container = tmpl.parentNode;

	for(var i = container.children.length - 1; i > 0; i--)
		container.removeChild(container.children[i]);

	if(!chkFileExt(elFile))
		return;

	for(var i = 0; i < elFile.files.length; i++) {
		var tmpl2 = tmpl.cloneNode(true);
		tmpl2.id = "";
		var img  = tmpl2.getElementsByClassName('img-pckg')[0];
		tmpl.parentNode.appendChild(tmpl2);
		$(tmpl2).removeClass('d-none');
		previewMedia(elFile.files[i], img);
	}
}

function validateAddPckgForm() {
	if($('#tbody-pckg-rate-grps')[0].children.length == 0) {
		swal('At least one rate group is required', '', 'error');
		return false;
	}

	if(!validateCharacters('#name, .txt-rate-for'))
		return false;
	
	return true;
}

function updatePhotoStatus(chkPhotoStatus) {
	showLoading();

	$.post(updatePhotoStatusUrl + chkPhotoStatus.value, { status: chkPhotoStatus.checked ? 1 : 0 })
		.done(function() {
			swal('Status of the photo updated', '', 'success');
		})
		.fail(showSubmissionError)
		.always(hideLoading);
}

function pckgRateGrpSaved(form, response) {
	if(typeof response.tour_package_rate_id != 'undefined')
		form.getElementsByClassName('hid-rate-id')[0].value = response.tour_package_rate_id;
}

function deletePckgRateGrp(btn) {
	var rateId = $(btn).parents('form').children('.hid-rate-id').val();
	
	if(rateId) {
		swal({
			title: 'Are you sure to delete the rate group?',
			text: '',
			icon: "warning",
			buttons: {
				no: {
					text: 'No, cancel!',
					value: false,
				},
				yes: {
					text: 'Yes, delete!',
					className: 'btn-danger',
				}
			}
		}).then(function(result) {
			if(!result)
				return;
			
			showLoading();

			$.ajax({
				type: 'POST',
				url: deletePckgRateGrpUrl + rateId,
				data: { _method: 'DELETE' }
			})
				.done(function() {
					swal('Rate group deleted', '', 'success');
					$(btn).parents('.pckg-rate-grp').remove();
				})
				.fail(showSubmissionError)
				.always(hideLoading);
		});

		return;
	} else
		$(btn).parents('.pckg-rate-grp').remove();
}
