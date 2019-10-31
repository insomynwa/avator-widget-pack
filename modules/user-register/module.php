<?php
namespace WidgetPack\Modules\UserRegister;

use WidgetPack\Base\Widget_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Widget_Pack_Module_Base {

	public function get_name() {
		return 'user-register';
	}

	public function get_widgets() {

		$widgets = [
			'User_Register',
		];
		
		return $widgets;
	}

	/**
	 * Validates and then completes the new user signup process if all went well.
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's first name
	 * @param string $last_name     The new user's last name
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	protected function widget_pack_register_user( $email, $first_name, $last_name ) {
	    $errors = new \WP_Error();
	 
	    // Email address is used as both username and email. It is also the only
	    // parameter we need to validate
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', __( 'The email address you entered is not valid.', 'avator-widget-pack' ) );
	        return $errors;
	    }
	 
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', __( 'An account exists with this email address.', 'avator-widget-pack' ) );
	        return $errors;
	    }
	 
	    // Generate the password so that the subscriber will have to check email...
	    $password = wp_generate_password( 12, false );
	 
	    $user_data = array(
	        'user_login'    => $email,
	        'user_email'    => $email,
	        'user_pass'     => $password,
	        'first_name'    => $first_name,
	        'last_name'     => $last_name,
	        'nickname'      => $first_name,
	    );
	 
	    $user_id = wp_insert_user( $user_data );
	    wp_new_user_notification( $user_id, null, 'both' );


	 
	    return $user_id;
	}

	/**
	 * Handles the registration of a new user.
	 * @return [type] [description]
	 */
	public function widget_pack_do_register_user() {

        check_ajax_referer( 'ajax-login-nonce', 'security' );

        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) { 
            if ( ! get_option( 'users_can_register' ) ) {
                // Registration closed, display error
                echo wp_json_encode( ['registered'=>false, 'message'=> __( 'Registering new users is currently not allowed.', 'avator-widget-pack' )] );
            } else {
                $email      = wp_unslash( $_POST['email'] );
                $first_name = sanitize_text_field( $_POST['first_name'] );
                $last_name  = sanitize_text_field( $_POST['last_name'] );
                
                $result     = $this->widget_pack_register_user( $email, $first_name, $last_name );
     
                if ( is_wp_error( $result ) ) {
                    // Parse errors into a string and append as parameter to redirect
                    $errors  = $result->get_error_message();
                    echo wp_json_encode( ['registered' => false, 'message'=> $errors ] );
                } else {
                    // Success
                    $message = sprintf(__( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'avator-widget-pack' ), get_bloginfo( 'name' ) );
                    echo wp_json_encode( ['registered' => true, 'message'=> $message] );
                }
            }
     
            //wp_redirect( $redirect_url );
            exit;
        }
    }

    public function __construct() {
    	parent::__construct();

    	add_action( 'wp_ajax_nopriv_widget_pack_ajax_register', [$this, 'widget_pack_do_register_user'] );
    }
}
