<?php
namespace App\DataFixtures;

use App\Entity\User;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Faker;

trait ReservationFixtureTrait
{
    public function createReservations(array $items)
    {
        $faker = Faker\Factory::create("fr_FR");
        $reservations = [];
        $i = 1;
        foreach($items as $item)
        {
            $reservation= $this->createReservation($item['owner'], $item['validationState'], $item['estate'], $item['coming_at'], $item['leaving_at'], $item['nb_people'], $faker);
            $reservation->setUuid("00000".$i."00-0000-4000-a000-000000000000");
            $reservations[] = $reservation;
            $i++;
        }

        return $reservations;
    }

    public function createReservation(User $user, $validationState, Entity $estate, $coming_at, $leaving_at, $nb_people, $faker)
    {
        $reservation = new Entity();
        $reservation->setKind("reservation");
        $reservation->setOwner($user);
        $reservation->setValidationState($validationState);

        $today = new \DateTime('now');
        $coming_at_formated = $today->add(new \DateInterval($coming_at))->format('Y-m-d H:i:s');
        $leaving_at_formated = $today->add(new \DateInterval($leaving_at))->format('Y-m-d H:i:s');

        $date1 = new \DateTime($coming_at_formated);
        $date2 = new \DateTime($leaving_at_formated);
        $diff = $date1->diff($date2)->days;

        $total_price = $diff * $estate->getProperties()['price'];
        $serializedEstate = [
            "uuid"=>$estate->getUuid(),
            "validationState"=>$estate->getValidationState(),
            "owner"=>[
                "uuid"=>$estate->getOwner()->getUuid(),
                "username"=>$estate->getOwner()->getUsername(),
                "email" => $estate->getOwner()->getEmail()
            ],
            "properties"=>$estate->getProperties()
        ];

        $properties =
            [
                "estate" => $serializedEstate,
                "nb_people" => $nb_people,
                "coming_at" =>$coming_at_formated,
                "leaving_at"=>$leaving_at_formated,
                "total_price" =>$total_price,
                "more" => $faker->realText(200),
            ];


        $reservation->setProperties($properties);

        $this->manager->persist($reservation);

        return $reservation;
    }
}