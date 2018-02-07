<?php
if(! class_exists(UlrPluginShortcode)){

  class UlrPluginShortcode{

    function __construct(){
        add_shortcode( 'UserLoginRegistration', array( $this , 'register_ulr_plugin_shortcode' ) );
    }

    function register_ulr_plugin_shortcode() {

        require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR . '/templetes/user-log-reg-form.php';

    }
  }

  new UlrPluginShortcode();

}
