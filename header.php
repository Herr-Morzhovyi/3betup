<?php

get_template_part('parts/header', 'system'); ?>

<body <?php body_class(); ?>><?php
	
	?><header id="header" class="w-100 bg-dark-indigo px-0">
		<div class="d-flex flex-row justify-content-xxl-start justify-content-between gap-30 align-items-center container"><?php

			get_template_part('parts/header', 'logo');

			get_template_part('parts/header', 'menu');


		?></div>
	</header>