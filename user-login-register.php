<?php
/**
 * Plugin Name: User Login Register
 * Description: This plugin added user Login and Registration Form.
 * Plugin URI:
 * Author: Tushar Das
 * Author URI: http://tushardas.ga
 * Version: 1.0.0
 * License: GPLv2
 * Text Domain: user-login-register
 */

/**
 * Copyright (c) . All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


//----------------------------------------------------------------------
// Core constant defination
//----------------------------------------------------------------------
if (!defined('USER_LOG_REG_PLUGIN_VERSION')) define( 'USER_LOG_REG_PLUGIN_VERSION', '1.0.0' );
if (!defined('USER_LOG_REG_PLUGIN_BASENAME')) define( 'USER_LOG_REG_PLUGIN_BASENAME', plugin_basename(__FILE__) );
if (!defined('USER_LOG_REG_MINIMUM_WP_VERSION')) define( 'USER_LOG_REG_MINIMUM_WP_VERSION', '3.5' );
if (!defined('USER_LOG_REG_PLUGIN_PLUGIN_DIR')) define( 'USER_LOG_REG_PLUGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if (!defined('USER_LOG_REG_PLUGIN_URI')) define( 'USER_LOG_REG_PLUGIN_URI', plugins_url('', __FILE__) );
if (!defined('USER_LOG_REG_PLUGIN_TEXTDOMAIN')) define( 'USER_LOG_REG_PLUGIN_TEXTDOMAIN', 'user-login-register' );


if(!class_exists('UserLoginRegistration')) {

    class UserLoginRegistration
    {
        public $pluginName;

        function __construct(){
            $this->pluginName = USER_LOG_REG_PLUGIN_BASENAME ;

            $this->login_registration_form();
            $this->login_registration_ajax();
        }

        function register(){

            add_action( 'admin_enqueue_scripts' , array( $this , 'admin_enqueue'));

            add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue'));

            add_action( 'admin_menu' , array( $this , 'add_admin_pages'));

            add_filter( "plugin_action_links_$this->pluginName" , array( $this, 'settings_page_link'));
        }

        // Place code that runs at plugin activation here.
        function activate()
        {
            require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR."/inc/ulr-plugin-activate.php";
            UlrPluginActivate::activate();
        }

        // Place code that runs at plugin deactivation here.
        function deactivate()
        {
            require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR."/inc/ulr-plugin-deactivate.php";
            UlrPluginDecctivate::deactivate();
        }

        // Plugin registration for Admin menu bar
        public function add_admin_pages(){

            add_menu_page( 'User Login & Registration Form Plugin' , 'User login Registration' , 'manage_options' , 'ulr_plugin' ,
                array( $this, 'admin_index_file'), 'dashicons-list-view' , 110 );
        }

        function admin_index_file(){
            require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR."/admin/admin.php";
        }

        // Create direct link of plugin settings area.
        public function settings_page_link($link){
            $settings_page_link = '<a href="admin.php?page=ulr_plugin">Settings</a>';
            array_push( $link, $settings_page_link );
            return $link;
        }

        // Create shortcode for plugin show.
        public function login_registration_form(){
            require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR."/inc/ulr-plugin-shortcode.php";
        }

        // Place code that comes from ajax request.
        public function login_registration_ajax(){
            require_once USER_LOG_REG_PLUGIN_PLUGIN_DIR."/inc/ulr-plugin-ajax.php";
        }

        // Enqueue Style for Admin
        function admin_enqueue(){
            wp_enqueue_style( 'ulr-admin-style' , USER_LOG_REG_PLUGIN_URI.'/admin/css/style.css' );
        }

        // Enqueqe style and script for Front-End
        function enqueue(){
            wp_enqueue_style( 'ulr-style' , USER_LOG_REG_PLUGIN_URI.'/assets/css/style.css' );

            wp_enqueue_script( 'ulr-jquery' , USER_LOG_REG_PLUGIN_URI.'/assets/js/jquery-2.1.0.min.js', true );

            wp_enqueue_script( 'ulr-script' , USER_LOG_REG_PLUGIN_URI.'/assets/js/script.js', true );

            wp_localize_script( 'ulr-script', 'ajax_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ) // WordPress AJAX
            ) );

        }

    }

    $userLoginRegistration = new UserLoginRegistration();
    $userLoginRegistration->register();

    register_activation_hook(__FILE__,array($userLoginRegistration , 'activate'));
    register_deactivation_hook(__FILE__,array($userLoginRegistration , 'deactivate'));

}