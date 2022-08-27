<?php

// -------------------------------------------------------
// FROM API. Was formerly from Oracle
// -------------------------------------------------------

function tti_api_shortcode_group_people( $atts ) {
	$a = shortcode_atts( array(
		'code' => '',
		'search' => 'false'
	), $atts );

	$code = $a['code'];
	$search = $a['search'];

	if ( 'false' !=  $search ) {
		wp_enqueue_script('uitablefilter');
	}

	$output = '';

	$multiple_groups = false;
	$contains_multiple = strpos( $code , ',' );

	if ( false !== $contains_multiple ) {

		$no_spaces = str_replace( ' ', '', $code );
		$group_codes = explode( ',', $no_spaces );

		function cmp($a, $b) {
			return strcmp($a->LNAME, $b->LNAME);
		}

		$employees_multiple_groups = array();
		foreach( $group_codes as $group_code ) {

			if ( '' != $group_code && 3 == strlen($group_code) ) {
				$json = ttiAPI2( "/employees/program/{$group_code}/TRUE" );
				$employees = json_decode($json);
				if ( $employees && count($employees) > 0 ) {
					foreach( $employees as $employee ) {
						$single_employee = new stdClass();
						$single_employee->PERSON_ID = $employee->PERSON_ID;
						$single_employee->FIRST_NAME = $employee->FIRST_NAME;
						$single_employee->LNAME = $employee->LNAME;
						$single_employee->EMAIL = $employee->EMAIL;
						$single_employee->NUM = $employee->NUM;
						$single_employee->AREA_CODE = $employee->AREA_CODE;
						$single_employee->EXTENSION = $employee->EXTENSION;
						$single_employee->TITLE_DESCRIPTION = $employee->TITLE_DESCRIPTION;
						$employees_multiple_groups[] = $single_employee;
					}
				}
			}
		}
		usort( $employees_multiple_groups, "cmp" );

		if ( 'false' !=  $search ) {
			$output .= '<div class="quicksearch">';
			$output .= '<form id="filter-form">';
			$output .= '<h4 style="margin:0 0 5px 0;">Quick Search</h4>';
			$output .= '<input name="filter" id="filter" value="" maxlength="30" size="30" type="text">';
			$output .= '</form>';
			$output .= '<p style="font-size: 11px; color: #666; margin-top: 2px; font-style:italic">Begin typing name.</p>';
			$output .= '</div>';
		}

		$output .= '<table class="searchable table table-people">';
		$output .= '<thead><tr><th>Name</th><th>E-mail</th><th>Phone</th><th>Job Title</th></tr></thead>';
		$output .= '<tbody>';

		foreach( $employees_multiple_groups as $employee ) {
			$output .= '<tr>';
			$output .= '<td><a href="//tti.tamu.edu/people/resume.htm?pid=' . $employee->PERSON_ID . '" class="resume-link">' . $employee->FIRST_NAME . ' ' . $employee->LNAME . '</a></td>';
			$output .= '<td><a href="mailto:' . $employee->EMAIL . '" class="email-link">' . strtolower($employee->EMAIL) . '</a></td>';
			if ( $employee->NUM ) {
				$phone_num = $employee->AREA_CODE ? "({$employee->AREA_CODE}) " : "(979) ";
				$phone_num .= substr( $employee->NUM, 0, 3 ) . '-' . substr( $employee->NUM, 3, 4 );
				$phone_num .= $employee->EXTENSION ? " x" . $employee->EXTENSION : " x" . substr( $employee->NUM, 2, 5 );
				$output .= '<td>' . $phone_num . '</td>';
			} else {
				$output .= '<td>&nbsp;</td>';
			}
			$output .= '<td>' . $employee->TITLE_DESCRIPTION . '</td>';
			$output .= '</tr>';
		}

		$output .= '</tbody>';
		$output .= '</table>';


	} else {

		if ( '' != $code && 3 == strlen($code) ) {
			if (false === $employees = get_transient('group-people-' . $code)) {
				$json = ttiAPI2( "/employees/program/{$code}/TRUE" );
				$employees = json_decode($json);
				set_transient('group-people-' . $code, $employees, HOUR_IN_SECONDS * 24);
			}
			if ( $employees && count($employees) > 0 ) {
				if ( 'false' !=  $search ) {
					$output .= '<div class="quicksearch">';
					$output .= '<form id="filter-form">';
					$output .= '<h4 style="margin:0 0 5px 0;">Quick Search</h4>';
					$output .= '<input name="filter" id="filter" value="" maxlength="30" size="30" type="text">';
					$output .= '</form>';
					$output .= '<p style="font-size: 11px; color: #666; margin-top: 2px; font-style:italic">Begin typing name.</p>';
					$output .= '</div>';
				}

				if ( is_front_page() ) :
					$output .= '<div class="searchable table table-people">';
					// // $output .= '<thead><tr><th>Name</th><th>E-mail</th><th>Phone</th><th>Job Title</th></tr></thead>';
					$output .= '<div>';

					foreach( $employees as $employee ) {
						$output .= '<div class="member">';
						$output .= '<a href="//tti.tamu.edu/people/resume.htm?pid=' . $employee->PERSON_ID . '" class="resume-link"><p class="member-name">' . $employee->FIRST_NAME . ' ' . $employee->LNAME . '</p></a>';
						$output .= '<p class="member-title">' . $employee->TITLE_DESCRIPTION . '</p>';
						$output .= '<a class="team-email" href="mailto:' . $employee->EMAIL . '" class="email-link">' . strtolower($employee->EMAIL) . '</a>';
						if ( $employee->NUM ) :
							$phone_num = $employee->AREA_CODE ? "({$employee->AREA_CODE}) " : "(979) ";
							$phone_num .= substr( $employee->NUM, 0, 3 ) . '-' . substr( $employee->NUM, 3, 4 );
							$phone_num .= $employee->EXTENSION ? " x" . $employee->EXTENSION : " x" . substr( $employee->NUM, 2, 5 );
							if ( $phone_num ) :
								$output .= '<p class="team-email">' . $phone_num . '</p>';
							endif;
						endif;
						$output .= '</div>';
					}

					$output .= '</div>';
					$output .= '</div>';

				else :

					$output .= '<table class="searchable table table-people">';
					$output .= '<thead><tr><th>Name</th><th>Job Title</th><th>E-mail</th><th>Phone</th></tr></thead>';
					$output .= '<tbody>';

					foreach( $employees as $employee ) {
						$output .= '<tr class="member">';
						$output .= '<td><a href="//tti.tamu.edu/people/resume.htm?pid=' . $employee->PERSON_ID . '" class="resume-link"><p>' . $employee->FIRST_NAME . ' ' . $employee->LNAME . '</p></a></td>';
						$output .= '<td class="member-title">' . $employee->TITLE_DESCRIPTION . '</td>';
						$output .= '<td><a class="team-email" href="mailto:' . $employee->EMAIL . '" class="email-link">' . strtolower($employee->EMAIL) . '</a></td>';
						if ( $employee->NUM ) {
							$phone_num = $employee->AREA_CODE ? "({$employee->AREA_CODE}) " : "(979) ";
							$phone_num .= substr( $employee->NUM, 0, 3 ) . '-' . substr( $employee->NUM, 3, 4 );
							$phone_num .= $employee->EXTENSION ? " x" . $employee->EXTENSION : " x" . substr( $employee->NUM, 2, 5 );
							$output .= '<td class="team-email">' . $phone_num . '</td>';
						} else {
							$output .= '<td></td>';
						}
						$output .= '</tr>';
					}

					$output .= '</tbody>';
					$output .= '</table>';

				endif;
			}
		}
	}
	return $output;
}
add_shortcode( 'group_people', 'tti_api_shortcode_group_people' );


