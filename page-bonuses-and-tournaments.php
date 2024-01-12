<?php

/*
Template name: Bonuses&Tournaments
*/

get_header();

?><section>
	<div class="container mt-60 mb-100">
		<div class="row">
			<div class="col-6">
				<h1 class="fs-24 text-pale-lavender mb-10 fw-bold"><?php the_title(); ?></h1>
				<div class="fs-18 mb-40 text-white"><?php the_content(); ?></div>
				<div class="d-flex gap-20 align-items-center">
					<a href="#bonuses" class="section-links-btn"><?php _e('View Bonuses', '3betup'); ?></a>
					<a href="#tournaments" class="section-links-btn"><?php _e('Tournaments', '3betup'); ?></a>
				</div>
			</div>
			<div class="col-6">
				<div class="d-flex flex-column justify-content-end align-items-end h-100">
					<button type="button" class="btn btn-filter" data-bs-toggle="modal" data-bs-target="#filterModal">
						<span><?php
							_e('Casino Filter', '3betup');
						?></span>
						<img src="<?php echo get_template_directory_uri(  ) . '/images/filter.svg'; ?>" alt="">
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="bonuses">
	<div class="container mb-80">
		<h2 class="text-center text-white fs-24 fw-semibold mb-30"><?php the_field('bonuses_title'); ?></h2>
		<div class="row g-30 justify-content-center" v-if="displayedBonuses.length">
			<div class="col-4" v-for="bonus in displayedBonuses" v-if="bonus && typeof bonus === 'object'">
				<div class="bonus-card d-flex gap-25">
					<div><?php
						// * Logo
						?><div class="ratio ratio-1x1 mb-15" style="background-color: #323082; border-radius: 10px; width: 120px; height: 120px;">
							<div class="position-cover d-flex align-items-center justify-content-center">
								<img :src="bonus.acfLogo_image_array[0]" alt="">	
							</div>
						</div>
						<div class="d-flex star-rating-recommended w-100 justify-content-center">
							<img
							v-for="i in bonus.acf.star_count"
							:key="i"
							src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>"
							alt=""
							/>
						</div>
					</div>
					<div>
						<h3 class="fs-18 text-white mb-20 fw-medium">{{bonus.title.rendered}}</h3>
						<div class="mb-35">
							<div class="d-flex align-items-center mb-10" style="gap: 5px;" v-for="feature in bonus.acf.features" :key="feature">
								<img src="<?php echo get_template_directory_uri(  ) . '/images/Package.svg'; ?>" alt="">
								<div class="text-white fs-16">{{feature.feature}}</div>
							</div>
						</div>
						<div>
							<a v-bind:href="bonus.acf.claim_bonus_link" class="claim-bonus-btn"><?php _e('Claim Bonus', '3betup'); ?></a>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="text-center mt-45" v-if="displaySeeMore === true">
			<button @click="toggleBonuses" class="recomended-casinos-see-more-btn">{{buttonText}}</button>
		</div>
	</div>
</section>
<section id="tournaments">
	<div class="container mb-150">
		<h2 class="text-center text-white fs-24 fw-semibold mb-15"><?php the_field('tournaments_title'); ?></h2>
		<div class="text-center fs-18 mb-30 text-white">
			<div class="w-75 m-auto"><?php
				the_field('tournaments_text');
			?></div>
		</div>
		<div class="row g-30 justify-content-center" v-if="displayedTournaments.length">
			<div class="col-3" v-for="tournament in displayedTournaments" v-if="tournament && typeof tournament === 'object'">
				<div class="tournament-card">
					<div class="text-center mb-15">
						<img :src="tournament.acfLogo_tournaments_image_array[0]" alt="">
					</div>
					<div class="ratio ratio-16x9 mb-10">
						<img :src="tournament.featured_image_array[0]" alt="" class="position-cover">
					</div>
					<div class="text-white fs-18 mb-10 fw-medium">
						{{formatDate(tournament.acf.duration_start)}} - {{formatDate(tournament.acf.duration_end)}}
					</div>
					<div class="text-white fw-semibold mb-25">
						{{tournament.acf.text}}
					</div>
					<div>
						<a v-bind:href="tournament.acf.tournament_link" class="tournament-btn"><?php _e('Join Now', '3betup'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center mt-45" v-if="displaySeeMore === true">
			<button @click="toggleTournaments" class="recomended-casinos-see-more-btn">{{buttonText}}</button>
		</div>
	</div>
</section>
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><?php _e('Choose casino(s)', '3betup'); ?></h1>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
			<img src="<?php echo get_template_directory_uri() . '/images/close.svg'; ?>" alt="">
		</button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<script>
	// * Bonuses script
	new Vue({
        el: '#bonuses',
        data: {
            expanded: false,
            initialBonusCount: 9,
            bonuses: [],
        },
        created: function () {
            this.getBonuses();
        },
        computed: {
            displayedBonuses: function () {
                if (this.bonuses.length > 0) {
                    let sliceEnd = this.expanded ? this.bonuses.length : Math.min(this.bonuses.length, this.initialBonusCount);
                    return this.bonuses.slice(0, sliceEnd);
                } else {
                    return [];
                }
            },
            buttonText: function () {
                return this.expanded ? 'See less' : 'See more';
			},
			displaySeeMore: function () {
				if (this.bonuses.length > this.initialBonusCount) {
					return true;
				} else {
					return false;
				}
			}
        },
        methods: {
            toggleBonuses: function () {
                this.expanded = !this.expanded;
            },
            getBonuses: function () {
                const endpoint = '/wp-json/wp/v2/bonus?per_page=99';

                fetch(endpoint)
                    .then((response) => response.json())
                    .then((posts) => {
                        if (Array.isArray(posts)) {
                            this.bonuses = posts;
                        } else {
                            console.error("Fetched data is not an array.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            }
        }
    });

	// * Tournaments script
	new Vue({
        el: '#tournaments',
        data: {
            expanded: false,
            initialTournamentsCount: 4,
            tournaments: [],
        },
        created: function () {
            this.getTournaments();
        },
        computed: {
            displayedTournaments: function () {
                if (this.tournaments.length > 0) {
                    let sliceEnd = this.expanded ? this.tournaments.length : Math.min(this.tournaments.length, this.initialTournamentsCount);
                    return this.tournaments.slice(0, sliceEnd);
                } else {
                    return [];
                }
            },
            buttonText: function () {
                return this.expanded ? 'See less' : 'See more';
			},
			displaySeeMore: function () {
				if (this.tournaments.length > this.initialTournamentsCount) {
					return true;
				} else {
					return false;
				}
			}
        },
        methods: {
            toggleTournaments: function () {
                this.expanded = !this.expanded;
            },
            getTournaments: function () {
                const endpoint = '/wp-json/wp/v2/tournament?per_page=99';

                fetch(endpoint)
                    .then((response) => response.json())
                    .then((posts) => {
                        if (Array.isArray(posts)) {
                            this.tournaments = posts;
                        } else {
                            console.error("Fetched data is not an array.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            },
			formatDate(unixTimestamp) {
				const date = new Date(unixTimestamp * 1000);
				const day = date.getDate().toString().padStart(2, '0');
				const month = (date.getMonth() + 1).toString().padStart(2, '0');
				return `${day}.${month}`;
			}
        }
    });
</script><?php

get_footer();