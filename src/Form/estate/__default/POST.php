<?php

namespace App\Form\estate\__default;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;

class POST extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'20']),
                new Assert\Length(['max'=>'255']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('estate_category' , TextType::class, [
            'constraints' => [
                new Assert\Choice([
                    'choices' =>[ 'nature_vibes', 'love_vibes', 'beach_vibes', 'family_vibes', 'unique_vibes', 'food_vibes', 'treehouse', 'cabin', 'chalet', 'caravan', 'ecolodge', 'tiny_house', 'old_caravan', 'tent', 'tepee', 'yurt', 'hanging_tent', 'nest', 'bubble', 'dome', 'igloo', 'safari', 'boat', 'piles_cabin', 'water_cabin',],
                    'strict' => true
                ]),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('description' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'20']),
                new Assert\Length(['max'=>'255']),
            ],
        ]);

        $builder->add('surface' , IntegerType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('rooms' , IntegerType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('price' , NumberType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('utilities' , CollectionType::class, [
            'entry_type' => ChoiceType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'choices' =>[ 'Télévision par câble', 'eau chaude', 'chauffage', 'microonde', 'Wi-Fi',],
            ]
        ]);

        $builder->add('beds' , IntegerType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('bath_room' , IntegerType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('environment' , CollectionType::class, [
            'entry_type' => ChoiceType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'choices' =>[ 'restaurants', 'parking', 'dancing', 'salle sport',],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]
        ]);

        $builder->add('city' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'1']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('address' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'1']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('postal_code' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'1']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('country' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'1']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('legal_id' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'1']),
            ],
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => null,
                'csrf_protection' => false
            ]
        );
    }
}