<?php
/*
Plugin Name: TPM Shaadi AJAX Plugin
Description: Example of using AJAX in WordPress plugin for Shaadi website.
Version: 1.0
Author: Your Name
*/

// Enqueue scripts and localize variables for AJAX
function tpm_shaadi_ajax_scripts() {
    // Enqueue jQuery dependency
    wp_enqueue_script('jquery');

    // Enqueue custom script
    wp_enqueue_script('tpm-shaadi-script', plugins_url('tpm-shaadi-script.js', __FILE__), array('jquery'), '1.0', true);

    // Localize the script with new data
    $ajax_params = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('tpm_shaadi_ajax_nonce')
    );
    wp_localize_script('tpm-shaadi-script', 'ajax_object', $ajax_params);
}
add_action('wp_enqueue_scripts', 'tpm_shaadi_ajax_scripts');




// -------------------------- DONT TOUCH ABOVE -----------------------------------------------

// AJAX handler function
function tpm_shaadi_ajax_process_request() {
    // Verify nonce
    check_ajax_referer('tpm_shaadi_ajax_nonce', 'security');

    // Get the email from POST data
    $email = sanitize_email($_POST['email']);

    // Check if the email exists in WordPress users
    $user = get_user_by('email', $email);


    // echo json_encode($_POST['email']);
    // echo json_encode($user);



    if ($user) {
        // Email already exists
        echo json_encode(array('success' => false, 'message' => 'Email already exists!'));
        wp_die();
    }
    

    // If email doesn't exist, perform your other actions (e.g., save to database, send email, etc.)

    // Return response
    echo json_encode(array('email' => $email, 'message' => 'Email available!'));

    // Always exit to avoid further execution
    wp_die();
}
add_action('wp_ajax_tpm_shaadi_ajax_request', 'tpm_shaadi_ajax_process_request');
add_action('wp_ajax_nopriv_tpm_shaadi_ajax_request', 'tpm_shaadi_ajax_process_request'); // for users that are not logged in

?>
