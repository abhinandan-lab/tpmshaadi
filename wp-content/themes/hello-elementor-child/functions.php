<?php





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