// coming soon; avoid error
function tti_add_group_contact_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'code' => '',
		'name' => '',
		'image' => '',
	), $atts );

	$code = $a['code'];
	$use_name = $a['name'];
	$use_image = $a['image'];
	$output = '';

	if ( '' != $code && 3 == strlen($code) ) {
		$json = ttiAPI2( "/organizations/{$code}/contacts" );
		$contacts = json_decode($json);

		if ( $contacts && count($contacts) > 0 ) {

			foreach ( $contacts as $contact ) {
				$person_id = $contact->Id;

				$resume_json = ttiAPI2( '/employees/resume/' . $person_id );
				$resume = json_decode( $resume_json );

				$contact_name = $resume->NAME;
				$portrait = tti_get_api_portrait( $contact_name, $person_id );

				if ( '' != $portrait && "true" == $use_image ) {
					$output .= '<div class="portrait wp-caption alignright">';
					$output .= $portrait;
					$output .= '<p class="wp-caption-text">' . $contact_name . '</p>';
					$output .= '</div>';
				}

				$output .= '<address>';
				if ( "true" == $use_name ) { $output .= '<strong>' . $contact_name  . '</strong><br />'; }
				$output .= $resume->ADDRESS->STREET_LINE_1 . '<br />';
				if ( '' != $resume->ADDRESS->STREET_LINE_4 ) {
					$output .= $resume->ADDRESS->STREET_LINE_4 . '<br />';
				}
				$output .= $resume->ADDRESS->City . ', ' . $resume->ADDRESS->STATE_CODE . ' ' .$resume->ADDRESS->ZIP . '<br />';
				$output .= $resume->PHONE;
				// if ( $response["FAX_NUM"] != "" ) {
				// 	$output .= " &middot; fax " . $response["FAX_NUM"];
				// }
				$output .= '<br />';
				$output .= '<a href="mailto:' . $resume->EMAIL . '">' . $resume->EMAIL . '</a></address>';
			}
		}
	}
	return $output;
}
add_shortcode( 'group_contact', 'tti_add_group_contact_shortcode' );


