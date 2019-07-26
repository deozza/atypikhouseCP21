<?php
namespace App\Entity;

class ActivateUser
{
    private $token;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): ?self
    {
      $this->token = $token;
      return $this;
    }

}
