<?php
namespace App\EventListener\Notification;

use App\Event\NotificationEvent;
use App\Service\MailSender;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class PostNotificationAfterReservationCancelling implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em, MailSender $mailSender)
    {
        $this->em = $em;
        $this->mailer = $mailSender;
    }

    public static function getSubscribedEvents()
    {
        return [
            NotificationEvent::NOTIFICATION_AFTER_RESERVATION_CANCELLING=>"postNotificationCancelling"
        ];
    }

    public function postNotificationCancelling(GenericEvent $event)
    {
        $eventPayload = $event->getSubject();
        $reservation = $eventPayload['entity'];

        if($reservation->getProperties()['canceled'] === false) return;

        $annonceOwner = $reservation->getProperties()['estate']->getOwner();

        $notification = new Entity();
        $notification->setKind('notification');
        $notification->setOwner($annonceOwner);
        $notification->setValidationState('__default');

        $data = [
            'notif_title'=>"Une réservation a été annulée",
            'content'=>
                "
                    Bonjour.
                    <br>Votre Reservation pour https://www.atypik.house/estate/{{ reservation.properties.estate.uuid }}?utm_medium=email&utm_source=mailrel&utm_campaign=ah+emailauto&utm_content=reservation+annulee a bien été annulée
                    <br>Si vous changez d'avis, vous pouvez toujours trouver un nouveau bien atypique à tout moment à l'adresse suivante : 
                    <br>http://www.atypik.house/?utm_medium=email&utm_source=mailrel&utm_campaign=ah+emailauto&utm_content=reservation+annulee
                "
        ];

        $notification->setProperties($data);
        $this->em->persist($notification);

        $this->mailerSender->sendReservationCancellingNotificationEmail($reservation, $annonceOwner);
    }


}