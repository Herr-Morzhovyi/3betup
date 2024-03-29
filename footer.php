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
				<div class="text-white text-wrap flex-shrink-1 text-center text-md-start"><?php
					echo get_field('footer_text_2', 'option');
				?></div>
				<div class="d-flex flex-column gap-10 align-items-md-end align-items-center w-100">
					<form method="post" id="subscriptionForm">
						<input type="email" name="email" placeholder="Enter your email" required class="w-100">
						<button type="submit" value="Subscribe"><?php _e('Subscribe', '3betup'); ?></button>
					</form>
					<div class="fw-light fs-12 text-white text-center text-md-end text-xxl-start"><?php

						$terms_page = get_page_by_path('terms-and-conditions', OBJECT, 'page');
						$terms_page_url = $terms_page ? get_permalink($terms_page->ID) : '';

						printf(
							__('By clicking the "Send message" button, I agree to the %1$sTerms & Conditions%3$s and %2$sPrivacy Policy%3$s.', '3betup'),
							'<a class="text-pale-lavender text-decoration-none" href="' . $terms_page_url . '">',
							'<a class="text-pale-lavender text-decoration-none" href="' . get_privacy_policy_url(  ) . '">',
							'</a>'
						);
					?></div>
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
					<div class="d-flex w-100 justify-content-between gap-25 align-items-center mb-md-35 mb-20">
						<h2 class="d-block text-md-center text-start text-white fs-md-20 fs-16"><?php _e('Write your message here and our managers will reach out to you!', '3betup') ?></h2>
						<button type="button" class="btn d-block d-md-none" data-bs-dismiss="modal" aria-label="Close">
							<img src="<?php echo get_template_directory_uri() . '/images/close.svg'; ?>" alt="">
						</button>
					</div><?php
					
					$contact_form_id = get_field('footer_modal_contact_form', 'option');
					echo do_shortcode( '[contact-form-7 id="' . $contact_form_id .'"]');
				?></div>
				<div class="success-message position-relative">
					<button type="button" class="btn position-absolute end-0" data-bs-dismiss="modal" aria-label="Close">
						<img src="<?php echo get_template_directory_uri() . '/images/close.svg'; ?>" alt="">
					</button>
					<div class="d-flex h-100 w-100 flex-column align-items-center justify-content-center">
						<img src="<?php echo get_template_directory_uri(  ) . '/images/success.png'; ?>" alt="" style="margin-bottom: 10px; height: 48px; width: 48px;">
						<h3 class="text-white fs-20 fw-semibold text-center"><?php _e('We received your message!', '3betup'); ?></h3>
						<h4 class="text-white fs-20 fw-semibold text-center"><?php _e('Our managers will contact you as soon as possible!', '3betup'); ?></h4>
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