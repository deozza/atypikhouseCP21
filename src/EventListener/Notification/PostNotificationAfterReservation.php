<?php
namespace App\EventListener\Notification;

use App\Event\NotificationEvent;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class PostNotificationAfterReservation implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            NotificationEvent::NOTIFICATION_AFTER_RESERVATION=>"postNotification"
        ];
    }

    public function postNotification(GenericEvent $event)
    {
        $eventPayload = $event->getSubject();
        $reservation = $eventPayload['entity']->getProperties();

        $annonceOwner = $reservation['estate']->getOwner();

        $notification = new Entity();
        $notification->setKind('notification');
        $notification->setOwner($annonceOwner);
        $notification->setValidationState('__default');

        $data = [
            'notif_title'=>"Réservation de l'un de vos biens",
            'content'=> "Lorem ipsum dolor sit amet"
        ];

        $notification->setProperties($data);
        $this->em->persist($notification);
    }


}