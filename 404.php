<?php

global $wp_query;
$wp_query->set_404();
status_header(404);

get_header();

?>
<section class="mt-25 mt-xxl-50 position-relative">
	<div class="container">
		<div class="text-center py-100">
			<div class="d-flex justify-content-center text-primary fw-bold text-404">
				<div id="a404-1">4</div>
				<div id="a404-2">0</div>
				<div id="a404-3">4</div>
			</div>
			<div class="text-40 fw-bold text-white my-80">
				<?php _e('The page you seek is missing', '3betup'); ?>
			</div>
		</div>
	</div>
</section>
<?php

get_footer();

exit();