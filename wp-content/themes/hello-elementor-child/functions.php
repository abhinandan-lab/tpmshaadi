<?php

// function handle_registers1_form() {
//     // Check the nonce
//     if (!isset($_POST['register1_action_nonce']) || !wp_verify_nonce($_POST['register1_action_nonce'], 'register1_action_nonce')) {
//         wp_die('Nonce verification failed!');
//     }

//     echo 'hello world';

//     // // Sanitize and validate the form data
//     // $profile_for = sanitize_text_field($_POST['profile-for']);
//     // $dob = sanitize_text_field($_POST['dob']);
//     // $language = sanitize_text_field($_POST['languages']);
//     // $gender = sanitize_text_field($_POST['gender']);
//     // $email = sanitize_email($_POST['email']);

//     // // Additional validation can be added here
//     // if (empty($profile_for) || empty($dob) || empty($language) || empty($gender) || empty($email)) {
//     //     echo json_encode(array('success' => false, 'message' => 'All fields are required!'));
//     //     wp_die();
//     // }

//     // // Check if email already exists
//     // if (email_exists($email)) {
//     //     echo json_encode(array('success' => false, 'message' => 'Email already exists!'));
//     //     wp_die();
//     // }

//     // // Generate a random 12-character string starting with 'USER'
//     // $random_string = 'USER' . wp_generate_password(8, false);

//     // // Prepare user data
//     // $userdata = array(
//     //     'user_login' => $random_string,
//     //     'user_email' => $email,
//     //     'user_pass'  => wp_generate_password(), // Generate a random password
//     //     'role'       => 'subscriber',
//     //     'first_name' => '', // Set to empty string
//     // );

//     // // Insert the user
//     // $user_id = wp_insert_user($userdata);

//     // // Check for errors
//     // if (is_wp_error($user_id)) {
//     //     echo json_encode(array('success' => false, 'message' => $user_id->get_error_message()));
//     //     wp_die();
//     // }

//     // // Add user meta using ACF
//     // update_field('profile_for', $profile_for, 'user_' . $user_id);
//     // update_field('dob', $dob, 'user_' . $user_id);
//     // update_field('language', $language, 'user_' . $user_id);
//     // update_field('gender', $gender, 'user_' . $user_id);
//     // update_field('user_id', $user_id, 'user_' . $user_id);

//     // // JSON response for success
//     // echo json_encode(array('success' => true, 'message' => 'Registration successful!'));
//     // wp_die();
// }

// // Hook the function to form submission action
// add_action('wp_ajax_nopriv_registers1_form', 'handle_registers1_form');
// add_action('wp_ajax_registers1_form', 'handle_registers1_form');
















// ----- UNIVERSAL CODE don't delete ----------------------


// Enqueue jQuery and localize AJAX URL
function enqueue_my_scripts() {
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');




// Generate nonce action
function generate_nonce() {
    if (isset($_GET['nonce_action'])) {
        $nonce_action = sanitize_text_field($_GET['nonce_action']);
        echo wp_create_nonce($nonce_action);
    }
    wp_die(); // This is required to terminate immediately and return a proper response
}
add_action('wp_ajax_generate_nonce', 'generate_nonce');
add_action('wp_ajax_nopriv_generate_nonce', 'generate_nonce');







// AJAX Handler function
function handle_custom_form_submission() {
    check_ajax_referer('custom_form_nonce', 'security');

    // Retrieve and sanitize email
    $email = sanitize_email($_POST['email']);

    // Your custom processing logic here

    // Example: Send email
    wp_mail($email, 'Form Submission', 'Thank you for your submission!');

    // Example: Return JSON response
    $response = array('message' => 'Form submitted successfully!');
    wp_send_json_success($response);
}

// Hook for AJAX requests
add_action('wp_ajax_registers1', 'handle_custom_form_submission');
add_action('wp_ajax_nopriv_registers1', 'handle_custom_form_submission');










