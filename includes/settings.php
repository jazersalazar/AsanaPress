<?php

add_action( 'admin_menu', 'asanawp_menu_page' );
function asanawp_menu_page() {

	add_options_page(
		'AsanaWP', // page <title>Title</title>
		'AsanaWP', // menu link text
		'manage_options', // capability to access the page
		'asanawp', // page URL slug
		'asanawp_setup', // callback function /w content
	);

}

function asanawp_setup(){

	echo '<div class="wrap">
	<h1>AsanaWP Settings</h1>
	<form method="post" action="options.php">';

		settings_fields( 'asanawp_settings' ); // settings group name
		do_settings_sections( 'asanawp' ); // just a page slug
		submit_button();

	echo '</form></div>';

}

add_action( 'admin_init',  'asanawp_register_setting' );
function asanawp_register_setting(){

	global $client;

	add_settings_section(
		'some_settings_section_id', // section ID
		'', // title (if needed)
		'', // callback function (if needed)
		'asanawp' // page slug
	);

	register_setting(
		'asanawp_settings', // settings group name
		'asanawp_pat', // option name
		'sanitize_text_field' // sanitization function
	);

	add_settings_field(
		'asanawp_pat',
		'Personal Access Token',
		'asanawp_pat', // function which prints the field
		'asanawp', // page slug
		'some_settings_section_id', // section ID
		array( 
			'label_for' => 'asanawp_pat',
			'class' => 'asanawp', // for <tr> element
		)
	);

	$asanawp_pat = get_option( 'asanawp_pat' );
	if ( !$asanawp_pat ) {
		return;
	}
	$client = Asana\Client::accessToken( $asanawp_pat );

	register_setting(
		'asanawp_settings', // settings group name
		'asanawp_workspace', // option name
		'sanitize_text_field' // sanitization function
	);

	add_settings_field(
		'asanawp_workspace',
		'Workspace',
		'asanawp_workspace', // function which prints the field
		'asanawp', // page slug
		'some_settings_section_id', // section ID
		array( 
			'label_for' => 'asanawp_workspace',
			'class' => 'asanawp', // for <tr> element
		)
	);

	$asanawp_workspace = get_option( 'asanawp_workspace' );
	if ( !$asanawp_workspace ) {
		return;
	}

	register_setting(
		'asanawp_settings', // settings group name
		'asanawp_project', // option name
		'sanitize_text_field' // sanitization function
	);

	add_settings_field(
		'asanawp_project',
		'Project',
		'asanawp_project', // function which prints the field
		'asanawp', // page slug
		'some_settings_section_id', // section ID
		array( 
			'label_for' => 'asanawp_project',
			'class' => 'asanawp', // for <tr> element
		)
	);

	$asanawp_project = get_option( 'asanawp_project' );
	if ( !$asanawp_project ) {
		return;
	}

	register_setting(
		'asanawp_settings', // settings group name
		'asanawp_section', // option name
		'sanitize_text_field' // sanitization function
	);

	add_settings_field(
		'asanawp_section',
		'Project',
		'asanawp_section', // function which prints the field
		'asanawp', // page slug
		'some_settings_section_id', // section ID
		array( 
			'label_for' => 'asanawp_section',
			'class' => 'asanawp', // for <tr> element
		)
	);

}

function asanawp_pat(){

	$asanawp_pat = get_option( 'asanawp_pat' );

	printf(
		'<input type="text" id="asanawp_pat" name="asanawp_pat" value="%s" />',
		esc_attr( $asanawp_pat )
	);

}

function asanawp_workspace() {

	global $client;

	$asanawp_workspace = get_option( 'asanawp_workspace' );

	$workspaces = $client->workspaces->getWorkspaces();

	echo '<select id="asanawp_workspace" name="asanawp_workspace">';
	foreach ($workspaces as $workspace) {
		echo '<option value="' . $workspace->gid . '" ' . ( $asanawp_workspace !== $workspace->gid ?: 'selected' ) . '>' . $workspace->name . '</option>';
	}
	echo '</select>';

}

function asanawp_project() {

	global $client;

	$asanawp_workspace = get_option( 'asanawp_workspace' );
	$asanawp_project = get_option( 'asanawp_project' );

	$projects = $client->projects->getProjectsForWorkspace( $asanawp_workspace );

	echo '<select id="asanawp_project" name="asanawp_project">';
	foreach ($projects as $project) {
		echo '<option value="' . $project->gid . '" ' . ( $asanawp_project !== $project->gid ?: 'selected' ) . '>' . $project->name . '</option>';
	}
	echo '</select>';

}

function asanawp_section() {

	global $client;

	$asanawp_project = get_option( 'asanawp_project' );
	$sections = $client->sections->getSectionsForProject( $asanawp_project, array('opt_expand' => 'memberships'));

	echo '<select id="asanawp_section" name="asanawp_section">';
	foreach ($sections as $section) {
		echo '<option value="' . $section->gid . '" ' . ( $asanawp_task !== $section->gid ?: 'selected' ) . '>' . $section->name . '</option>';
	}	
	echo '</select>';

}

function send_test() {

	try {
		global $client;

		$asanawp_project = get_option( 'asanawp_project' );
		$asanawp_section = get_option( 'asanawp_section' );

		$newTaskOptions = array(
			'name'          => 'test task',
			'projects'      => array( $asanawp_project ),
			'memberships'   => array(
				array(
					'project'   => $asanawp_project,
					'section'   => $asanawp_section
				)
			)
		);
		$newTask = $client->tasks->createTask($newTaskOptions);
	} catch (Asana\Errors\InvalidRequestError $e) {
		echo '<pre>';
		print_r($e->response->body);
		echo '</pre>';
	}
}