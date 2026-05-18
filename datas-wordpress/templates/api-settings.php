<?php
// Hent ikon
$logo_url = plugin_dir_url(__FILE__) . '../assets/icon.png';

// Håndtering af formular
if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('api_sender_save_settings', 'api_sender_nonce')) {
    if (current_user_can('manage_options')) {
        // Gem API URL indstillingerne
        update_option('api_sender_create_url', sanitize_text_field($_POST['api_sender_create_url']));
        update_option('api_sender_update_url', sanitize_text_field($_POST['api_sender_update_url']));
        update_option('api_sender_delete_url', sanitize_text_field($_POST['api_sender_delete_url']));
        echo '<div class="notice notice-success"><p>Indstillinger gemt!</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>Du har ikke de nødvendige rettigheder til at gemme disse indstillinger.</p></div>';
    }
}

$create_url = get_option('api_sender_create_url', '');
$update_url = get_option('api_sender_update_url', '');
$delete_url = get_option('api_sender_delete_url', '');
?>

<div class="wrap">
    <h1>
        <img src="<?php echo esc_url($logo_url); ?>" alt="API Sender Logo" style="max-width: 50px; vertical-align: middle;">
        API Sender Settings
    </h1>
    <form method="POST" action="">
        <?php wp_nonce_field('api_sender_save_settings', 'api_sender_nonce'); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="api_sender_create_url">API URL (Opret ordre)</label></th>
                <td>
                    <input type="text" name="api_sender_create_url" id="api_sender_create_url" value="<?php echo esc_attr($create_url); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="api_sender_update_url">API URL (Opdater ordre)</label></th>
                <td>
                    <input type="text" name="api_sender_update_url" id="api_sender_update_url" value="<?php echo esc_attr($update_url); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="api_sender_delete_url">API URL (Slet ordre)</label></th>
                <td>
                    <input type="text" name="api_sender_delete_url" id="api_sender_delete_url" value="<?php echo esc_attr($delete_url); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
