<?php

get_header();

// * Banner section
?><section id="banner">
	<div class="container">
		<div class="row align-items-center mt-10">
			<div class="col-xxl-6 col-12 my-80 my-xxl-0">
				<h1 class="fs-36 text-pale-lavender mb-10 fw-bold text-center text-xxl-start"><?php the_field('banner_title'); ?></h1>
				<p class="fs-20 mb-40 text-center text-xxl-start" style="color: #d4d3d3; line-heigth: 152.5%;"><?php echo strip_tags(get_field('banner_text')); ?></p>
				<div class="row d-md-flex d-none"><?php

					foreach ( get_field('banner_features') as $feature ) {

						?><div class="col-4 gx-30">
							<div class="rounded-3 d-flex flex-row align-items-center px-10" style="background-color: rgba(50, 48, 130, 0.40); backdrop-filter: blur(18px); height: 60px;"><?php

								echo wp_get_attachment_image( $feature['icon']['ID'], 'post-thumbnail', true, [
									'style' => 'margin-right: 5px;',
								] );

								?><div class="fs-14 text-white"><?php echo $feature['feature_name']; ?></div>
							</div>
						</div><?php

					}

				?></div>
			</div>
			<div class="col-xxl-6 d-none d-xxl-block position-relative"><?php
				echo wp_get_attachment_image( get_field('banner_image')['ID'], 'post-thumbnail', false, [
					'class' => 'w-100 h-auto',
					'sizes' => '(min-width: 1480px) 660px, (min-width: 1600px) 760px'
				] );
			?></div>
		</div>
	</div>
</section><?php

