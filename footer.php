<footer class="bg-dark-indigo">
	<div class="container pt-25 pb-50">
		<div class="row gy-md-40 gy-50">
			<div class="col-xxl-4 col-12 text-white d-flex flex-column flex-xxl-row justify-content-center align-items-xxl-start align-items-center gap-20 footer-menu"><?php
				if (has_nav_menu('primary')) {

					$menu_items_primary = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['primary']));
					_wp_menu_item_classes_by_context($menu_items_primary);
				
					show_nav_menu_items_footer(0, $menu_items_primary, 'primary');
				
				}
				if (has_nav_menu('secondary')) {

					$menu_items_primary = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['secondary']));
					_wp_menu_item_classes_by_context($menu_items_primary);
				
					show_nav_menu_items_footer(0, $menu_items_primary, 'secondary');
				
				}
			?></div>
			<div class="col-xxl-4 col-12 d-flex flex-xxl-column flex-md-row flex-column justify-content-between justify-content-xxl-start gap-md-30 gap-20 align-items-center align-items-xxl-start">
				<div class="text-white footer_text text-center text-md-start"><?php
					echo get_field('footer_text', 'option');
				?></div>
				<button type="button" data-bs-toggle="modal" data-bs-target="#contactFormModal" class="contact-form-modal-launch-button"><?php _e('Write direct message to us', '3betup'); ?></button>
			</div>
			<div class="col-xxl-3 offset-xxl-1 col-12 d-flex flex-xxl-column flex-md-row flex-column justify-content-between justify-content-xxl-start gap-md-30 gap-20 align-items-center align-items-xxl-start">
				<div class="text-white mb-30 text-wrap flex-shrink-1 text-center text-md-start"><?php
					echo get_field('footer_text_2', 'option');
				?></div>
				<div class="d-flex flex-column gap-10 align-items-start">
					<form method="post" id="subscriptionForm">
						<input type="email" name="email" placeholder="Enter your email" required class="w-100">
						<button type="submit" value="Subscribe">Subscribe</button>
					</form>
					<div class="fw-light fs-12 text-white"><?php _e('By clicking the "Send message" button, I agree to the Terms & Conditions and Privacy Policy.', '3betup'); ?></div>
				</div>
				
			</div>
		</div>
	</div>
</footer>
<div class="modal fade" id="contactFormModal" tabindex="-1" aria-labelledby="contactFormModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mx-auto">
		<div class="modal-content">
			<div class="modal-body px-md-40 py-md-25 p-20">
				<div id="footerContactFormContainer">
					<h2 class="d-block text-center text-white fs-md-20 fs-18 mb-md-35 mb-20"><?php _e('Write your message here and our managers will reach out to you!', '3betup') ?></h2><?php
					$contact_form_id = get_field('footer_modal_contact_form', 'option');
					echo do_shortcode( '[contact-form-7 id="' . $contact_form_id .'"]');
				?></div>
				<div class="success-message">
					<div class="d-flex h-100 w-100 flex-column align-items-center justify-content-center">
						<img src="<?php echo get_template_directory_uri(  ) . '/images/success.png'; ?>" alt="" style="margin-bottom: 10px; height: 48px; width: 48px;">
						<h3 class="text-white fs-20 fw-semibold">We received your message!</h3>
						<h4 class="text-white fs-20 fw-semibold">Our managers will contact you as soon as possible!</h4>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	
</script>
<?php wp_footer(); ?>
</body>
</html>