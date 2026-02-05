<?php

return [

    /*
     * Translation keys for login and auth flow
     */

    'login_page' => [
        'title' => 'Reserved area',
        'subtext' => 'Login with your credentials',

        'remember_me' => 'Remember me',

        'submit_btn' => 'Login',

        'password_forgot_link' => 'Forgot your password?',
    ],

    'forgot_psw_page' => [
        'title' => 'Reset your password',
        'subtext' => "Enter your user account's verified email address and we will send you a password reset link.",

        'submit_btn' => 'Send',

        'login_link' => 'Login with your password',

        'success_message' => 'Email sent successfully. Check your inbox',
        'error_message' => 'We could not send the email. Please check your address is correct',
    ],

    'reset_page' => [
        'title' => 'Reset your password',
        'subtext' => 'Insert your new password',

        'submit_btn' => 'Reset',
    ],

    'reset_email' => [
        'subject' => 'Reset your password',
        'main_text' => 'We received a password reset request for your :name account',
        'reset_btn' => 'Password reset',
        'expiration_notice' => 'The link will expire in :count minutes',
        'final_text' => 'If you did not submit this request, you can safely ignore this e-mail',
    ],

];
