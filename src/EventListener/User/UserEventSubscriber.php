<?php

namespace App\EventListener\User;

use App\Event\UserEvent;
use App\Service\MailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    public function __construct(MailSender $mailSender)
    {
        $this->mailerSender = $mailSender;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserEvent::USER_SUBSCRIBE_NAME => 'onUserSubscription'
        ];
    }

    public function onUserSubscription(UserEvent $event)
    {
        $this->mailerSender->sendActivationEmail($event->getUser()['user'], $event->getUser()['token']);
    }

}