<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Slet gemte indstillinger
delete_option('api_sender_url');
