// * Subscription form validation
jQuery(document).ready(function ($) {
	$('#subscriptionForm').submit(function (e) {
		// Validate email
		var emailInput = $('input[name="email"]');
		var isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.val());

		if (!isValidEmail) {
			alert('Please enter a valid email address.');
			e.preventDefault();
			return;
		}
	});
	document.addEventListener('wpcf7submit', function(event) {
		var form = $('#footerContactFormContainer');

		var formHeight = form.outerHeight();
		// Hide form
		form.hide();

		// Display the success message
		var successMessage = $('.success-message');
		// Assign the same height as form
		successMessage.css('height', formHeight + 'px');

		successMessage.show();
        
    }, false);
});