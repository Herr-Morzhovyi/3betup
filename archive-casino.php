<?php

get_header();

?><section>
	<div class="container">
		<div class="row gx-120 align-items-center mt-10">
			<div class="col-6">
				<h1 class="fs-24 text-pale-lavender mb-10 fw-bold"><?php echo get_field('page_title', 'option'); ?></h1>
				<p class="fs-18 mb-40" style="color: #d4d3d3; line-heigth: 152.5%;"><?php echo strip_tags(get_field('page_content', 'option')); ?></p>
			</div>
			<div class="col-6 position-relative"><?php
				echo wp_get_attachment_image( get_field('page_decoration_image', 'option')['ID'], 'post-thumbnail', false, [
					'class' => 'w-100 h-auto'
				] );
			?></div>
		</div>
	</div>
</section>
<section id="casinosArchive">
	<div class="container mb-150" v-if="displayedCasinos.length">
		<h2 class="text-center text-white fs-24 fw-semibold mb-30"><?php _e('Recomended Casinos', '3betup'); ?></h2>
		<div class="row mb-25 align-items-center" v-for="casino in displayedCasinos" v-if="casino && typeof casino === 'object'">
			<div class="col-2">
				<div class="d-flex align-items-center">
					
					<div style="width: 80px; margin-right: 10px;">
						<a v-bind:href="casino.acf.casino_link">
							<img :src="casino.featured_image_array[0]" alt="" style="height: 40px; width: auto;">
						</a>
					</div>
					<h3 class="fs-16 text-white fw-semibold">{{casino.title.rendered}}</h3>
				</div>
			</div>
			<div class="col-2 offset-1">
				<div class="w-100 d-flex align-items-center">
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
			<div class="col-6 offset-1">
				<div class="text-white fs-16 fw-medium text-capitalize">{{casino.acf.recomended_text}}</div>
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
				return this.displayedCasinos.map(casino => {
					return {
						fullStars: Math.floor(casino.rating / 2),
						hasHalfStar: 1.5 >= casino.rating % 2 > 0,
						roundedToFullStar: casino.rating % 2 > 1.5
					};
				});
			},
        }
    });
</script>

<?php
get_footer();