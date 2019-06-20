<?php
namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\ApiToken;

trait UserFixturesTrait
{
  public function createUsers(array $items)
  {
    $users = [];
    $i = 1;
    foreach ($items as $item)
    {
      $user = $this->createUser($item["userName"], $item["active"], $item["role"], $i);
      $i++;
      $users[] = $user;
    }
      return $users;
  }

  public function createUser($userName, $active, $role = [], $i)
  {
    $user = new User();
    $user->setUsername($userName);
    $user->setEmail($userName."@gmail.com");
    $user->setActive($active);
    $user->setRoles($role);

    $encoded = $this->encoder->encodePassword($user, $userName);
    $user->setPassword($encoded);
    $this->manager->persist($user);

    $this->createToken($user, $i);

    return $user;
  }

  public function createToken(User $user, $i)
  {
    $tokenValue = "token_".$user->getUsername();
    $token = new ApiToken($user, $tokenValue);
    $this->manager->persist($token);
    $token->setUuid("00".$i."00000-0000-5000-a000-000000000000");
    $this->manager->persist($token);
  }
}
