<?php
namespace App\EventListener\Notification;

use App\Event\NotificationEvent;
use App\Service\MailSender;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class PostNotificationAfterReservation implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em, MailSender $mailSender)
    {
        $this->em = $em;
        $this->mailer = $mailSender;
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

        $notificationForEstateOwner = new Entity();
        $notificationForEstateOwner->setKind('notification');
        $notificationForEstateOwner->setOwner($annonceOwner);
        $notificationForEstateOwner->setValidationState('__default');

        $data = [
            'notif_title'=>"Réservation de l'un de vos biens",
            'content'=>
                "Bonjour.
                <br>Une nouvelle réservation pour votre annonce https://www.atypik.house/estate/{{ reservation.properties.estate.uuid }} a été enregistrée.
                <br{{ reservation.owner.username }} a réservé votre bien du {{ reservation.properties.coming_at }} au {{ reservation.properties.leaving_at }} .
                <br>Cliquez sur le lien suivant pour voir la réservation :
                <br>https://www.atypik.house/activation/{{ reservation.uuid }}
                "
        ];

        $notificationForEstateOwner->setProperties($data);
        $this->em->persist($notificationForEstateOwner);

        $this->mailerSender->sendReservationNotificationEmail($reservation, $annonceOwner);
    }


}