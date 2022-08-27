<?php
$section_title = block_value( 'section-title' );
$section_color = block_value( 'section-color' );
$section_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $section_title) ); ?>

  <section class="container <?= $section_slug ?>" id="<?= $section_slug ?>" name="<?= $section_slug ?>">
  	<div class="title-container" style="border-top: 2px solid <?= $section_color ?>;">
  		<h2 style="background-color: <?= $section_color ?>;"><?php block_field( 'section-title' ); ?></h2>
  	</div>
  </section>