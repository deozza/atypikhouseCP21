<?php

namespace App\Form\reservation\posted;

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

class PATCH extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nb_people' , IntegerType::class, [
            'constraints' => [
                new Assert\GreaterThan(0),
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('coming_at' , DateTimeType::class, [
            'constraints' => [
                new Assert\DateTime(),
                new Assert\NotBlank(),
            ],
            'widget' => 'single_text'
        ]);

        $builder->add('leaving_at' , DateTimeType::class, [
            'constraints' => [
                new Assert\DateTime(),
                new Assert\NotBlank(),
            ],
            'widget' => 'single_text'
        ]);

        $builder->add('total_price' , IntegerType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                ],
        ]);

        $builder->add('more' , TextType::class, [
            'constraints' => [
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