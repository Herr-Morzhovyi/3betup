<?php

/*
Template name: Bonuses&Tournaments
*/

get_header();

?>
<main id="bonusesAndTournaments">
	<section>
		<div class="container mt-60 mb-md-100 mb-60">
			<div class="row gy-40">
				<div class="col-xxl-6 col-12">
					<h1 class="fs-md-24 fs-20 text-pale-lavender mb-10 fw-bold text-center text-xxl-start"><?php the_title(); ?></h1>
					<div class="fs-18 mb-40 text-white text-center text-xxl-start"><?php the_content(); ?></div>
					<div class="d-flex gap-sm-20 gap-10 align-items-center justify-content-center justify-content-xxl-start w-100">
						<a href="#bonuses" class="section-links-btn"><?php _e('View Bonuses', '3betup'); ?></a>
						<a href="#tournaments" class="section-links-btn"><?php _e('Tournaments', '3betup'); ?></a>
					</div>
				</div>
				<div class="col-xxl-6 col-12">
					<div class="d-flex flex-column justify-content-end align-items-xxl-end align-items-center h-100">
						<button type="button" class="btn btn-filter" data-bs-toggle="modal" data-bs-target="#filterModal">
							<div class="d-flex align-items-center gap-10">
								<span><?php
									_e('Casino Filter', '3betup');
								?></span>
								<div class="filterCount" @click="clearFilteredCasinos()">
									<span v-if="filteredCasinos.length">{{filteredCasinos.length}}</span>
								</div>
							</div>
							
							<img src="<?php echo get_template_directory_uri(  ) . '/images/filter.svg'; ?>" alt="">
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="bonuses">
		<div class="container mb-80">
			<h2 class="text-center text-white fs-lg-24 fs-md-20 fs-18 fw-semibold mb-30"><?php the_field('bonuses_title'); ?></h2>
			<div class="row g-xxl-30 g-md-25 g-20 justify-content-center" v-if="displayedBonuses.length">
				<div class="col-xxl-4 col-md-6 col-12" v-for="bonus in displayedBonuses" v-if="bonus && typeof bonus === 'object'">
					<div class="bonus-card d-flex gap-md-25 gap-15 h-100">
						<div class="d-flex flex-column justify-content-between justify-content-md-start"><?php
							// * Logo
							?><div class="ratio ratio-2x3 mb-15 d-none d-md-block" style="background-color: #323082; border-radius: 10px; width: 120px; height: 120px;">
								<div class="position-cover d-flex align-items-center justify-content-center">
									<img :src="bonus.acfLogo_image_array[0]" alt="" class="mw-100">	
								</div>
							</div>
							<div class="ratio ratio-3x4 mb-15 d-md-none" style="background-color: #323082; border-radius: 10px; width: 100px;">
								<div class="position-cover d-flex align-items-center justify-content-center">
									<img :src="bonus.acfLogo_image_array[0]" alt="">	
								</div>
							</div>
							<div>
								<div class="d-flex star-rating-recommended w-100 justify-content-center ps-10 ps-md-0">
									<img
									v-for="i in bonus.acf.star_count"
									:key="i"
									src="<?php echo get_template_directory_uri(  ) . '/images/star.svg'; ?>"
									alt=""
									/>
								</div>
								<div class="mt-10 d-block d-md-none fs-12 text-white ps-10 text-nowrap">
									{{bonus.associatedCasinoTitle}} casino
								</div>
							</div>
						</div>
						<div class="pt-15 pt-md-0">
							<h3 class="fs-md-18 fs-16 text-white mb-20 fw-medium">{{bonus.title.rendered}}</h3>
							<div class="mb-35">
								<div class="d-flex align-items-center mb-10" style="gap: 5px;" v-for="feature in bonus.acf.features">
									<img src="<?php echo get_template_directory_uri(  ) . '/images/Package.svg'; ?>" alt="">
									<div class="text-white fs-md-16 fs-14">{{feature.feature}}</div>
								</div>
							</div>
							<div>
								<a v-bind:href="bonus.acf.claim_bonus_link" class="claim-bonus-btn"><?php _e('Claim Bonus', '3betup'); ?></a>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="text-center mt-45" v-if="displaySeeMoreBonuses === true">
				<button @click="toggleBonuses" class="recomended-casinos-see-more-btn">{{buttonTextBonus}}</button>
			</div>
		</div>
	</section>
	<section id="tournaments">
		<div class="container mb-xxl-150 mb-40">
			<h2 class="text-center text-white fs-xxl-24 fs-20 fw-semibold mb-15"><?php the_field('tournaments_title'); ?></h2>
			<div class="text-center fs-xxl-18 fs-md-16 fs-14 mb-30 text-white">
				<div class="w-75 m-auto d-none d-xxl-block"><?php
					the_field('tournaments_text');
				?></div>
				<div class="w-100 d-block d-xxl-none"><?php
					the_field('tournaments_text');
				?></div>
			</div>
			<div class="row g-xxl-30 g-md-55 g-20 justify-content-center" v-if="displayedTournaments.length">
				<div class="col-xxl-3 col-md-6 col-12" v-for="tournament in displayedTournaments" v-if="tournament && typeof tournament === 'object'">
					<div class="tournament-card h-100">
						<div class="text-center mb-15">
							<img :src="tournament.acfLogo_tournaments_image_array[0]" alt="">
						</div>
						<div class="ratio ratio-16x9 mb-10">
							<img :src="tournament.featured_image_array[0]" alt="" class="position-cover">
						</div>
						<h3 class="text-white fs-20 mb-10 fw-bold" v-if="tournament.acf.show_title == true">{{tournament.acf.title}}</h3>
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
			<div class="text-center mt-45" v-if="displaySeeMoreTournaments === true">
				<button @click="toggleTournaments" class="recomended-casinos-see-more-btn">{{buttonTextTournament}}</button>
			</div>
		</div>
	</section>
	<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="exampleModalLabel"><?php _e('Choose casino(s)', '3betup'); ?></h1>
					<button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
						<img src="<?php echo get_template_directory_uri() . '/images/close.svg'; ?>" alt="">
					</button>
				</div>
				<div class="modal-body p-0">
					<div class="d-flex flex-column w-100 gap-0">
						<div v-for="(casino, index) in casinos" class="d-flex justify-content-between align-items-center p-15">
							<div class="text-white">{{casino.title.rendered}}</div>
							<input type="checkbox" :value="index" @change="updateFilteredCasinos($event, casino)" v-model="checkedCasinos">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="d-flex w-100 justify-content-center align-items-center gap-50 py-10">
						<button @click="clearFilteredCasinos()" class="modal-btn"><?php _e('Clear Filters', '3betup'); ?></button>
						<button @click="applyFilters()" data-bs-dismiss="modal" class="modal-btn"><?php _e('Apply Filters', '3betup'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<script>
	// * Bonuses script
	new Vue({
        el: '#bonusesAndTournaments',
        data: {
            expandedBonuses: false,
            initialBonusCount: 12,
            bonuses: [],
			expandedTournaments: false,
            initialTournamentsCount: 4,
            tournaments: [],
			casinos: [],
			filteredCasinos: [],
			filteredBonuses: [],
			filteredTournaments: [],
			checkedCasinos: [],
			selectedCasinos: [],
        },
        created: function () {
			this.getCasinos();           
			this.getTournaments();
			this.getBonuses();
        },
        computed: {
            displayedBonuses: function () {
                if (this.bonuses.length > 0) {
					this.filteredBonuses = this.bonuses;
					if (this.filteredCasinos.length) {
						this.filteredBonuses = this.bonuses.filter(bonus => {
							return this.filteredCasinos.some(casino => casino.id === bonus.acf.associated_casino);
						});
					}

                    let sliceEnd = this.expandedBonuses ? this.filteredBonuses.length : Math.min(this.filteredBonuses.length, this.initialBonusCount);
                    return this.filteredBonuses.slice(0, sliceEnd);
                } else {
                    return [];
                }
            },
            buttonTextBonus: function () {
                return this.expandedBonuses ? 'See less' : 'See more';
			},
			displaySeeMoreBonuses: function () {
				if (this.filteredBonuses.length > this.initialBonusCount) {
					return true;
				} else {
					return false;
				}
			},
			displayedTournaments: function () {
                if (this.tournaments.length > 0) {
					this.filteredTournaments = this.tournaments;
					if (this.filteredCasinos.length) {
						this.filteredTournaments = this.tournaments.filter(tournament => {
							return this.filteredCasinos.some(casino => casino.id === tournament.acf.associated_casino);
						});
					}
                    let sliceEnd = this.expandedTournaments ? this.filteredTournaments.length : Math.min(this.filteredTournaments.length, this.initialTournamentsCount);
                    return this.filteredTournaments.slice(0, sliceEnd);
                } else {
                    return [];
                }
            },
            buttonTextTournament: function () {
                return this.expandedTournaments ? 'See less' : 'See more';
			},
			displaySeeMoreTournaments: function () {
				if (this.filteredTournaments.length > this.initialTournamentsCount) {
					return true;
				} else {
					return false;
				}
			},
        },
        methods: {
            toggleBonuses: function () {
                this.expandedBonuses = !this.expandedBonuses;
            },
            async getBonuses () {

				await this.getCasinos();

                const endpoint = '/wp-json/wp/v2/bonus?per_page=99';

                fetch(endpoint)
                    .then((response) => response.json())
                    .then((posts) => {
                        if (Array.isArray(posts)) {
                            this.bonuses = posts;
							posts.forEach(post => {
								let associated_casino = this.casinos.find(casino => casino.id === post.acf.associated_casino);
								if (associated_casino) {
                     			   post.associatedCasinoTitle = associated_casino.title.rendered;
								}
							});
                        } else {
                            console.error("Fetched data is not an array.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            },
			toggleTournaments: function () {
                this.expandedTournaments = !this.expandedTournaments;
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
			formatDate(dateString) {
				let year = dateString.substring(0, 4);
				let month = dateString.substring(4, 6);
				let day = dateString.substring(6, 8);

				let date = new Date(year, month - 1, day);  // month is 0-indexed

				day = date.getDate().toString().padStart(2, '0');
				month = (date.getMonth() + 1).toString().padStart(2, '0');  // month is 0-indexed

				return `${day}.${month}`;
			},
			async getCasinos() {
				const endpoint = '/wp-json/wp/v2/casino?per_page=99';

				await fetch(endpoint)
					.then((response) => response.json())
					.then((posts) => {
						if (Array.isArray(posts)) {
							this.casinos = posts;
							// this.filteredCasinos = posts;
						} else {
							console.error("Fetched data is not an array.");
						}
					})
					.catch(error => {
						console.error("Error fetching data:", error);
					});
				
			},
			updateFilteredCasinos: function (event, casino) {
				if (event.target.checked) {
					this.selectedCasinos.push({...casino});
				} else {
					const index = this.selectedCasinos.findIndex(c => c.id === casino.id);
					if (index !== -1) {
						this.selectedCasinos.splice(index, 1);
					}
				}
			},
			clearFilteredCasinos: function () {
				this.filteredCasinos = [];
				this.selectedCasinos = [];
				this.checkedCasinos = this.checkedCasinos.map(() => false);
			},
			applyFilters: function () {
				this.filteredCasinos = [...this.selectedCasinos];
			}
        }
    });

</script><?php

get_footer();