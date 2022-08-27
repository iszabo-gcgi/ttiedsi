<?php

if ( function_exists( 'soliloquy' ) ) { ?>
 	<div class="<?php block_field( 'slider' ); ?>-slider slider"> <?php
	 	soliloquy( block_field( 'slider' ), 'slug' ); ?>
	 </div> <?php
	}

?>