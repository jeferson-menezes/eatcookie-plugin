<?php

class EatcookieDesativador {

    public static function deactivate() {
        $timestamp = wp_next_scheduled( 'ec_cron_hook_eatcookie_expire' );
        wp_unschedule_event( $timestamp, 'ec_cron_hook_eatcookie_expire' );
        wp_clear_scheduled_hook( 'ec_cron_hook_eatcookie_expire' );
    }
}
?>