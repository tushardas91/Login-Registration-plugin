
<div class="ulr-form">
    <div class="ulr-form-wrapper">

        <?php if(!is_user_logged_in()){ ?>
            <!-- START REGISTER PART -->
            <div class="ulr-header-register ulr-hidden">
                <h4 class="ulr-header-title"><?php _e('Register', 'user-login-register'); ?></h4>

                <div>
                    <form method="post" action="" id="user_registration_form">

                        <p class="ulr-status-reg"></p>
                        <input type="text" name="user_name" class="form-control" placeholder="Username">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <input type="password" name="reg_password" class="form-control" placeholder="Password">
                        <input type="password" name="confirm_reg_password" class="form-control" placeholder="Confirm password">
                        <input type="submit" id="user_registration_form_submit" class="btn ulr-btn-submit" value="Register">
                        <span id="ulr-show-log" class="btn ulr-btn-submit"><?php _e('Login', 'user-login-register'); ?></span>

                    </form>  <!-- #user_registration_form -->
                </div>

            </div> <!-- .ulr-header-register -->
            <!-- END REGISTER PART-->
        <?php } ?>

        <?php $current_user = wp_get_current_user(); ?>
        <?php if(is_user_logged_in()){ ?>


            <div class = "ulr-profile">
                <a href="<?php echo esc_url(home_url( )); ?>/wp-admin/profile.php" title="Edit profile"><i class="fa fa-user"></i>&nbsp; &nbsp;<?php echo esc_attr($current_user->user_login); ?></a>
            </div> <!-- .ulr-profile -->

            <div class="ulr-logout">
                <a href="<?php echo esc_url(wp_logout_url( get_permalink() )); ?>" title="Logout"><i class="fa fa-power-off"></i>&nbsp; &nbsp;<?php _e('Logout', 'user-login-register'); ?></a>
            </div> <!-- .ulr-logout -->

        <?php } else {?>
            <!-- START LOGIN PART -->
            <div class="ulr-header-login">

                <h4 class="ulr-header-title"><?php _e('Login', 'user-login-register'); ?></h4>

                <div>
                    <form id="bg-login-form" method="post" action="login" role="form">

                        <p class="ulr-status-log"></p>
                        <input type="text" name="login_username" value="" class="form-control" placeholder="Username">
                        <input type="password" name="login_password" value="" class="form-control" placeholder="Password">
                        <input type="submit" name="wp-submit" id="bg-login" class="btn ulr-btn-submit" value="Login">
                        <span id="ulr-show-reg" class="btn ulr-btn-submit"><?php _e('Register', 'user-login-register'); ?></span>

                        <a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="ulr-pass-link"><?php _e('Forgot Password?', 'user-login-register'); ?></a>

                        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

                    </form>
                </div>

            </div>
            <!-- END LOGIN PART -->
        <?php } ?>

    </div> <!-- .ulr-form-wrapper -->
</div> <!-- .ulr-form -->

