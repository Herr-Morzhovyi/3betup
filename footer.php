<footer class="bg-dark-indigo">
	<div class="container pt-25 pb-50">
		<div class="row">
			<div class="col-4 text-white">
				Menu
				<?PHP // tODO ?>
				<a href="<?php echo get_home_url(  ); ?>">Home</a>
				<a href="<?php echo get_post_type_archive_link( 'casino' ); ?>">Casinos</a>
				<a href="https://3betup.andrewstech.tech/bonuses-and-tournaments/">Bonuses&Tournaments</a>
			</div>
			<div class="col-4">
				<div class="text-white mb-30 footer_text"><?php
					echo get_field('footer_text', 'option');
				?></div>
				<button type="button" data-bs-toggle="modal" data-bs-target="#contactFormModal" class="contact-form-modal-launch-button"><?php _e('Write direct message to us', '3betup'); ?></button>
			</div>
			<div class="col-3 offset-1">
				<div class="text-white mb-30 text-wrap"><?php
					echo get_field('footer_text_2', 'option');
				?></div>
				<form method="post" id="subscriptionForm">
					<input type="email" name="email" placeholder="Enter your email" required>
					<button type="submit" value="Subscribe">Subscribe</button>
				</form>
			</div>
		</div>
	</div>
</footer>
<div class="modal fade" id="contactFormModal" tabindex="-1" aria-labelledby="contactFormModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body px-40 py-25">
				<div id="footerContactFormContainer">
					<h2 class="d-block text-center text-white fs-20 mb-35"><?php _e('Write your message here and our managers will reach out to you!', '3betup') ?></h2><?php
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