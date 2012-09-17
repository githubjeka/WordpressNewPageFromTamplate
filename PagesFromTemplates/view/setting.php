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

function pftSettingsPage()
{ ?>
    <div class="wrap">
        <h2>Страница из шаблона</h2>
        <div id="dialog-form">
            <fieldset>
                <p>Выберите шаблон:</p>
                <form id="formTemplateForPage">
                    <?php printDropDownListTemplate() ?>
                    <button type="button" class="button-primary" onclick="jQuery:cretePage()">
                        <span>Применить шаблон</span>
                    </button>
                </form>
            </fieldset>
        </div>
    </div>

    <script>
        function cretePage()
        {
            var value = jQuery("#templatePagePlugin").val();

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                data:{
                    'action':'do_ajax',
                    'id':value
                },
                success:function(data){
                    window.location.replace(data);
                },
                error: function(errorThrown){
                    alert('error');
                    console.log(errorThrown);
                }
            });
        }
    </script>
<?php } ?>