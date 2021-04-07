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
        'asanawp_custom_title', // option name
        'sanitize_callback' // sanitization function
    );

    add_settings_field(
        'asanawp_custom_title',
        'Custom Title',
        'asanawp_custom_title', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_custom_title',
            'class' => 'asanawp', // for <tr> element
        )
    );

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_assignee', // option name
        'sanitize_text_field' // sanitization function
    );

    add_settings_field(
        'asanawp_assignee',
        'Assignee',
        'asanawp_assignee', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_assignee',
            'class' => 'asanawp', // for <tr> element
        )
    );

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_due_on', // option name
        'sanitize_callback' // sanitization function
    );

    add_settings_field(
        'asanawp_due_on',
        'Due On',
        'asanawp_due_on', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_due_on',
            'class' => 'asanawp', // for <tr> element
        )
    );

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_project_fields', // option name
        'sanitize_callback' // sanitization function
    );

    add_settings_field(
        'asanawp_project_fields',
        'Project Fields',
        'asanawp_project_fields', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_project_fields',
            'class' => 'asanawp', // for <tr> element
        )
    );

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

    register_setting(
        'asanawp_settings', // settings group name
        'asanawp_subtasks', // option name
        'sanitize_callback' // sanitization function
    );

    add_settings_field(
        'asanawp_subtasks',
        'Subtasks',
        'asanawp_subtasks', // function which prints the field
        'asanawp', // page slug
        'some_settings_section_id', // section ID
        array( 
            'label_for' => 'asanawp_subtasks',
            'class' => 'asanawp', // for <tr> element
        )
    );

}

