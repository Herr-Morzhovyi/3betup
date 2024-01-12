<div class="wp-edit-button-box">
	<?php

	if (get_field('logo', 'options')) { ?>
		<a class="text-decoration-none" href="<?php echo get_home_url(); ?>"><?php

		// Logo
		echo wp_get_attachment_image(
			get_field('logo', 'options')['id'],
			'post-thumbnail',
			false,
			array(
				'class' => 'header-logo ' . (get_field('logo_size', 'options') == 'width' ? 'h-auto' : 'w-auto'),
				'sizes' => (get_field('mobile_logo_width', 'options') ? '(max-width:991px) ' . get_field('mobile_logo_width', 'options') . 'px, ' : '') . (get_field('logo_width', 'options') ? get_field('logo_width', 'options') . 'px' : ''),
			)
		);

		// Logo size on desktop and mobile (<=991px)
		if (get_field('logo_width', 'options') || get_field('logo_height', 'options') || get_field('mobile_logo_width', 'options') || get_field('mobile_logo_height', 'options')) {
			   ?><style type="text/css">
					<?php

					// Desktop logo size
					if (get_field('logo_width', 'options') || get_field('logo_height', 'options')) {
						?>
						.header-logo {
							<?php

							if (get_field('logo_size', 'options') == 'width' && get_field('logo_width', 'options')) {
								?>
								width: <?php the_field('logo_width', 'options'); ?>px;
								<?php
							} else if (get_field('logo_size', 'options') == 'height' && get_field('logo_height', 'options')) {
								?>
									height: <?php the_field('logo_height', 'options'); ?>px;
								<?php
							}

							?>
						}

						<?php
					}

					// Mobile logo size
					if (get_field('mobile_logo_width', 'options') || get_field('mobile_logo_height', 'options')) {
						?>
						@media screen and (max-width: 991px) {
							.header-logo {
								<?php

								if (get_field('logo_size', 'options') == 'width' && get_field('mobile_logo_width', 'options')) {
									?>
									width: <?php the_field('mobile_logo_width', 'options'); ?>px;
									<?php
								} else if (get_field('logo_size', 'options') == 'height' && get_field('mobile_logo_height', 'options')) {
									?>
										height: <?php the_field('mobile_logo_height', 'options'); ?>px;
									<?php
								}

								?>
							}
						}

					<?php }
					?>
				</style><?php
			} ?>
		</a>
	<?php } ?>
</div>