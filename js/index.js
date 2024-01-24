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
	document.addEventListener('wpcf7mailsent', function(event) {
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
	// Assuming your modal has an id of 'myModal'
	$('#contactFormModal').on('hidden.bs.modal', function (e) {
		// Show the form
		$('#footerContactFormContainer').show();
		var successMessage = $('.success-message');
		successMessage.hide();
	});

	const navContainer = document.getElementById('main-navigation-container')
	const closeBtn = document.getElementById('menu-checkbox')

	// Adding 'click' event listener
	document.addEventListener('click', function handleClickOutsideBox(event) {

		// If something clicked outside main-navigation-container, close the menu
		if ( ! navContainer.contains(event.target)) {
			closeBtn.checked = false
		}
	})

	let lastScrollTop = 0

	window.addEventListener("scroll", function(event){
		let offset = window.pageYOffset || document.documentElement.scrollTop
		if (offset > document.documentElement.clientHeight * 0.3 ) {
			if (offset > lastScrollTop) {
				document.getElementById('header').classList.add('header-hide') 
			} else {
				document.getElementById('header').classList.remove('header-hide')
			}
		}
		lastScrollTop = offset <= 0 ? 0 : offset
		if ( ! navContainer.contains(event.target)) {
			closeBtn.checked = false
		}
	}, false)
});