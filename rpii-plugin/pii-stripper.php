<?php
/**
 * Plugin Name: RPII Plugin
 * Plugin URI: https://www.synlighet.no/folk/stian-wiik-insteb%C3%B8/
 * Description: Sterialize GET url params
 * Version: 1.0
 * Author: Stian W. Instebø
 * Author URI: http://www.synlighet.no
 */

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'admin.php?page=rpii-plugin' ) . '">' . __('Settings') . '</a>';
	return $links;
}



add_action('admin_menu', 'synlighet_menu');
function synlighet_menu(){
        add_menu_page( 'RPII Plugin', 'RPII Plugin', 'manage_options', 'rpii-plugin', 'admin_init' );
}

function admin_init(){
    ?>
        
        <style>
        
            boxes {
              margin: auto;
              padding: 50px;
              background: #999;
            }

            /*Checkboxes styles*/
            input[type="checkbox"] { display: none; }

            input[type="checkbox"] + label {
              display: block;
              position: relative;
              padding-left: 35px;
              margin-bottom: 20px;
              font: 14px/20px 'Open Sans', Arial, sans-serif;
              color: #000;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
            }

            input[type="checkbox"] + label:last-child { margin-bottom: 0; }

            input[type="checkbox"] + label:before {
              content: '';
              display: block;
              width: 20px;
              height: 20px;
              border: 1px solid #999;
                border-radius: 50%;
              position: absolute;
              left: 0;
              top: 0;
              opacity: .6;
              -webkit-transition: all .12s, border-color .08s;
              transition: all .12s, border-color .08s;
            }

            input[type="checkbox"]:checked + label:before {
              width: 10px;
              top: -5px;
              left: 5px;
              border-radius: 0;
              opacity: 1;
              border-top-color: transparent;
              border-left-color: transparent;
              -webkit-transform: rotate(45deg);
              transform: rotate(45deg);
            }
            .admin-btns {
                color: #000;
                transition: 0.3s;
                text-transform: uppercase;
                border: 1px solid #000;
            }
            .admin-btns:hover {
                background-color: #6B2886; 
                color: #fff;
                border: 1px solid #6B2886;
            }
            
            .credit-btns {
                color: #000;
                transition: 0.3s;
                text-transform: uppercase;
                border: 1px solid #000;
            }
            .credit-btns:hover {
                background-color: #BFE8E1; 
                color: #fff;
                border: 1px solid #BFE8E1;
            }
            
            .settings-input {
                padding-left: 15px; padding-right: 15px; background: none; width: 500px; height: 50px; border: 1px solid #000; border-radius: 25px;
            }
            
        </style>

        <div class="" style="width: 60%; margin: 0 auto; padding: 25px;">
            <h1>Remove PII - Plugin</h1>
            <p>Remove PII information from url strings. Info gets stored in local storage, and can be accessed using GA DLV's.</p>
            <br><br>
            <h2>Options</h2>
            <form action="options.php" method="post">
                <?php
                    settings_fields( 'wpse61431_settings' );
                    do_settings_sections( __FILE__ );

                    //get the older values, wont work the first time
                    $options = get_option( 'wpse61431_settings' ); 
                ?>
                <fieldset>
                    <label>
                        <input class="settings-input" name="wpse61431_settings[wpse_array_field]" type="text" id="wpse_array_field" value="<?php echo (isset($options['wpse_array_field']) && $options['wpse_array_field'] != '') ? $options['wpse_array_field'] : ''; ?>" style="background: none; border-radius: 25px; padding-left: 15px; padding-right: 15px;" palceholder="'email', 'phone', 'dob'"/>
                        <br>
                        <br>
                        <span class="description">Sort each param by using comma 'param',</span>
                        <b>'email', 'phone', 'dob'</b>
                    </label>
                    <br>
                    <br>
                    <br>
                    <br>
                    
                </fieldset>
                <br>
                <br>
                <input style="color: #000; transition: 0.3s; text-transform: uppercase; border: 1px solid #000; width: 100px; height: 50px; border-radius: 25px; background: none;" type="submit" value="Save" />
            </form>
            
            <br><br>
            <h2>Advanced Options</h2>
            <div class="boxes" style="margin-bottom: 50px;">
                <input type="checkbox" id="box-1" style="float: left;" checked>
                <label for="box-1">?param=param filter</label>
                
                <input type="checkbox" id="box-2" style="float: left;" disabled>
                <label for="box-2">Option 2</label>
                
                <input type="checkbox" id="box-3" style="float: left;" disabled>
                <label for="box-3">Option 3</label>
            </div>
            
            
            <a href="https://www.synlighet.no" target="_blank" class="admin-btns" style=" width: 150px; height: 50px; padding-left: 30px; padding-right: 30px; padding-top: 15px; padding-bottom: 15px;  text-decoration: none; border-radius: 25px;">Feedback</a> <a href="https://www.synlighet.no/folk/stian-wiik-insteb%C3%B8/" target="_blank" class="credit-btns" style=" width: 150px; height: 50px; padding-left: 30px; padding-right: 30px; padding-top: 15px; padding-bottom: 15px;  text-decoration: none; border-radius: 25px;">Credits</a>
            <br>
            <br>
            <br>
            <br>
            <center>
                <img src="https://www.synlighet.no/dynamic/upload/bilder/02-synlighet-logo-svart-rgb.png" height="100" />
                <p style="color: #ccc;">&copy; Synlighet 2020 - Developed by Stian W. Instebø</p>
            </center>
        </div>


    <?php
}