// * Top casinos section
?><section id="top-casinos">
	<div class="container mb-80">
		<h2 class="text-center mb-35 fs-24 fw-semibold text-white"><?php the_field('top_casinos_title'); ?></h2><?php

		$top_casinos = get_field('top_casinos');

		if (not_empty_array($top_casinos)) {

			?><div class="row gx-25 gy-30"><?php

				foreach ($top_casinos as $casino_index => $casino) {

					?><div class="col-xxl-6 col-12">
						<div class="bg-dark-indigo p-sm-25 p-0 casino-card h-100" id="casino<?php echo $casino_index; ?>">
							<div class="row gx-25">
								<div class="col-md-3 col-4 d-flex flex-column justify-content-between align-items-center">
									<div class="w-100"><?php

										// * Logo
										?><div class="ratio ratio-1x1 mb-15 d-none d-sm-block" style="background-color: #323082; border-radius: 10px;">
											<div class="position-cover d-flex align-items-center justify-content-center"><?php
												echo get_the_post_thumbnail( $casino, 'post-thumbnail', [
													'style' => 'max-width: 72px; max-height: 72px;'
												] );
											?></div>
										</div>
										<div class="ratio ratio-1x2 mb-15 d-block d-sm-none" style="background-color: #323082; border-radius: 10px 0 0 0;">
											<div class="position-cover d-flex align-items-center justify-content-center"><?php
												echo get_the_post_thumbnail( $casino, 'post-thumbnail', [
													'style' => 'max-width: 72px; max-height: 72px;'
												] );
											?></div>
										</div><?php

										// * Rating
										$rating = get_field('rating', $casino->ID);
										$rounded_rating = round($rating);
										$full_stars = floor($rounded_rating / 2);
										$half_star = ($rounded_rating % 2 != 0);

										?><div class="w-100 d-flex justify-content-between align-items-sm-center flex-column flex-sm-row">
											<span class="text-white fw-semibold px-10"><?php echo $rating . '/10'; ?></span><?php

											// Stars
											?><div class="d-flex px-10 star-rating"><?php

												for ($i = 1; $i <= $full_stars; $i++) {

													?><img src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>" alt=""><?php

												}

												if ($half_star) {

													?><img src="<?php echo get_template_directory_uri(  ) . '/images/half-star.svg'; ?>" alt=""><?php

												}

											?></div>
										</div>	
									</div>
									<div class="mt-15 w-100 d-none d-sm-block">
										<a class="casino-link-btn" href="<?php echo get_field('casino_link', $casino->ID); ?>"><?php _e('Visit casino', '3betup'); ?></a>
									</div>
								</div>




								<div class="col-md-9 col-8 pt-10 pe-20">
									<h3 class="text-white fs-sm-18 fs-16 fw-medium mb-15"><?php
										_e('About ', '3betup');
										echo get_the_title($casino);
										_e(' Casino', '3betup');
									?></h3><?php
										
										$features = get_field('features', $casino->ID);

										if (not_empty_array($features)) {
											?><div class="row gx-25 mb-15"><?php

												foreach ($features as $feature) {

													?><div class="col-12 d-flex align-items-center" style="margin-bottom: 12px;">
														<?php
															echo wp_get_attachment_image( $feature['icon']['ID'], 'post-thumbnail', true, [
																'style' => 'width: 24px; heigth: 24px; margin-right: 5px;'		
															] );
														?>
														<div class="fs-sm-16 fs-14" style="color: #cfcfcf;"><?php echo $feature['text']; ?></div>
													</div><?php
		
												}
	
											?></div><?php
										}

										
									

									?><div class="d-flex w-100 justify-content-between align-items-center">
										<h4 class="text-white fs-16 fw-semibold"><?php _e('Payment methods', '3betup'); ?></h4>
										<button
											class="show-payment-methods-btn"
											type="button"
											@click="toggleImages"
										>
										{{buttonText}}
										</button>
									</div>
									<div class="d-flex gap-15 flex-wrap mt-20">
										<div class="bg-deep-blue payment-method" v-for="(image, index) in displayedImages" :key="index">
											<img :src="image.url" :alt="image.alt">
										</div>
									</div>
								</div>
								<div class="my-20 col-12 w-100 d-block d-sm-none px-20">
									<a class="casino-link-btn w-100" href="<?php echo get_field('casino_link', $casino->ID); ?>"><?php _e('Visit casino', '3betup'); ?></a>
								</div>
							</div>
						</div>
					</div><?php

						$acfData = get_field('payment_methods', $casino->ID);
						$acfDataJson = json_encode($acfData);

					?><script>
						$ = jQuery;
						new Vue({
							el: '#casino<?php echo $casino_index; ?>',
							data: {
								expanded: false,
								paymentMethods: <?php echo $acfDataJson; ?>,
								initialImageCount: 6,
								images: []
							},
							created: function () {
								this.getImages();
							},
							computed: {
								displayedImages: function () {
									return this.expanded ? this.images : this.images.slice(0, this.initialImageCount);
								},
								buttonText: function () {
									return this.expanded ? 'Show less' : 'Show more';
								}
							},
							methods: {
								toggleImages: function () {
									this.expanded = !this.expanded;
								},
								getImages: function () {
									if (Array.isArray(this.paymentMethods) && this.paymentMethods.length > 0) {
										this.images = this.paymentMethods.map((image) => {
											return {
												url: image.url,
												alt: image.url
											}
										})
									}
								}
							}
						});
					</script><?php

				}

			?></div><?php

		}

	?></div>
