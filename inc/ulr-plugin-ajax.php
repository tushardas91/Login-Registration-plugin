<?php

if(!class_exists('UlrPluginAjax')) {

    class UlrPluginAjax
    {

        function ajax_registration()
        {

            //login action
            add_action('wp_ajax_nopriv_user_login', array($this, 'user_login'));
            add_action('wp_ajax_user_login', array($this, 'user_login'));

            //registration action
            add_action('wp_ajax_nopriv_user_registration', array($this, 'user_registration'));
            add_action('wp_ajax_user_registration', array($this, 'user_registration'));

        }

        /** login ajax request */
        function user_login()
        {

            // First check the nonce, if it fails the function will break
            check_ajax_referer('ajax-login-nonce', 'security');

            // Nonce is checked, get the POST data and sign user on
            $info = array();
            $info['user_login'] = $_POST['login_username'];
            $info['user_password'] = $_POST['login_password'];
            $info['remember'] = true;

            $user_signon = wp_signon($info, false);

            if (is_wp_error($user_signon)) {

                echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.')));

            } else {

                echo json_encode(array(
                    'loggedin' => true,
                    'message' => __('Login successful, redirecting...'),
                    'url' => home_url(),
                ));

            }
            wp_die();
        }

        /** user registration ajax request */
        function user_registration()
        {

            if (isset($_POST)) {

                $form_data = $_POST['form_data'];

                parse_str($form_data, $user_info);

                $username = $user_info['user_name'];
                $user_exists = username_exists($username);
                $email = $user_info['email'];
                $e_exists = email_exists($email);
                $password = $user_info['reg_password'];
                $c_password = $user_info['confirm_reg_password'];
            }

            if ($user_exists) {
                echo 'Username Alreday exists, please choose another';
            } elseif ($e_exists) {
                echo 'This e-mail is already registered, please use another to register';
            } elseif (strpos($username, ' ') !== false) {
                echo "Sorry, no spaces are allowed in usernames";
            } elseif (empty($username)) {
                echo "Please enter a username";
            } elseif (!is_email($email)) {
                echo "Please enter a valid email";
            } elseif (empty($password)) {
                echo "Please enter a password for your account";
            } elseif (empty($c_password)) {
                echo "Please re-enter password for your account";
            } elseif ($password != $c_password) {
                echo "Passwords do not match!";
            } else {

                wp_create_user($username, $password, $email);

                echo 'Registration Successfull';

            }
            wp_die();
        }

    }

    $ulrpluginajax = new UlrPluginAjax();
    $ulrpluginajax->ajax_registration();

}