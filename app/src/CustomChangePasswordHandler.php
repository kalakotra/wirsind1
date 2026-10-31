<?php

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Security\MemberAuthenticator\ChangePasswordHandler;

class CustomChangePasswordHandler extends ChangePasswordHandler
{
    private static $allowed_actions = [
        'changepassword',
        'changePasswordForm',
        'doChangePassword',
    ];

    protected function processChangePasswordUrlVars(): array|HTTPResponse|null
    {
        $response = parent::processChangePasswordUrlVars();

        // keep the BackURL when the reset link (m + t) is redirected to the temporary hash URL
        $backURL = $this->getBackURL();
        if ($backURL && $response instanceof HTTPResponse && $response->isRedirect()) {
            $response->addHeader(
                'Location',
                Controller::join_links($response->getHeader('Location'), '?BackURL=' . urlencode($backURL))
            );
        }

        return $response;
    }
}
