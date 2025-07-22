<?php
/*
Plugin Name: TPM Shaadi AJAX Plugin
Description: TPM shaadi plugin containing all ajax request and response.
Version: 1.0
Author: Abhinandan I Rajbhar
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
//
//    to send response always remember error messages will be in 'error' key word & normal message in 'message'
//
// ----------------------------------------------------------------------------------------------


// AJAX handler function
function tpm_shaadi_ajax_process_request() {
    // Verify nonce
    check_ajax_referer('tpm_shaadi_ajax_nonce', 'security');

    // Get the email from POST data
    $email = sanitize_email($_POST['email']);
    $profile_for = sanitize_text_field($_POST['profile-for']);
    $dob = sanitize_text_field($_POST['dob']);
    $language = sanitize_text_field($_POST['languages']);
    $gender = sanitize_text_field($_POST['gender']);    

    // Additional validation can be added here
    if (empty($profile_for) || empty($dob) || empty($language) || empty($gender) || empty($email)) {

        echo json_encode(array( 'error' => 'All fields are required!'));
        wp_die();
    }

    // Check if the email exists in WordPress users
    $userCheck = get_user_by('email', $email);

    if ($userCheck) {
        // Email already exists
        echo json_encode(array('email' => $email, 'error' => 'Email already used. use another email.'));
        wp_die();
    }

    // Generate a random 12-character string starting with 'USER'
    $random_string = 'USER' . wp_generate_password(8, false);


    // Prepare user data
    $userdata = array(
        'user_login' => $random_string,
        'user_email' => $email,
        'user_pass'  => wp_generate_password(), // Generate a random password
        'role'       => 'subscriber',
        'first_name' => '', // Set to empty string
    );

    // Insert the user
    $user_id = wp_insert_user($userdata);

    // Check if user was created successfully
    if (is_wp_error($user_id)) {
        // echo json_encode($userdata);
        echo json_encode(array('email' => $email, 'error' => $user_id->get_error_message()));
        wp_die();
    }

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Add user meta using ACF
    update_field('profile_for', $profile_for, 'user_' . $user_id);
    update_field('date_of_birth', $dob, 'user_' . $user_id);
    update_field('language', $language, 'user_' . $user_id);
    update_field('gender', $gender, 'user_' . $user_id);
    update_field('user_id', $user_id, 'user_' . $user_id);
    update_field('user_otp', $otp, 'user_' . $user_id); // Add OTP to user meta


    // Email recipient
    $to = $email;
    $subject = 'Your Registeration OTP';
    $message = '<h1> ' . $otp . '</h1><br> This is your OTP enter into website to verify your email.';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // Send the email
    if (wp_mail($to, $subject, $message, $headers, $attachments)) {
    
        // Build the URL with the query parameter
        $redirect_url = add_query_arg('user', $random_string, home_url('/get-register-otp/'));



        // echo 'Email sent successfully!';
        // $new_url = home_url() . '/get-register-otp/';
        echo json_encode(array('email' => $email, 'success' => $redirect_url));
        wp_die();
        
        
        
    } else {
        echo json_encode(array('email' => $email, 'error' => 'Email not sent !'));
        wp_die();
    }


    // Return response
    echo json_encode(array('email' => $email, 'message' => 'Register Successfully'));

    // Always exit to avoid further execution
    wp_die();
}
add_action('wp_ajax_tpm_shaadi_ajax_request', 'tpm_shaadi_ajax_process_request');
add_action('wp_ajax_nopriv_tpm_shaadi_ajax_request', 'tpm_shaadi_ajax_process_request'); // for users that are not logged in




function otp_verification_process() {
    // Verify nonce
    check_ajax_referer('tpm_shaadi_ajax_nonce', 'security');
    
    // Get the OTP and password from POST data
    $otp = sanitize_text_field($_POST['otp']);
    $password = sanitize_text_field($_POST['password']);
    $username = sanitize_text_field($_POST['username']);


    // Additional validation can be added here
    if (empty($otp) || empty($password)) {
        echo json_encode(array('error' => 'Both OTP and password are required!'));
        wp_die();
    }

    if (empty($username)) {
        echo json_encode(array('error' => 'Something went wrong please try again'));
        wp_die();
    }









    // Return response
    echo json_encode(array('message' => 'OTP verified successfully'));

    // Always exit to avoid further execution
    wp_die();
}
add_action('wp_ajax_otp_verification_process', 'otp_verification_process');
add_action('wp_ajax_nopriv_otp_verification_process', 'otp_verification_process'); // for users that are not logged in


?>