add_action('update_option_asanawp_custom_fields', 'asana_workspace_custom_fields', 10, 3);
function asana_workspace_custom_fields() {

    global $client;

    $asanawp_project = get_option( 'asanawp_project' );
    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );

    $projectfields = $client->custom_field_settings->findByProject( $asanawp_project );
    $project_fields = array();
    foreach ($projectfields as $projectfield) {
        $field = $projectfield->custom_field;
        $project_fields[ $field->name ] = $field->gid;
    }

    $custom_fields = array();
    foreach( $asanawp_custom_fields as $field_id => $custom_field ) {
        if ( $custom_field['value'] == 'true' ) {
            if ( !isset($project_fields[ $custom_field['label'] ]) ) {
                $customFieldOptions = array(
                    'name'                   => $custom_field['label'],
                    'resource_subtype'       => 'text'
                );

                // Create custom field directly to the project if it's set to "Yes"
                $gid = $client->projects->addCustomFieldSettingForProject(
                    $asanawp_project,
                    array(
                        'custom_field' => $customFieldOptions
                    )
                )->gid;
            } else {
                $gid = $project_fields[ $custom_field['label'] ];
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

function asanawp_custom_title(){

    $asanawp_custom_title = get_option( 'asanawp_custom_title' );

    printf(
        '<input type="text" id="asanawp_custom_title" name="asanawp_custom_title" value="%s" />',
        esc_attr( $asanawp_custom_title )
    );

}

function asanawp_assignee() {

    global $client;

    $asanawp_workspace = get_option( 'asanawp_workspace' );
    $asanawp_assignee = get_option( 'asanawp_assignee' );
    $assignees = $client->users->getUsers( $asanawp_workspace );

    echo '<select id="asanawp_assignee" name="asanawp_assignee">';
    foreach ($assignees as $assignee) {
        echo '<option value="' . $assignee->gid . '" ' . ( $asanawp_assignee == $assignee->gid ? 'selected' : '' ) . '>' . $assignee->name . '</option>';
    }
    echo '</select>';

}

function asanawp_due_on() {

    global $client;

    $asanawp_due_on = get_option( 'asanawp_due_on' );

    $form = get_asana_form();

    echo '<select name="asanawp_due_on">';
    echo '<option value="">N/A</option>';
    foreach ( $form as $field_id => $field_label ) {
        echo '<option value="' . $field_id . '" ' . ( $asanawp_due_on == $field_id ? 'selected' : '' ) . '>' . $field_label . '</option>';
    }
    echo '</select>';

}

function asanawp_project_fields() {

    global $client;

    $asanawp_project = get_option( 'asanawp_project' );
    $asanawp_project_fields = get_option( 'asanawp_project_fields' );
    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );
    
    $projectfields = $client->custom_field_settings->findByProject( $asanawp_project );

    // Prepare generated custom fields to exclude on project fields
    $custom_fields  = array();
    foreach ( $asanawp_custom_fields as $custom_field ) {
        if ( $custom_field['gid'] ) {
            $custom_fields[] = $custom_field['gid'];
        }
    }

    $form = get_asana_form();

    echo '<table id="asanawp_project_fields">';
    foreach ( $projectfields as $projectfield ) {
        $field = $projectfield->custom_field;
        // Display projects fields if it's not create via custom fields
        if ( !in_array( $field->gid, $custom_fields ) ) {
            echo '<tr>';
            echo '<td><strong>' . $field->name . '</strong></td>'; 
            echo '<td>';
            echo '<select name="asanawp_project_fields[' . $field->gid . '][field_id]">';
            echo '<option value="">N/A</option>';
            foreach ( $form as $field_id => $field_label ) {
                $field_selected = $asanawp_project_fields[ $field->gid ]['field_id'] == $field_id ? 'selected' : '';
                echo '<option value="' . $field_id . '" ' . $field_selected . '>' . $field_label . '</option>';
            }
            echo '</select>';
            
            // Just initialize default if field not enum type
            if ($field->type != 'enum' ) {
                echo '<td><input type="hidden" name="asanawp_project_fields[' .  $field->gid . '][default]" value=""></td>'; 
            }
            
            echo '</td>';
            echo '</tr>';

            if ($field->type == 'enum' ) {
                echo '<tr>';
                echo '<td>Default Value</td>'; 
                echo '<td>';
                echo '<select name="asanawp_project_fields[' . $field->gid . '][default]">';
                echo '<option value="">N/A</option>';
                foreach ( $field->enum_options as $option ) {
                    $option_selected = $asanawp_project_fields[ $field->gid ]['default'] == $option->gid ? 'selected' : '';
                    echo '<option value="' . $option->gid . '" ' . $option_selected . '>' .  $option->name . '</option>';
                }
                echo '</select>';
                echo '</td>';
                echo '</tr>';
            }
        }

    }
    echo '</table>';

}

function asanawp_custom_fields() {

    $asanawp_custom_fields = get_option( 'asanawp_custom_fields' );

    $form = get_asana_form();

    echo '<table id="asanawp_custom_fields">';
    foreach ( $form as $field_id => $field_label ) {
        echo '<tr>';
        echo '<td>' . $field_label . '</td>'; 
        echo '<td><input type="hidden" name="asanawp_custom_fields[' . $field_id . '][label]" value="' . $field_label . '"></td>'; 
        echo '<td><input type="hidden" name="asanawp_custom_fields[' . $field_id . '][gid]" value ="' . $asanawp_custom_fields[ $field_id ]['gid'] . '" ></td>'; 
        echo '<td>';
        echo '<select name="asanawp_custom_fields[' . $field_id . '][value]">';
        echo '<option value="false" ' . ( $asanawp_custom_fields[ $field_id ]['value'] == 'false' ? 'selected' : '' ) . '>No</option>';
        echo '<option value="true" ' . ( $asanawp_custom_fields[ $field_id ]['value'] == 'true' ? 'selected' : '' ) . '>Yes</option>';
        echo '</select>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

}

function asanawp_subtasks() {

    $asanawp_subtasks = get_option( 'asanawp_subtasks' );

    echo '<table id="asanawp_subtasks">';
    echo '<thead>';
    echo '<th>Subtask</th>';
    echo '<th>Action</th>';
    echo '</thead>';
    echo '<tbody>';

    if ( $asanawp_subtasks ) {
        foreach ( $asanawp_subtasks as $subtask ) {
            echo '<tr>';
            echo '<td><input name="asanawp_subtasks[]" value="' . $subtask . '"></td>';
            echo '<td><a href="javascript:void(0);" class="subtask-remove">Remove</a></td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr>';
    echo '<td colspan="2"><a href="javacript:void(0);" class="subtask-add">Add Subtask</a></td>';
    echo '</tr>';
    echo '</tfoot>';
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
    
    $asanawp_pat = get_option( 'asanawp_pat' );
    $client = Asana\Client::accessToken( $asanawp_pat );

    if ( $client ) {
        $asanawp_workspace      = get_option( 'asanawp_workspace' );
        $asanawp_project        = get_option( 'asanawp_project' );
        $asanawp_section        = get_option( 'asanawp_section' );
        $asanawp_project_fields = get_option( 'asanawp_project_fields' );
        $asanawp_custom_fields  = get_option( 'asanawp_custom_fields' );
        $asanawp_custom_title   = get_option( 'asanawp_custom_title' );
        $asanawp_assignee       = get_option( 'asanawp_assignee' );
        $asanawp_due_on         = get_option( 'asanawp_due_on' );
        $asanawp_subtasks       = get_option( 'asanawp_subtasks' );

        // Interpolate custom title with entry fields
        preg_match_all( '/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $asanawp_custom_title, $matches, PREG_SET_ORDER );
        if ( is_array( $matches ) ) {
            foreach ( $matches as $match ) {
                $asanawp_custom_title = str_replace( $match[0], $entry[ $match[1] ], $asanawp_custom_title );
            }
        }

        // Set actual due on date
        $asanawp_due_on = $entry[ $asanawp_due_on ];

        $notes = "<i>This task is automatically created via form submission, full details below</i>:\r\n\r\n";
        foreach ( $form['fields'] as $field ) {
            if ( $field['label'] && $asanawp_custom_fields[ $field['id'] ]['value'] == 'false') {
                $infos = @unserialize( $entry[ $field['id'] ] );
                if ( is_array( $infos )) {
                    $description = '';
                    foreach ($infos as $index => $info) {
                        if ( $index > 0 ) $description .= "\r\n";
                        $description .= ($index + 1) . '. ' . $info;
                    }

                    $infos = $description;
                } else {
                    $infos = $entry[ $field['id'] ];
                }
                $notes .= "<strong>" . $field['label'] . "</strong>:\r\n" . $infos . "\r\n\r\n";
            }
        }

        // Set project custom fields
        $custom_fields = array();

        // Set project fields to custom fields
        foreach( $asanawp_project_fields as $gid => $project_field ) {
            $custom_fields[ $gid ] = $project_field['default'];
            if ( $project_field['field_id'] ) {
                $custom_fields[ $gid ] = $entry[ $project_field['field_id'] ];
            }
        }

        // Set generated fields to custom fields
        foreach( $asanawp_custom_fields as $field_id => $custom_field ) {
            if ( $custom_field['value'] == 'true' ) {
                $custom_fields[ $custom_field['gid'] ] = $entry[ $field_id ];
            }
        }

        $newTaskOptions = array(
            'name'          => $asanawp_custom_title,
            'assignee'      => $asanawp_assignee,
            'due_on'        => $asanawp_due_on,
            'projects'      => array( $asanawp_project ),
            'memberships'   => array(
                array(
                    'project'   => $asanawp_project,
                    'section'   => $asanawp_section
                )
            ),
            'html_notes'    => '<body>' . $notes . '</body>',
            'custom_fields' => $custom_fields,
        );
        $newTask = $client->tasks->createTask( $newTaskOptions );

        foreach ($asanawp_subtasks as $subtask) {
            $newSubtaskOptions = array (
                'name'          => $subtask,
                'assignee'      => $asanawp_assignee,
                'due_on'        => $asanawp_due_on,
            );
            $newSubtask = $client->tasks->createSubtaskForTask( $newTask->gid, $newSubtaskOptions );
        }
    }
    // }

    return $notification;

}

function get_asana_form() {

    $asanawp_form = get_option( 'asanawp_form' );
    
    $gform = GFAPI::get_form( $asanawp_form );

    $form = array();
    foreach ( $gform['fields'] as $field ) {
        if ( $field['label'] ) {
            $form[ $field['id'] ] = $field['label'];
        }
    }

    return $form;
}