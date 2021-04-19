"use strict";

// Class definition
var KTUserAdd = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;
	var avatar;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_user_add_user', {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
			var password = $('#password').val();
			var pc = $('#password_confirmation').val();

			if(password!=null || password!=""){
				if(password!=pc){
					swal.fire({
						"title": "",
						"text": "The Password Not Same with Confirm Password",
						"type": "warning",
						"confirmButtonClass": "btn btn-warning"
					});
					wizardObj.stop();  // don't go to the next step

				}
			}
		})

		// Change event
		wizard.on('change', function(wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {
				// Step 1
				profile_avatar: {
					//required: true
				},
				profile_first_name: {
					required: true
				},
				profile_last_name: {
					required: true
				},
				profile_phone: {
					required: true
				},
				profile_email: {
					required: true,
					email: true
				}
			},

			// Display error
			invalidHandler: function(event, validator) {
				KTUtil.scrollTop();

				swal.fire({
					"title": "",
					"text": "There are some errors in your submission. Please correct them.",
					"type": "error",
					"buttonStyling": false,
					"confirmButtonClass": "btn btn-brand btn-sm btn-bold"
				});
			},

			// Submit valid form
			submitHandler: function (form) {

			}
		});
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {

			if (validator.form()) {
				// See: src\js\framework\base\app.js
				KTApp.progress(btn);
				//KTApp.block(formEl);

				// See: http://malsup.com/jquery/form/#ajaxSubmit
				formEl.ajaxSubmit({
					url: "/users",         // override for form's 'action' attribute
        	type: 'post',        // 'get' or 'post', override for form's 'method' attribute
					success: function(response) {
						console.log(response);
						KTApp.unprogress(btn);
						swal.fire({
							"title": "",
							"text": "The application has been successfully submitted!",
							"type": "success",
							"confirmButtonClass": "btn btn-secondary"
						});
						location.reload();
					}
				});
			}
		});
	}

	var initUserForm = function() {
		avatar = new KTAvatar('kt_user_add_avatar');
	}

	return {
		// public functions
		init: function() {
			formEl = $('#kt_user_add_form');

			initWizard();
			initValidation();
			initSubmit();
			initUserForm();
		}
	};
}();

jQuery(document).ready(function() {
	KTUserAdd.init();
});
