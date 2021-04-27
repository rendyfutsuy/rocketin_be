<?php

return [
    'layout' => [
        'title_1' => 'Kolom Baris',
        'title_2' => 'Hello :username',
        'footer_1' => '<p>This email was generated automatically. Please do not reply to it. Please use <br> <a style="color: #000;"><strong>Contact Us</strong></a> Instead. </p>',
        'footer_2' => '<p><strong>Warning!</strong></p> Password and activation code are confidential, do not inform others or anyone refer their self as <a style="color: #000;"><strong>Kolom Baris\'s official.</strong></a>',
    ],
    'reset_password' => [
        'subject' => 'Reset User\'s Password.',
        'content' => '    <h2>Please click url below to continue.</h2>

        <div class="submit" style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; border-radius: 10px; width: 175px;margin: auto;">
            <a style ="text-decoration:none; color: #000;" href=":urlResetForm">Reset Password.</a>
        </div>',
    ],
    'activation' => [
        'subject' => 'Verify User\'s Account',
        'content' => '<h2>Hello, Time to verify your Kolom Baris account</h2>
            <p>
                You\'re almost there, just insert code below and you\'re done!
            </p>
        
            <div style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; border-radius: 10px; width: 175px;margin: auto;">
                <strong>:activationCode</strong>
            </div>
        
            <p>
                <strong> note :</strong> <br>
                Code above only valid for 30 minutes. Do not share this code with anyone.
            </p>',
    ],
    'reset_email' => [
        'subject' => 'Reset User\'s Email.',
        'content' => '    <h2>Copy this code or click url below to continue.</h2>

        <div style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; border-radius: 10px; width: 175px; margin: auto; margin-bottom: 1.5rem;">
            <strong>:activationCode</strong>
        </div>

        <div class="submit">
            <a style ="text-decoration:none; color: #fff" href=":urlResetForm">Reset Email.</a>
        </div>',
    ],
    'change_password' => [
        'subject' => 'Change User\'s Password.',
        'content' => '<div class="submit" style="text-align:center;padding: 10px; border: 1px #f0f0f0 solid; margin: auto;">
            Password was changed.
        </div>',
    ],
    'reset_request_success' => 'Reset Email Requested',
];
