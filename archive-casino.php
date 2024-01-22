<?php

get_header();

?><section>
	<div class="container px-xxl-60">
		<div class="row gx-xxl-120 align-items-center mt-xxl-10 mt-60 mb-md-60 mb-40 mb-xxl-0">
			<div class="col-xxl-6 col-12 text-center text-xxl-start px-40">
				<h1 class="fs-md-24 fs-18 text-pale-lavender mb-10 fw-bold"><?php echo get_field('page_title', 'option'); ?></h1>
				<p class="fs-md-18 fs-14 mb-xxl-40" style="color: #d4d3d3; line-heigth: 152.5%;"><?php echo strip_tags(get_field('page_content', 'option')); ?></p>
			</div>
			<div class="col-xxl-6 d-none d-xxl-block position-relative"><?php
				echo wp_get_attachment_image( get_field('page_decoration_image', 'option')['ID'], 'post-thumbnail', false, [
					'class' => 'w-100 h-auto'
				] );
			?></div>
		</div>
	</div>
</section>
<section id="casinosArchive">
	<div class="container mb-xxl-150 mb-60" v-if="displayedCasinos.length">
		<h2 class="text-center text-white fs-md-24 fs-sm-20 fs-18 fw-semibold mb-30"><?php _e('Recomended Casinos', '3betup'); ?></h2>
		<div class="row mb-25 align-items-center gy-10" v-for="casino in displayedCasinos" v-if="casino && typeof casino === 'object'">
			<div class="col-md-2 col-sm-6 col-12">
				<div class="d-flex align-items-center">
					
					<div style="width: 80px; margin-right: 10px;">
						<a v-bind:href="casino.acf.casino_link">
							<img :src="casino.featured_image_array[0]" alt="" style="height: 40px; width: auto;">
						</a>
					</div>
					<h3 class="fs-16 text-white fw-semibold">{{casino.title.rendered}}</h3>
				</div>
			</div>
			<div class="col-md-2 offset-md-1 col-sm-6 col-12">
				<div class="w-100 d-flex align-items-center justify-content-md-start justify-content-sm-end justify-content-start">
					<span class="text-white fw-semibold px-10">{{ casino.acf.rating }}/10</span>

					<!-- Stars -->
					<div class="d-flex px-10 star-rating-recommended">
						<img
						v-for="i in getStarCounts(casino).fullStars"
						:key="i"
						src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>"
						alt=""
						/>
						<img
						v-if="getStarCounts(casino).hasHalfStar"
						src="<?php echo get_template_directory_uri(  ) . '/images/half-star.svg'; ?>"
						alt=""
						/>
						<img
						v-if="getStarCounts(casino).roundedToFullStar"
						src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>"
						alt=""
						/>
					</div>
				</div>
			</div>
			<div class="col-md-6 offset-md-1 col-12">
				<div class="text-white fs-md-16 fs-14 fw-medium text-capitalize">{{casino.acf.recomended_text}}</div>
			</div>
		</div>
		<div class="text-center mt-45" v-if="displaySeeMore === true">
			<button @click="toggleCasinos" class="recomended-casinos-see-more-btn">{{buttonText}}</button>
		</div>
	</div>
</section>


<script>
    $ = jQuery;
    new Vue({
        el: '#casinosArchive',
        data: {
            expanded: false,
            initialCasinoCount: 10,
            casinos: [],
        },
        created: function () {
            this.getCasinos();
        },
        computed: {
            displayedCasinos: function () {
                if (this.casinos.length > 0) {
                    let sliceEnd = this.expanded ? this.casinos.length : Math.min(this.casinos.length, this.initialCasinoCount);
                    return this.casinos.slice(0, sliceEnd);
                } else {
                    return [];
                }
            },
            buttonText: function () {
                return this.expanded ? 'See less' : 'See more';
			},
			displaySeeMore: function () {
				if (this.casinos.length > this.initialCasinoCount) {
					return true;
				} else {
					return false;
				}
			}
        },
        mounted() {
        },
        methods: {
            toggleCasinos: function () {
                this.expanded = !this.expanded;
            },
            getCasinos: function () {
                const endpoint = '/wp-json/wp/v2/casino';

                fetch(endpoint)
                    .then((response) => response.json())
                    .then((posts) => {
                        if (Array.isArray(posts)) {
                            this.casinos = posts;
                        } else {
                            console.error("Fetched data is not an array.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            },
			getStarCounts(casino) {
				let fullStars = Math.floor(casino.acf.rating / 2);
    			fullStars = Number.isInteger(fullStars) && fullStars > 0 ? fullStars : 0;
				return {
					fullStars: fullStars,
					hasHalfStar: 1.5 >= casino.acf.rating % 2 > 0,
					roundedToFullStar: casino.acf.rating % 2 > 1.5
				};
				
			},
        }
    });
</script>

<?php
get_footer();