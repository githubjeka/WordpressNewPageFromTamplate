<?php

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