/*
 * Register the settings
 */
add_action('admin_init', 'wpse61431_register_settings');
function wpse61431_register_settings(){
    //this will save the option in the wp_options table as 'wpse61431_settings'
    //the third parameter is a function that will validate your input values
    register_setting('wpse61431_settings', 'wpse61431_settings', 'wpse61431_settings_validate');
}

function wpse61431_settings_validate($args){
    return $args;
}

//Display the validation errors and update messages
/*
 * Admin notices
 */
add_action('admin_notices', 'wpse61431_admin_notices');
function wpse61431_admin_notices(){
   settings_errors();
}

add_action ( 'wp_head', 'hook_inHeader' );
function hook_inHeader() {
    $phpJsArrayConv = '';

    foreach( get_option('wpse61431_settings') as $key => $value) {
        $phpJsArrayConv = 'var pageStripDictonary = ['.$value.'];';        
    }
    
    echo "
    <script>
    ".$phpJsArrayConv."
            // get page URL
            var pageURL = window.location.href;
            
            // loop through list
            for (i = 0; i < pageStripDictonary.length; i++) {

                if (pageURL.includes(pageStripDictonary[i])) {
                    console.log('stripping url');
                    
                    // show where to look for query params
                    var pageParams = (new URL(document.location)).searchParams;
                    var paramValue = pageParams.get(pageStripDictonary[i]);

                    // handle get params quietly
                    localStorage.removeItem(pageStripDictonary[i]);
                    localStorage.setItem(pageStripDictonary[i], paramValue);
                    
                    // redirect page without query params
                    window.location.replace(pageURL.split('?')[0]);
                    
                    // TODO: push to DLV
                } else {
                    console.log('url already stripped');
                    console.log('data: '+localStorage.getItem(pageStripDictonary[i]));
                }
            }
            
            // push data to DLV 
            var arr = [];
            for (i = 0; i < pageStripDictonary.length; i++) {
                arr.push( localStorage.getItem(pageStripDictonary[i]));
            }
            
            var jsonObj = {'event':'urlStrip'};
            for (var i = 0 ; i < arr.length; i++) {
                jsonObj[pageStripDictonary[i]] = arr[i];
            }
            
            window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(jsonObj);
            
        </script>
    ";
}

?>
