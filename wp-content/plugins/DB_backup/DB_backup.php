<?php
/**
 * Plugin Name: DB Export
 * Plugin URI: http://example.com
 * Description: A plugin to download the WordPress database in one click.
 * Version: 1.0
 * Author: Abhinandan
 * Author URI: http://example.com
 * License: GPL2
 */

// Add admin menu item under Tools
function db_export_plugin_menu() {
    add_management_page(
        'Database Export',       // Page title
        'DB Export',             // Menu title
        'manage_options',        // Capability
        'db-export-plugin',      // Menu slug
        'db_export_plugin_page'  // Callback function
    );
}
add_action('admin_menu', 'db_export_plugin_menu');

// Display the plugin page
function db_export_plugin_page() {
    ?>
    <div class="wrap">
        <h1>Database Export</h1>
        <form method="post" action="">
            <?php wp_nonce_field('db_export_nonce', 'db_export_nonce_field'); ?>
            <p><input type="submit" name="db_export_submit" class="button-primary" value="Export Database" /></p>
        </form>
        <p>The Easy DB Export and Backup plugin allows WordPress administrators to export their database with a single click<br> and automatically creates a backup of the previous data each time an admin logs into the dashboard.<br> This ensures that your data is always safe and up-to-date.</p>


        <style>
            .myfeatures {
                list-style-type: disc;
                /* display:flex; */
                margin-left:20px;
            }
            .myfeatures li span {
                font-weight: bold;
            }
        </style>


<br><br>
    <h3>Features</h3>
    <ul class="myfeatures">
        <li><p><span>One Click Export</span> : Easily export and download your database with a single click.</p> </li>
        <li><p><span>Automatic Backup:</span> : Every time you, as the site admin, log in, the plugin creates a fresh backup of your database, ensuring that you always have the latest version stored safely..</p> </li>
        <li><p><span>Convenient Storage:</span> : Backups are stores in the sql file with the database name for easy identification.</p> </li>
    </ul>



        <?php
        if (isset($_POST['db_export_submit']) && check_admin_referer('db_export_nonce', 'db_export_nonce_field')) {
            db_export_plugin_export();
        }
        ?>
    </div>
    <?php
}

// Export the database and save to a file in the plugin directory


function db_export_plugin_export() {
    global $wpdb;

    // Retrieve and print the database name
    $database_name = $wpdb->dbname;

    $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);
    $sql = '';

    foreach ($tables as $table) {
        $table = $table[0];
        $create_table = $wpdb->get_row("SHOW CREATE TABLE $table", ARRAY_N);
        $sql .= "\n\n" . $create_table[1] . ";\n\n";
        
        $rows = $wpdb->get_results("SELECT * FROM $table", ARRAY_N);
        foreach ($rows as $row) {
            $sql .= "INSERT INTO $table VALUES(";
            foreach ($row as $data) {
                $sql .= '"' . esc_sql($data) . '", ';
            }
            $sql = rtrim($sql, ', ');
            $sql .= ");\n";
        }
        $sql .= "\n\n\n";
    }

    // Define the upload directory path
    $upload_dir = wp_upload_dir();
    $plugin_dir = trailingslashit($upload_dir['basedir']) . 'db-export-plugin'; // Plugin-specific subfolder

    // Create the directory if it doesn't exist
    if (!is_dir($plugin_dir)) {
        mkdir($plugin_dir, 0755, true);
    }

    // File path to save the SQL export
    $file = $plugin_dir . '/' . $database_name . '.sql';
    $oldFile = $plugin_dir . '/' . $database_name . '_old.sql';

    // Check if the file already exists
    if (file_exists($file)) {
        // Rename existing file to _old.sql
        rename($file, $oldFile);
    }

    // Save SQL content to the new file
    file_put_contents($file, $sql);

    // Display success message with download link
    echo '<div class="notice notice-success is-dismissible"><p>Database exported successfully. <a href="' . esc_url($upload_dir['baseurl'] . '/db-export-plugin/' . $database_name . '.sql') . '" download>Download here</a></p></div>';
}



// add_action('admin_init', 'db_export_plugin_export');
add_action('wp_login', 'db_export_plugin_export', 10, 2);