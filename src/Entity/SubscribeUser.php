<?php
namespace App\Entity;

class SubscribeUser
{
    private $username;
    private $email;
    private $password;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): ?self
    {
      $this->username = $username;
      return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): ?self
    {
        $this->email = $email;
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
