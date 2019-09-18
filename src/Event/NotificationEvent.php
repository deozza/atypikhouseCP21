<?php
namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    const NOTIFICATION_AFTER_RESERVATION = "postNotificationAfterReservation";
}