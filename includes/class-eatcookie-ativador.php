<?php

class EatcookieAtivador {

    public static function activate() {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
    
        $table_name = $wpdb->prefix . TABLE_NAME_EATCOOKIE_LOG;
        
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `ID` INT NOT NULL AUTO_INCREMENT,
            `date_created` DATETIME NOT NULL,
            `date_modified` DATETIME NULL,
            `date_expire` DATETIME NULL,
            `address` VARCHAR(45) NOT NULL,
            `action` VARCHAR(10) NOT NULL,
            PRIMARY KEY (`ID`));";
        
        if ($wpdb->get_var("SHOW TABLES LIKE `$table_name`") != $table_name) {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }


        if ( ! wp_next_scheduled( 'ec_cron_hook_eatcookie_expire' ) ) {
            wp_schedule_event( current_time('timestamp'), '1dia', 'ec_cron_hook_eatcookie_expire' );
        }
    }
}
?>