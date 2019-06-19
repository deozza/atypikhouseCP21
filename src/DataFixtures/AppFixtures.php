<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  use UserFixturesTrait;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
      $this->manager = $manager;
      $this->users = $this->createUsers(
        [
          ["userName"=>"userAdmin", "active"=> true, "role"=>["ROLE_ADMIN"]],
          ["userName"=>"userInactive", "active"=> false, "role"=>[]],
          ["userName"=>"userForbidden", "active"=> true, "role"=>[]],
          ["userName"=>"userActive", "active"=> true, "role"=>[]],
        ]
      );
      $this->manager->flush();
    }
}
