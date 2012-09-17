<?php
/*
Plugin Name: Pages From Templates
Plugin URI: 
Description: Создание страниц с использованием шаблонов
Version: 1.0
Author:  Tkachenko Evgeniy
Author URI: 
*/

/*  Copyright 2012  Tkachenko Evgeniy  (email: e.jeka.mail@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Table name in BD `wp_package_templates` by default.
 * If you change table name, change in plugin/thisPlugin/function.php
 *  getTemplatesFromDb() and getDataTemplateFromDb too
 */
function installAndCreateTableInBd ()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "package_templates";
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE  `" . $table_name . "` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `package_name` VARCHAR( 255 ) NOT NULL ,
            `title` VARCHAR( 255 ) NOT NULL ,
            `content` TEXT NOT NULL ,
            `label_attribute` VARCHAR( 255 ) NOT NULL ,
            `template_attribute` VARCHAR( 255 ) NOT NULL
        ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    add_option("jal_db_version", "1.1");
}

register_activation_hook(__FILE__,'installAndCreateTableInBd');

if (is_admin()){
    require_once (dirname(__FILE__).'/functions.php');
    require_once (dirname(__FILE__).'/view/setting.php');
    add_action('wp_ajax_nopriv_do_ajax', 'getDataTemplateFromDb');
    add_action('wp_ajax_do_ajax', 'getDataTemplateFromDb');
}

add_action('admin_menu', 'pftCreateMenu');

function pftCreateMenu()
{
    add_menu_page('Страница из шаблона', 'Страница из шаблона', 'administrator', __FILE__, 'pftSettingsPage');
    add_action( 'admin_init', 'registerMySettings' );
}

function registerMySettings() {
    register_setting( 'pft-settings-group', 'new_option_name' );
}