</section>
<section id="recomendedCasinos">
	<div class="container mb-80">
		<h2 class="text-center text-white fs-md-24 fs-20 fw-semibold mb-30"><?php the_field('recomended_casinos_title'); ?></h2><?php

			$recomended_casinos = get_field('recomended_casinos');
			$recomended_casinos_json = json_encode($recomended_casinos);

			if (not_empty_array($recomended_casinos)) {

				foreach ($recomended_casinos as $casino) {

					?><div class="row mb-25 align-items-center gy-10">
						<div class="col-md-2 col-sm-6 col-12">
							<div class="d-flex align-items-center">
								
								<div style="width: 80px;" class="me-10 d-sm-block d-none">
									<a href="<?php echo get_field('casino_link', $casino->ID); ?>">
										<img src="<?php echo get_the_post_thumbnail_url( $casino, 'post-thumbnail' ); ?>" alt="" style="height: 40px; width: auto;">
									</a>
								</div>
								<div class="d-block d-sm-none me-10">
									<a href="<?php echo get_field('casino_link', $casino->ID); ?>">
										<img src="<?php echo get_the_post_thumbnail_url( $casino, 'post-thumbnail' ); ?>" alt="" style="height: 40px; width: auto;">
									</a>
								</div>
								<h3 class="fs-16 text-white fw-semibold"><?php echo get_the_title($casino); ?></h3>
							</div>
						</div>
						<div class="col-md-2 offset-md-1 col-sm-6 col-12">
							<div class="w-100 d-flex align-items-center justify-content-md-start justify-content-sm-end justify-content-start">
								<span class="text-white fw-semibold px-sm-10"><?php echo get_field('rating', $casino->ID); ?>/10</span><?php

								// Stars
								$rating = get_field('rating', $casino->ID);
								$rounded_rating = round($rating);
								$full_stars = floor($rounded_rating / 2);
								$half_star = ($rounded_rating % 2 != 0);

								?><div class="d-flex px-10 star-rating-recomended"><?php

									for ($i = 1; $i <= $full_stars; $i++) {

										?><img src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>" alt=""><?php

									}

									if ($half_star) {

										?><img src="<?php echo get_template_directory_uri(  ) . '/images/half-star.svg'; ?>" alt=""><?php

									}

								?></div>
								
							</div>
						</div>
						<div class="col-md-6 offset-md-1 col-12">
							<div class="text-white fs-sm-16 fs-14 fw-medium text-capitalize"><?php echo get_field('recomended_text', $casino->ID); ?></div>
						</div>
					</div><?php
					
				}

			}

			if (get_field('see_more_casinos')) {
				?><div class="text-center mt-45">
					<a href="<?php echo get_post_type_archive_link( 'casino' ); ?>" class="recomended-casinos-see-more-btn"><?php
						_e('See more', '3betup');
					?></a>
				</div><?php

			}
		
	?></div>
</section>
<section id="how-we-select">
	<div class="container mb-xxl-150 mb-md-80 mb-40">
		<div class="row">
			<div class="col-xxl-7 col-12">
				<h2 class="text-white fs-xxl-36 fs-md-32 fs-20 fw-semibold mb-30"><?php the_field('how_we_select_title'); ?></h2><?php

					$list = get_field('how_we_select_list');

					foreach ($list as $list_item) {

						?><div class="d-flex gap-10 align-items-center mb-40"><?php

							echo wp_get_attachment_image( $list_item['icon']['ID'], 'post-thumbnail', true, [
								'style' => 'height: 38px; width: 38px; flex-shrink: 0;'
							] );

							?><div class="text-white fs-xxl-20 fs-md-16 fs-14"><?php
								echo $list_item['text'];
							?></div>

						</div><?php

					}

			?></div>
			<div class="col-5 position-relative"><?php
				echo wp_get_attachment_image( get_field('bottom_image')['ID'], 'post-thumbnail', false, [
					'class' => 'position-cover',
					'sizes' => '(min-width: 1480px) 584px, (min-width: 1600px) 667px'
				] );
			?></div>
		</div>
	</div>
</section>
<script>
	$ = jQuery;
	new Vue({
		el: '#recomendedCasinos',
		data: {
			initialCasinoCount: 4,
			casinos: [],
		},
		created: function () {
			this.getCasinos();
		},
		computed: {
			displayedCasinos: function () {
				return this.casinos;
			},
		},
		methods: {
			getCasinos: function () {

				const endpoint = '/wp-json/wp/v2/casino?per_page=99';

				fetch(endpoint)
					.then(response => response.json())
					.then(posts => {
						this.casinos = posts;
					})
					.catch(error => {
						console.error(error);
					});
			}
		}
	});
</script><?php

get_footer();