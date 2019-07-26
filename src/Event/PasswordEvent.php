<?php
namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class PasswordEvent extends Event
{
    const PASSWORD_RESET_NAME         = 'app.password_event.patch';
    const PASSWORD_RESET_REQUEST_NAME = 'app.password_event.request';

    private $token = null;

    public function __construct($token)
    {
        $this->token = $token;
    }
  
    public function getToken()
    {
        return $this->token;
    }
}