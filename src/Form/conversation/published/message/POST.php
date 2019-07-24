<?php

namespace App\Form\conversation\published\message;

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
        $builder->add('user' , TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('content' , TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('seen', HiddenType::class, [
            'data' => '',
        ]);
        $builder->add('created_at' , DateTimeType::class, [
            'constraints' => [
                new Assert\DateTime(),
                new Assert\NotBlank(),
            ],
            'widget' => 'single_text'
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