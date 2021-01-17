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
        'Section',
        'asanawp_section', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_section',
            'class' => 'asanawp', // for <tr> element
        )
    );

    $asanawp_section = get_option( 'asanawp_section' );
    if ( !$asanawp_section ) {
        return;
    }

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_form', // option name
        'sanitize_text_field' // sanitization function
    );

    add_settings_field(
        'asanawp_form',
        'Form',
        'asanawp_form', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_form',
            'class' => 'asanawp', // for <tr> element
        )
    );

    $asanawp_form = get_option( 'asanawp_form' );
    if ( !$asanawp_form ) {
        return;
    }

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_custom_fields', // option name
        'sanitize_callback' // sanitization function
    );

    add_settings_field(
        'asanawp_custom_fields',
        'Custom Fields',
        'asanawp_custom_fields', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_custom_fields',
            'class' => 'asanawp', // for <tr> element
        )
    );

}

add_action('update_option_asanawp_custom_fields', 'asana_workspace_custom_fields', 10, 3);
function asana_workspace_custom_fields() {

    global $client;

    $asanawp_workspace = get_option( 'asanawp_workspace' );
    $asanawp_project = get_option( 'asanawp_project' );
    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );

    if ( !$asanawp_workspace || !$asanawp_project || !$asanawp_custom_fields ) return false;
    $custom_fields = $client->custom_fields->getCustomFieldsForWorkspace( $asanawp_workspace );

    $workspace_fields = array();
    foreach ($custom_fields as $custom_field) {
        $workspace_fields[$custom_field->name] = $custom_field->gid;
    }

    $custom_fields = array();
    foreach( $asanawp_custom_fields as $field_id => $custom_field ) {
        if ( $custom_field['value'] == 'true' ) {
            if ( !isset($workspace_fields[ $custom_field['label'] ]) ) {
                $customFieldOptions = array(
                    'name'              => $custom_field['label'],
                    'resource_subtype'  => 'text',
                    'workspace'         => $asanawp_workspace
                );
                // Create custom field if it's set to "Yes"
                $response = $client->custom_fields->createCustomField( $customFieldOptions );
                $gid = $response->gid;

                // Add custom field to the project
                $client->projects->addCustomFieldSettingForProject(
                    $asanawp_project,
                    array(
                        'custom_field' => $gid
                    )
                );
            } else {
                $gid = $workspace_fields[ $custom_field['label'] ];
            }
            $asanawp_custom_fields[ $field_id ]['gid'] = $gid;
        } else {
            $gid = $asanawp_custom_fields[ $field_id ]['gid'];
            if ( $gid ) {
                // Delete custom field if it's set to "No"
                $client->custom_fields->deleteCustomField( $gid );
                $asanawp_custom_fields[ $field_id ]['gid'] = '';
            }
        }
    }

    update_option( 'asanawp_custom_fields', $asanawp_custom_fields );

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
        echo '<option value="' . $workspace->gid . '" ' . ( $asanawp_workspace == $workspace->gid ? 'selected' : '' ) . '>' . $workspace->name . '</option>';
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
        echo '<option value="' . $project->gid . '" ' . ( $asanawp_project == $project->gid ? 'selected' : '' ) . '>' . $project->name . '</option>';
    }
    echo '</select>';

}

function asanawp_section() {

    global $client;

    $asanawp_project = get_option( 'asanawp_project' );
    $asanawp_section = get_option( 'asanawp_section' );
    $sections = $client->sections->getSectionsForProject( $asanawp_project, array('opt_expand' => 'memberships'));

    echo '<select id="asanawp_section" name="asanawp_section">';
    foreach ($sections as $section) {
        echo '<option value="' . $section->gid . '" ' . ( $asanawp_section == $section->gid ? 'selected' : '' ) . '>' . $section->name . '</option>';
    }    
    echo '</select>';

}

function asanawp_form() {

    $asanawp_form = get_option( 'asanawp_form' );
    $forms = GFAPI::get_forms();

    echo '<select id="asanawp_form" name="asanawp_form">';
    foreach ($forms as $form) {
        echo '<option value="' . $form['id'] . '" ' . ( $asanawp_form == $form['id'] ? 'selected' : '' ) . '>' . $form['title'] . '</option>';
    }    
    echo '</select>';

}

function asanawp_custom_fields() {

    global $client;

    $asanawp_form = get_option( 'asanawp_form' );
    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );
    
    $form = GFAPI::get_form( $asanawp_form );

    $field_list = array();
    foreach ( $form['fields'] as $field ) {
        if ( $field['label'] ) {
            $field_list[$field['id']] = $field['label'];
        }
    }

    echo '<table id="asanawp_custom_fields">';
    foreach ( $field_list as $field_id => $field_label ) {
        echo '<tr>';
        echo '<td>' . $field_label . '</td>'; 
        echo '<td><input type="hidden" name="asanawp_custom_fields[' . $field_id . '][label]" value="' . $field_label . '"></td>'; 
        echo '<td><input type="hidden" name="asanawp_custom_fields[' . $field_id . '][gid]" value ="' . $asanawp_custom_fields[$field_id]['gid'] . '" ></td>'; 
        echo '<td>';
        echo '<select name="asanawp_custom_fields[' . $field_id . '][value]">';
        echo '<option value="false" ' . ( $asanawp_custom_fields[$field_id]['value'] == 'false' ? 'selected' : '' ) . '>No</option>';
        echo '<option value="true" ' . ( $asanawp_custom_fields[$field_id]['value'] == 'true' ? 'selected' : '' ) . '>Yes</option>';
        echo '</select>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

}

$gform = get_option( 'asanawp_form' );
if ( $gform ) {
    add_filter( 'gform_notification_' . $gform, 'asanawp_nofitication', 10, 3 );
}

function asanawp_nofitication(  $notification, $form, $entry ) {

    // TODO Add select notification if needed
    // if ( $notification['name'] == 'Admin Notification' ) {

    global $client;

    $asanawp_workspace = get_option( 'asanawp_workspace' );
    $asanawp_project = get_option( 'asanawp_project' );
    $asanawp_section = get_option( 'asanawp_section' );
    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );

    // Interpolate subject with entry fields
    $name = $notification['subject'];
    preg_match_all( '/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $name, $matches, PREG_SET_ORDER );
    if ( is_array( $matches ) ) {
        foreach ( $matches as $match ) {
            $name = str_replace( $match[0], $entry[ $match[1] ], $name );
        }
    }

    $notes = 'This task is automatically created via form submission, full details below:\r\n';
    foreach ( $form['fields'] as $field ) {
        if ( $field['label'] && $asanawp_custom_fields[$field['id']]['value'] == 'false') {
            $notes .= $field['label'] . ': ' . $entry[$field['id']] . "\r\n";
        }
    }

    // Fetch project custom fields
    $custom_fields = array();
    foreach( $asanawp_custom_fields as $field_id => $custom_field ) {
        if ( $custom_field['value'] == 'true' ) {
            $custom_fields[ $custom_field['gid'] ] = $entry[ $field_id ];
        }
    }

    $newTaskOptions = array(
        'name'          => $name,
        'projects'      => array( $asanawp_project ),
        'memberships'   => array(
            array(
                'project'   => $asanawp_project,
                'section'   => $asanawp_section
            )
        ),
        'notes'         => $notes,
        'custom_fields' => $custom_fields,
    );
    $newTask = $client->tasks->createTask( $newTaskOptions );

    // }

    return $notification;

}