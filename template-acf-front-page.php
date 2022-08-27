<?php
/**
 * Template Name: Front Page
 *
 * @package      TTIBase
 * @author       TTI Comm
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default Genesis elements
remove_action( 'genesis_header',        'genesis_header_markup_open',         5 );
remove_action( 'genesis_header',        'genesis_do_header'                     );
remove_action( 'genesis_header',        'genesis_header_markup_close',       15 );
remove_action( 'genesis_after_header',  'genesis_do_nav'                        );
remove_action( 'genesis_after_header',  'genesis_do_subnav'                     );
remove_action( 'genesis_before_loop',   'genesis_do_breadcrumbs'                );
remove_action( 'genesis_entry_header',  'genesis_do_post_title'                 );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_open',  5  );
remove_action( 'genesis_entry_header',  'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas'           );
remove_action( 'genesis_footer',        'genesis_footer_markup_open',         5 );
remove_action( 'genesis_footer',        'genesis_do_footer'                     );
remove_action( 'genesis_footer',        'genesis_footer_markup_close',       15 );
// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
// remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Add active class for section top nav
// add_filter( 'nav_menu_css_class' , 'project_active_nav_class' , 10 , 3 );
function project_active_nav_class( $classes, $item, $args ) {
    if ( $args->menu->name === 'Projects' && strtolower($item->title) == $project_areas ) {
        $classes[] = $project_areas;
    }
    return $classes;
}


// Add the 'home' slider to the homepage
add_action( 'genesis_before_content', 'tti_home_section_slider_header' );
function tti_home_section_slider_header() {
 if ( function_exists( 'soliloquy' ) ) { ?>
 	<div class="home-slider slider"> <?php
	 	if ( soliloquy( 'home', 'slug' ) ) :
	 		soliloquy( 'home', 'slug');
	 	endif; ?>
	 </div> <?php
	}
}

add_action( 'genesis_loop', 'genesis_do_post_content', 15 );

// Do homepage content rows
add_action( 'genesis_loop', 'tti_do_home_sections' );

function tti_do_home_sections() {
	if( function_exists('have_rows') ):
		if( have_rows('content_sections') ):
			while( have_rows('content_sections') ) : the_row();
				$sectionTitle = get_sub_field('section_title');
				$sectionSlug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $sectionTitle) );
				$sectionColor = get_sub_field('section_color');

				switch ($sectionColor) {
					case "#003c71":
						$sectionColorName = "blue";
						break;

					case "#500000":
						$sectionColorName = "maroon";
						break;

					case "#fff":
						$sectionColorName = "white";
						break;

					case "#5b6236":
						$sectionColorName = "green";
						break;

					case "#4c8992":
						$sectionColorName = "teal";
						break;

					case "#744f28":
						$sectionColorName = "brown";
						break;

					case "#998542":
						$sectionColorName = "tan";
						break;

					case "#000":
						$sectionColorName = "black";
						break;

					case "#332c2c":
						$sectionColorName = "darkgrey";
						break;

					case "#707373":
						$sectionColorName = "grey";
						break;

					case "#cbcbcb":
						$sectionColorName = "lightgrey";
						break;

					case "#e1af21":
						$sectionColorName = "yellow";
						break;
				}

				$sectionHeader = get_sub_field('section_header');
				$sectionContents = get_sub_field('section_contents'); ?>

            <section class="<?= $sectionSlug ?>" id="<?= $sectionSlug ?>" name="<?= $sectionSlug ?>">
            <?php if( $sectionHeader ) : ?>
            	<div class="title-container">
            		<h2 class="bg-<?= $sectionColorName ?>"><?= $sectionTitle ?></h2>
            	</div>
            <?php endif;
	       	if( have_rows('section_contents') ) :
                while( have_rows('section_contents') ) : the_row();
                    $layout = get_row_layout();
                    $sectionContentCustom = get_row_layout('section_content_custom');
                    $contentCustom = get_sub_field('content_custom');
                    $sectionFeatured = get_row_layout('section_featured');
                    $sectionProjects = get_row_layout('section_projects');
                    $contentProjects = get_sub_field('content_projects');
                    $sectionTeams = get_row_layout('section_team');
                    // $contentTeams = get_sub_field('content_teams');
                    $teamOption = get_sub_field('team_option');
                    $sectionContentSlider = get_row_layout('section_content_slider');
                    $sliderUpload = get_sub_field('slider_upload');

		            if ( $layout === 'section_content_custom') :
		            	echo '<div class="custom-content">' . $contentCustom . '</div>';

	            	elseif ( $layout === 'section_content_slider' && $sliderUpload ) :
	            		// TODO: update classes below and add ID maybe
						echo '<div class="team-slider slider">';
						if ( function_exists( 'soliloquy' ) ) { soliloquy( 'team', 'slug' ); }
						echo '</div>';

		            elseif ( $layout === 'section_featured' ) :
		            	tti_do_featured_section();
		            elseif ( $layout === 'section_projects' && $contentProjects === true ) :
						echo do_shortcode('[tti_show_projects]');
		            elseif  ( $layout === 'section_team' ) :
		            	// tti_do_teams_section();
	            		if ( $teamOption == 'group' ) :
							// teamGroups holds nested array of all fields and subfields
							$teamGroups = get_sub_field('team_group');
							$counttab = 0;
							$countpanel = 0; ?>

							<div class="groups team-content">
								<ul class="tabs groups teams">
									<div class="subtext"><span>Meet our teams<span></div>

									<?php

									if ($teamGroups):
										foreach ($teamGroups as $teamGroup) {
											foreach ($teamGroup as $group) {
												$groupName = $group['label'];
												$groupCode = $group['value'];
												$groupCode = strtolower($groupCode);
												$counttab++; ?>

												<li class="team tab panel-<?= $groupCode ?>">
													<h3><?= $groupName ?></h3>
												</li>

												<?php
											}
										}
									endif; ?>
								</ul>

								<?php

								if ($teamGroups):

									foreach ($teamGroups as $teamGroup) {
										foreach ($teamGroup as $group) {
											$groupName = $group['label'];
											$groupCode = $group['value'];
											$groupCode = strtolower($groupCode);
											$countpanel++;

											echo '<div class="team-members panel ' . $groupCode . '">';
											echo do_shortcode( '[group_people code=' . $groupCode . ']' );
											echo'</div>';
										}
									}

								endif; ?>

								<a class="btn" href="<?php echo bloginfo( 'url' ); ?>/directory">See All</a>
							</div>
						<?php endif;
						if ( $teamOption == 'individual' && have_rows('team_individual') ) : ?>
							<div class="team-members">

							<?php while ( have_rows('team_individual') ) : the_row();
								$memberID = get_sub_field('member_id');

								if ( ! empty( $memberID ) ) :
									// $memberID = intval( $memberID );
									$memberID = @preg_replace( '/[^0-9a-z-]/i', NULL, $memberID );
									if (false === $resume = get_transient('resume-' . $memberID)) {
										$json = ttiAPI2( '/employees/resume/' . $memberID );
										$resume = json_decode( $json );
										set_transient('resume-' . $memberID, $resume, HOUR_IN_SECONDS * 24);
									}

									$displayBio = $resume->INTERNET_RESUME_ID; // returns Y or N for resume Bio
									$employment_status = $resume->EMPLOYMENT_STATUS;

									if ( $employment_status == 'Retired' || $employment_status == 'Terminated' || $employment_status == 'Deceased' || $employment_status == 'Leave without Pay' || $employment_status == 'Temporary' ) {
										return;
									}

									if ( ! is_object($resume) ) {
										echo 'No TTI person API object returned.';
										return;
									}

									$resume_name           = $resume->NAME;
									$resume_email          = $resume->EMAIL;
									$resume_phone          = $resume->PHONE;
									// Do not display "x" if an extension is not available
									if ( 'x' == substr($resume_phone, -1) ) {
										$resume_phone = substr_replace($resume_phone, '', -1);
									}

									$resume_job_title = '';
									$job_titles = $resume->JOB_TITLE;
									$num_titles = count($resume->JOB_TITLE);
									if ( 1 == $num_titles ) {

										if ( $resume->JOB_TITLE[0]->TITLE_DESCRIPTION ) {
											$resume_job_title .= $resume->JOB_TITLE[0]->TITLE_DESCRIPTION;
										}

									} elseif ( 1 < $num_titles ) {
										$which_title = 0;
										foreach( $job_titles as $job_title ) {
											$resume_job_title .= $resume->JOB_TITLE[$which_title]->TITLE_DESCRIPTION;
											if ( $which_title + 1 < $num_titles ) {
												$resume_job_title .= ', ';
											}
											$which_title++;
										}
									}
									unset($job_title);
									unset($which_title);

									$resume_short_bio = $resume->SHORT_BIOGRAPHY;
									$resume_encoded_bio = $resume->HtmlEncodedBiography; ?>

									<div class="member">
										<h3><a href="https://tti.tamu.edu/people/resume/?id=<?= $memberID ?>"><?= $resume_name ?></a></h3>
										<p class="member-title"><?= $resume_job_title ?></p>
										<a class="team-email" href="mailto:<?php echo $resume_email; ?>"><?php echo $resume_email; ?></a>
										<?php if ( $resume_phone ) : ?>
											<p><?php echo $resume_phone; ?></p>
										<?php endif; ?>
									</div>

								<?php endif;
							endwhile; ?>
							</div>
						<?php endif;
		            endif;
		        endwhile;
		    endif; ?>
		    </section>
		<?php endwhile;
	endif;
	endif;
}

function tti_do_featured_section() {

if ( have_rows('content_featured') ) : ?>
		<?php while ( have_rows('content_featured') ) : the_row(); ?>
			<div class="featured">

			<?php $peopleID = get_sub_field('people_ID');
			$featuredPhoto = get_sub_field('featured_photo');
			$featuredBio = get_sub_field('featured_bio');

			if ( ! empty( $peopleID ) ) :
				$peopleID = intval( $peopleID );

				if (false === $resume = get_transient('resume-' . $peopleID)) {
					$json = ttiAPI2( '/employees/resume/' . $peopleID );
					$resume = json_decode( $json );
					set_transient('resume-' . $peopleID, $resume, HOUR_IN_SECONDS * 24);
				}

				$displayBio = $resume->INTERNET_RESUME_ID; // returns Y or N for resume Bio
				$employment_status = $resume->EMPLOYMENT_STATUS;

				if ( $employment_status == 'Retired' || $employment_status == 'Terminated' || $employment_status == 'Deceased' || $employment_status == 'Leave without Pay' || $employment_status == 'Temporary' ) {
					return;
				}

				if ( ! is_object($resume) ) {
					echo 'No TTI person API object returned.';
					return;
				}

				$resume_id             = $peopleID;
				$resume_name           = $resume->NAME;
				$resume_email          = $resume->EMAIL;
				$resume_phone          = $resume->PHONE;
				// Do not display "x" if an extension is not available
				if ( 'x' == substr($resume_phone, -1) ) {
					$resume_phone = substr_replace($resume_phone, '', -1);
				}

				$resume_job_title = '';
				$job_titles = $resume->JOB_TITLE;
				$num_titles = count($resume->JOB_TITLE);
				if ( 1 == $num_titles ) {

					if ( $resume->JOB_TITLE[0]->TITLE_DESCRIPTION ) {
						$resume_job_title .= $resume->JOB_TITLE[0]->TITLE_DESCRIPTION;
					}

				} elseif ( 1 < $num_titles ) {
					$which_title = 0;
					foreach( $job_titles as $job_title ) {
						$resume_job_title .= $resume->JOB_TITLE[$which_title]->TITLE_DESCRIPTION;
						if ( $which_title + 1 < $num_titles ) {
							$resume_job_title .= ', ';
						}
						$which_title++;
					}
				}
				unset($job_title);
				unset($which_title);

				$resume_short_bio = $resume->SHORT_BIOGRAPHY;
				$resume_encoded_bio = $resume->HtmlEncodedBiography; ?>


				<div class="person-portrait">
					<?php if ( !empty( $featuredPhoto ) ) { ?>
						<img class="size-small" alt="<?= $resume_name ?>" src="<?= $featuredPhoto ?>" />
						<?php
					} else if ( !empty( $resume_name ) && $resume->DisplayPhoto ) {
						echo '<img alt="' . $resume_name . '" src="data:image/jpeg;base64,' . base64_encode( ttiAPI2( '/Employees/Image/PID/' . $resume_id ) ) . '" />';
					} ?>
				</div>

				<div class="member" style="width: 100%;">
					<h3 class="featured-name"><?= $resume_name ?></h3>
					<p class="featured-title"><?= $resume_job_title ?></p>
					<?php if ( $featuredBio ) : ?>
						<p><?= $featuredBio ?></p>
					<?php elseif ( !empty( $resume_short_bio ) ) : ?>
						<p><?php echo $resume_short_bio ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
<?php endif;
}

/**
 * Add the 'team' section to the homepage with (optional) slider div and team/team members section content
 * see API callback @ https://github.tamu.edu/TTI-KAC/ttigroups-wpengine/blob/master/wp-content/themes/tti-main/page_resume.php
 */
function tti_do_teams_section() {

}

genesis();