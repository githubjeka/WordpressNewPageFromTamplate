<?php

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