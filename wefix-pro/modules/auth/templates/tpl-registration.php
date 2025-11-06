<?php get_header(); ?>

<?php
    /*Template Name: Registration Page Template */
?>

<div class="container">
    <div class="wefix-custom-auth-column dt-sc-full-width  wdt-registration-form">
        <div class="wefix-custom-auth-sc-border-title"> <h2><span><?php esc_html_e('Register Form', 'wefix-pro');?></span> </h2></div>
        <p> <strong><?php esc_html_e('Do not have an account?', 'wefix-pro');?></strong> </p>
        <div class="wefix-custom-auth-register-alert"></div>

        <?php if ( !is_user_logged_in() && !isset($_GET['profileupdate']) ) { ?>

        <form name="loginform" id="loginform" method="post">

            <p>
                <input type="text" name="first_name"  id="first_name" class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Firstname *', 'wefix-pro');?>" />
            </p>
            <p>
                <input type="text" name="last_name" id="last_name"  class="input" value="" size="20" placeholder="<?php esc_html_e('Lastname', 'wefix-pro');?>" />
            </p>
            <p>
                <input type="text" name="user_name" id="user_name"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Username *', 'wefix-pro');?>" />
            </p>
            <p>
                <input type="email" name="user_email" id="user_email"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Email Id *', 'wefix-pro');?>" />
            </p>
            <p>
                <input type="password" name="password" id="password"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Password *', 'wefix-pro');?>" />
            </p>
            <p>
                <input type="password" name="cpassword" id="cpassword"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Confirm Password *', 'wefix-pro');?>"/>
                <span class="password-alert"></span>
            </p>
            <?php do_action( 'anr_captcha_form_field' ); ?>
            <p> <?php  echo apply_filters('dt_sc_reg_form_elements', '', array () ); ?> </p>
            <p class="submit">
                <input type="submit" class="button-primary wefix-custom-auth-register-button" id="wefix-custom-auth-register-button" value="<?php esc_attr_e('Register', 'wefix-pro');?>" />
            </p>
            <p>
                <?php echo esc_html__('Already have an account.?', 'wefix-pro'); ?> 
                <a href="#" title=<?php echo esc_html__('Login', 'wefix-pro'); ?> class="wefix-pro-login-link" onclick="return false"><?php echo esc_html__('Login', 'wefix-pro'); ?></a>
            </p>
        </form>

        <?php } ?>

        <?php if ( is_user_logged_in() && isset($_GET['profileupdate']) && $_GET['profileupdate'] == '1' ) : 
            
        ?>

        <form id="wefix-fb-update-form">
            
            <div class="wefix-fb-update-alert"></div>
            <label for="wefix-fb-first-name"><?php echo esc_html__('First Name', 'wefix-pro'); ?></label>
            <input type="text" id="wefix-fb-first-name" name="first_name" required>

            <label for="wefix-fb-last-name"><?php echo esc_html__('Last Name', 'wefix-pro'); ?></label>
            <input type="text" id="wefix-fb-last-name" name="last_name" required>

            <label for="wefix-fb-email"><?php echo esc_html__('Email', 'wefix-pro'); ?></label>
            <input type="email" id="wefix-fb-email" name="email" required>

            <button type="submit"><?php echo esc_html__('Update Profile', 'wefix-pro'); ?></button>
        </form>

        <?php endif; ?>

    </div><!-- Registration Form End -->
</div>

<?php get_footer(); ?>