<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		

		?>
<style type='text/css'>
    <?php
    if($accordions_lazy_load=='yes'){
        ?>
        #accordions-tabs-<?php echo $post_id; ?>{display: none;}
        <?php
        }
    ?>
    #accordions-tabs-<?php echo $post_id; ?>{
        text-align: <?php echo $accordions_container_text_align; ?>;
    }
    #accordions-tabs-<?php echo $post_id; ?>{
        background:<?php echo $accordions_container_bg_color; ?> url(<?php echo $accordions_bg_img; ?>) repeat scroll 0 0;
        padding: <?php echo $accordions_container_padding; ?>;
    }
    #accordions-tabs-<?php echo $post_id; ?> .accordions-tab-head{
        background:rgba(<?php echo accordions_paratheme_hex2rgb($accordions_default_bg_color); ?>, <?php echo $accordions_header_bg_opacity; ?>) none repeat scroll 0 0;
        color:<?php echo $accordions_items_title_color; ?>;
        font-size:<?php echo $accordions_items_title_font_size; ?>;
        margin:<?php echo $accordions_items_title_margin; ?>;
        padding:<?php echo $accordions_items_title_padding; ?>;
    }
    #accordions-tabs-<?php echo $post_id; ?> .accordions-head-title{
    }
    #accordions-tabs-<?php echo $post_id; ?> .ui-tabs-active a{
        background:<?php echo $accordions_active_bg_color; ?>;
    }
    #accordions-tabs-<?php echo $post_id; ?> .tabs-content{
        background:rgba(<?php echo accordions_paratheme_hex2rgb($accordions_items_content_bg_color); ?>,<?php echo $accordions_items_content_bg_opacity; ?>) none repeat scroll 0 0;
        color:<?php echo $accordions_items_content_color; ?>;
        font-size:<?php echo $accordions_items_content_font_size; ?>;
        margin:<?php echo $accordions_items_content_margin; ?>;
        padding:<?php echo $accordions_items_content_padding; ?>;
    }
    #accordions-tabs-<?php echo $post_id; ?> .accordions-tab-icons{

          color:<?php echo $accordions_icons_color; ?>;
          font-size:<?php echo $accordions_icons_font_size; ?>;
    }

    <?php
    if(!empty($accordions_custom_css)){
            echo $accordions_custom_css;
        }
    if($accordions_tabs_vertical=='yes'){
        $nav_width_ratio = ($accordions_tabs_vertical_width_ratio - 3);
        $panel_width_ratio = (100 - $accordions_tabs_vertical_width_ratio);



        ?>

        .ui-tabs-vertical .ui-tabs-nav { float: left; width: <?php echo $nav_width_ratio; ?>%;overflow: hidden; }
        .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; }
        .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: <?php echo $panel_width_ratio; ?>%;}
        <?php
        }
    if($accordions_tabs_icon_toggle=='yes'){
        ?>
        .accordions-tabs .ui-tabs-active .accordions-tab-plus {
            display: none;
        }
        .accordions-tabs .ui-tabs-active .accordions-tab-minus {
            display: inline;
        }
        <?php
        }
        ?>
</style>
