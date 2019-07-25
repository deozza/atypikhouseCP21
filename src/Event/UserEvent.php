<?php
namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    const USER_SUBSCRIBE_NAME         = 'app.user_event.subscribe';

    private $user = null;

    public function __construct($user)
    {
        $this->user = $user;
    }
  
    public function getUser()
    {
        return $this->user;
    }
}