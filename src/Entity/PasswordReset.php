<?php
namespace App\Entity;

class PasswordReset
{
    private $token;
    private $password;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): ?self
    {
      $this->token = $token;
      return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): ?self
    {
        $this->password = $password;
        return $this;
    }

}
