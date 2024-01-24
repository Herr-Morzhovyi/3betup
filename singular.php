<?php

get_header();

?>
<section>
	<div class="container pt-60 pb-md-150 pb-100">
		<div class="row">
			<div class="col-12 col-lg-10 offset-lg-1">
				<h1 class="fs-lg-24 fs-md-20 fs-18 text-pale-lavender mb-10 fw-bold text-center text-xxl-start"><?php the_title(); ?></h1>
				<div class="fs-md-18 fs-16 text-white">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</section><?php

get_footer();