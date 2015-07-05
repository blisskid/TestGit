<div class="xqFormPage">
<?php
if ( ! is_user_logged_in() ) { // Display WordPress login form:
    $args = array(
        'redirect' => get_bloginfo('wpurl'), 
        'form_id' => 'xqLoginForm',
        'label_username' => __( '请输入用户名' ),
        'label_password' => __( '请输入密码' ),
        'label_remember' => __( '自动登录' ),
        'label_log_in' => __( '登录' ),
        'remember' => true
    );
    wp_login_form( $args );
} else { // If logged in:
    wp_loginout( home_url() ); // Display "Log Out" link.
    echo " | ";
    wp_register('', ''); // Display "Site Admin" link.
}
?>
</div>