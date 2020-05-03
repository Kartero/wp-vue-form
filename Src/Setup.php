<?php
namespace App;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class Setup
{
    const VUE_FORM_DB_VERSION = 'vueform_db_version';

    public static function execute()
    {
        global $wpdb;

	    $charset_collate = $wpdb->get_charset_collate();

        $version = (int) get_site_option(self::VUE_FORM_DB_VERSION);
        if ($version < 1) {
            $sql = "CREATE TABLE `{$wpdb->base_prefix}vue_registration_form` (
                entity_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                email varchar(100) NOT NULL,
                firstname varchar(255),
                lastname varchar(255),
                age int(10),
                PRIMARY KEY  (entity_id),
                KEY email_key (email)
                ) $charset_collate;";

            dbDelta( $sql );

            if (!empty($wpdb->last_error)) {
                throw new \Exception($wpdb->last_error);
            }

            update_site_option(self::VUE_FORM_DB_VERSION, 1);
        }
    }
}