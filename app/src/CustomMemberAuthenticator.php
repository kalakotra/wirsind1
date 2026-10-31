<?php

use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;

class CustomMemberAuthenticator extends MemberAuthenticator
{
    public function getLostPasswordHandler($link)
    {
        return CustomLostPasswordHandler::create($link, $this);
    }

    public function getChangePasswordHandler($link)
    {
        return CustomChangePasswordHandler::create($link, $this);
    }
}