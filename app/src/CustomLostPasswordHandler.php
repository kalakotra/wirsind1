<?php

use Psr\Log\LoggerInterface;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\MemberAuthenticator\LostPasswordHandler;
use SilverStripe\Security\Security;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Exception\RfcComplianceException;

class CustomLostPasswordHandler extends LostPasswordHandler
{
    private static $password_reset_back_url = 'epu-netzwerk/profil';

    protected function redirectToSuccess(array $data)
    {
        $backURL = $this->getBackURL();
        if ($backURL) {
            return $this->redirect($backURL);
        }

        return parent::redirectToSuccess($data);
    }

    protected function sendEmail($member, $token)
    {
        $resetLink = Security::getPasswordResetLink($member, $token);
        $backURL = static::config()->get('password_reset_back_url');
        if ($backURL) {
            $resetLink .= '&BackURL=' . urlencode($backURL);
        }

        try {
            $email = Email::create()
                ->setHTMLTemplate('SilverStripe\\Control\\Email\\ForgotPasswordEmail')
                ->setData($member)
                ->setSubject(_t(
                    'SilverStripe\\Security\\Member.SUBJECTPASSWORDRESET',
                    'Your password reset link',
                    'Email subject'
                ))
                ->addData('PasswordResetLink', $resetLink)
                ->setTo($member->Email);

            $member->extend('updateForgotPasswordEmail', $email);
            $email->send();
            return true;
        } catch (TransportExceptionInterface | RfcComplianceException $e) {
            /** @var LoggerInterface $logger */
            $logger = Injector::inst()->get(LoggerInterface::class . '.errorhandler');
            $logger->error('Error sending email in ' . __FILE__ . ' line ' . __LINE__ . ": {$e->getMessage()}");
            return false;
        }
    }
}