/**
 * Get portrait from api.tti.tamu.edu
 *
 * @since 4.4.0
 */
function tti_get_api_portrait( $name, $person_id ) {
	if ( $name && $person_id ) {
		return '<img src="data:image/jpeg;base64,' . base64_encode( ttiAPI2( '/Employees/Image/PID/' . $person_id ) ) . '" alt="' . $name . '" class="portrait" />';
	} else {
		return '';
	}
}

/**
 * api.tti.tamu.edu portrait shortcode
 *
 * @since 3.0.0
 * @param array $atts
 * @return string
 */
function tti2018_return_employee_portrait_from_api( $atts ) {
  extract( shortcode_atts( array(
    'pid' => '',
    'class' => '',
    'alt' => '',
    'caption' => '',
  ), $atts ) );

  $output = '';

  if ( empty( $pid ) ) { return; }

  if ( '' !== $caption ) {
    $has_caption = true;
    $output .= '<figure class="wp-caption ' . $class . '">';
    $output .= '<img src="data:image/jpeg;base64,' . base64_encode( ttiAPI2( '/Employees/Image/PID/' . $pid ) ) . '" alt="' . $alt . '" class="size-full" />';
    $output .= '<figcaption class="wp-caption-text">' . $caption . '</figcaption>';
    $output .= '</figure>';
  } else {
    $output .= '<img src="data:image/jpeg;base64,' . base64_encode( ttiAPI2( '/Employees/Image/PID/' . $pid ) ) . '" alt="' . $alt . '" class="' . $class . '"  />';
  }

  return $output;
}
if ( false === (shortcode_exists('portraits')) ) {
  add_shortcode( 'portrait', 'tti2018_return_employee_portrait_from_api' );
}
