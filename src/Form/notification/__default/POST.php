<?php

namespace App\Form\notification\__default;

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
        $builder->add('notif_title' , TextType::class, [
            'constraints' => [
                new Assert\Length(['min'=>'20']),
                new Assert\Length(['max'=>'255']),
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('content' , TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $builder->add('user' , TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
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