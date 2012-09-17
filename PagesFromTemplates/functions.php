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

if(!is_admin())
    return;

function getTemplatesFromDb()
{
    global $wpdb;
    return $wpdb->get_results( "SELECT `id`, `package_name` FROM `wp_package_templates`" );
}

function printDropDownListTemplate()
{
    $templates = getTemplatesFromDb();
    echo '<select id="templatePagePlugin">';
    foreach ($templates as $template ) {
        echo "\n\t<option value='".$template->id."'>".$template->package_name."</option>";
    }
    echo '</select>';
}

function getDataTemplateFromDb()
{
    if(isset($_REQUEST['id'])) {
        $id=$_REQUEST['id'];
        global $wpdb;
        $template = $wpdb->get_results( "SELECT * FROM wp_package_templates WHERE `id`=" . $id);
        $page = array(
            'post_title' => $template[0]->title,
            'post_content' => $template[0]->content,
            'post_type' => 'page',
            'post_name' => $template[0]->label_attribute,
        );
        $id=wp_insert_post($page);
        update_post_meta($id, '_wp_page_template', $template[0]->template_attribute);
        echo get_edit_post_link($id,'');
        die();
    }
}
