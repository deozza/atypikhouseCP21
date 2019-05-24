<?php
namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\ApiToken;

trait UserFixturesTrait
{
  public function createUsers(array $items)
  {
    $users = [];
    foreach ($items as $item)
    {
      $user = $this->createUser($item["userName"], $item["active"], $item["role"]);
      $users[] = $user;
    }
      return $users;
  }

  public function createUser($userName, $active, $role = [])
  {
    $user = new User();
    $user->setUsername($userName);
    $user->setEmail($userName."@gmail.com");
    $user->setActive($active);
    $user->setRoles($role);

    $encoded = $this->encoder->encodePassword($user, $userName);
    $user->setPassword($encoded);
    $this->manager->persist($user);

    $this->createToken($user);

    return $user;
  }

  public function createToken(User $user)
  {
    $tokenValue = "token_".$user->getUsername();
    $token = new ApiToken($user, $tokenValue);
    $this->manager->persist($token);
  }
}
