<?php

namespace App\EventListener\Password;

use App\Event\PasswordEvent;
use App\Event\UserEvent;
use App\Service\MailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PasswordEventSubscriber implements EventSubscriberInterface
{
    public function __construct(MailSender $mailSender)
    {
        $this->mailerSender = $mailSender;
    }

    public static function getSubscribedEvents()
    {
        return [
            PasswordEvent::PASSWORD_RESET_REQUEST_NAME=> 'onPasswordResetRequest'
        ];
    }

    public function onPasswordResetRequest(PasswordEvent $event)
    {
        $this->mailerSender->sendActivationEmail($event->getToken()['user'], $event->getToken()['token']);
    }
}