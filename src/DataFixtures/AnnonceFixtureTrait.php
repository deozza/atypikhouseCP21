<?php
namespace App\DataFixtures;

use App\Entity\User;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Faker;

trait AnnonceFixtureTrait
{
    public function createAnnonces(array $items)
    {
        $faker = Faker\Factory::create("fr_FR");
        $annonces = [];
        $i = 1;
        foreach($items as $item)
        {
            $annonce = $this->createAnnonce($item['owner'], $item['validationState'], $item['photo'], $item['legal_id'], $faker);
            $annonce->setUuid("0000".$i."000-0000-4000-a000-000000000000");
            $annonces[] = $annonce;
            $i++;
        }

        return $annonces;
    }

    public function createAnnonce(User $user, $validationState, ?string $photo, ?bool $legalId, $faker)
    {
        $annonce = new Entity();
        $annonce->setKind("estate");
        $annonce->setOwner($user);
        $annonce->setValidationState($validationState);

        $estate_category = ['nature_vibes', 'love_vibes', 'beach_vibes', 'family_vibes', 'unique_vibes', 'food_vibes', 'treehouse', 'cabin', 'chalet', 'caravan', 'ecolodge', 'tiny_house', 'old_caravan', 'tent', 'tepee','yurt', 'hanging_tent', 'nest', 'bubble', 'dome', 'igloo', 'safari', 'boat', 'piles_cabin', 'water_cabin'];
        $utilities = ['Télévision par câble', 'eau chaude', 'chauffage', 'microonde', 'Wi-Fi'];
        $environment = ['restaurants','parking','dancing','salle sport'];
        $properties =
            [
                "title" => $faker->realText(100),
                "description" => $faker->realText(200),
                "price" =>$faker->numberBetween(0, 1000),
                "surface"=>$faker->numberBetween(0, 1000),
                "rooms" =>$faker->numberBetween(0, 10),
                "beds" => $faker->numberBetween(0, 10),
                "bath_room" => $faker->numberBetween(0, 10),
                "city" => $faker->city,
                "address" => $faker->streetAddress,
                "postal_code" => $faker->postcode,
                "country" => $faker->country,
                "estate_category"=>$faker->randomElement($estate_category),
                "utilities"=>$faker->randomElements($utilities),
                "environment"=>$faker->randomElements($environment)
            ];

        if(!empty($photo))
        {
            $file = file_get_contents(__DIR__."/".$photo);
            $filename = "testfile";
            $properties['image'] = [$filename=>base64_encode($file)];
        }

        if(!empty($legalId))
        {
            $properties['legal_id'] = $faker->realText(10);
        }

        $annonce->setProperties($properties);

        $this->manager->persist($annonce);

        return $annonce;
    }
}