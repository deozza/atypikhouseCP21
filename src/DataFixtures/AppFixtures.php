<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    use UserFixturesTrait;
    use AnnonceFixtureTrait;
    use ReservationFixtureTrait;
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
                ["userName"=>"userActive2", "active"=> true, "role"=>[]],

            ]
        );
        $this->manager->flush();

        $this->estates = $this->createAnnonces(
            [
                ["owner" => $this->users[3], "validationState"=>"posted", "photo"=>null, 'legal_id'=>false],
                ["owner" => $this->users[4], "validationState"=>"posted", "photo"=>"1.jpeg", 'legal_id'=>true],
                ["owner" => $this->users[3], "validationState"=>"published", "photo"=>null, 'legal_id'=>false],
                ["owner" => $this->users[4], "validationState"=>"published", "photo"=>"1.jpeg", 'legal_id'=>true],
            ]
        );
        $this->manager->flush();

        $this->reservation = $this->createReservations(
            [
                ['owner'=>$this->users[3], "validationState"=>"posted", 'estate'=>$this->estates[3], 'coming_at'=>"P01D", 'leaving_at'=>"P10D", 'nb_people'=>1],
                ['owner'=>$this->users[4], "validationState"=>"posted", 'estate'=>$this->estates[2], 'coming_at'=>"P01D", 'leaving_at'=>"P10D", 'nb_people'=>1]

            ]
        );
        $this->manager->flush();
    }
}
