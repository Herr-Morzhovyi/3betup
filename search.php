<?php

get_header();

?><section class="mt-30 position-relative">
	<div class="container wp-edit-button-box"><?php

		get_template_part( '/parts/breadcrumb', 'section' );

		?><div class="row">
			<div class="col-12 col-lg-8"><?php

				// * Title
				?><h1 class="font-spectral text-35 text-lg-50 fw-bold mb-40"><?php echo sprintf( _n( 'Viser %d resultater for "%s"', 'Viser %d resultater for "%s"', $wp_query->found_posts, 'alesundfhs' ), $wp_query->found_posts, get_search_query() ); ?></h1><?php

				// * Search form
				?><div class="search-link d-block font-spectral text-17 fw-semibold mb-lg-80 mb-50 text-dark">
					<form role="search" method="get" id="searchform-dark" action="<?php echo get_site_url(); ?>/" class="d-flex border-bottom border-2 border-dark">
						<input name="s" type="text" aria-label="<?php _e('Søk på siden...', 'alesundfhs'); ?>" class="flex-fill border-0 bg-transparent text-dark" placeholder="<?php _e('Søk på siden...', 'alesundfhs'); ?>">
						<button type="submit" class="bg-transparent border-0 px-15 py-10 source-search-button"><img src="<?php echo get_template_directory_uri(); ?>/images/search-dark.svg" alt=""></button>
					</form>
				</div>
			</div>
		</div><?php

		// * Search results
		?><div class="row"><?php
			if (have_posts()) {
				while (have_posts()) {
					the_post(); 
					$content = get_extended(get_post_field( 'post_content', get_the_ID() ));
					if ($content['extended']) {
						$ingress = apply_filters('the_content', $content['main']);
						$text = apply_filters('the_content', $content['extended']);
					} else {
						$ingress = ''; 
						$text = apply_filters('the_content', $content['main']);
					}
					
					// * Single search result
					?><div class="col-12 col-md-6 mb-lg-80 mb-40 wp-edit-button-box post-preview"><?php

						show_post_edit_button(get_the_ID());

						?><a href="<?php echo get_permalink(); ?>" class="text-decoration-none d-block">
							<div class="ratio ratio-3x2"><?php

								// * Post thumbnail or light blue background if none
								if (has_post_thumbnail( )) {
									the_post_thumbnail( 'post-thumbnail', [
										'class' => 'position-cover',
										'sizes' => '(max-width: 576px) calc(100vw - 40px), (max-width: 767px) 536px, (max-width: 991px) 727px, (max-width: 1200px) 405px, (max-width: 1400px) 460px, 620px'
									] );
								} else {
									?><div class="position-cover bg-secondary">

									</div><?php
								}

							?></div><?php

							// * Title
							?><a href="<?php echo get_permalink(); ?>" class="text-decoration-none d-block">
								<h3 class="mt-30 mb-25 font-spectral text-lg-30 text-26 fw-bold text-dark"><?php the_title(); ?></h3><?php
							?></a><?php
							// * Ingress
							if ($ingress) {
								?><div class="font-figtree text-md-20 text-17 text-dark"><?php
									echo $ingress;
								?></div><?php
							} else {
								?><div class="font-figtree text-md-20 text-17 text-dark"><?php
									echo substr( strip_tags($text), 0, 150 ) . ' […]';
								?></div><?php
							}
						?></a>
					</div>
				<?php }
			}
		?></div><?php

		// * Pagination
		?><div class="text-20 mb-100">
			<?php the_posts_pagination([
				'prev_text' => get_inline_svg( get_template_directory() . '/images/dropdown-inline.svg'),
				'next_text' => get_inline_svg( get_template_directory() . '/images/dropdown-inline.svg'),
				'class'     => 'pagination'
			]); ?>
		</div>
    </div>
</section><?php

get_footer();