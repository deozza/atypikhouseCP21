<?php

namespace App\Form\password;

use App\Entity\PasswordReset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordResetType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $option)
  {
    $builder->add('token', TextType::class, [
        'constraints'=>[
            new Assert\NotBlank()
        ]
    ]);

      $builder->add('password', RepeatedType::class, [
          'type' => PasswordType::class,
          'first_options' => ['label' => 'Password'],
          'second_options' => ['label' => 'Repeat Password'],
          "constraints"=>[
              new Assert\NotBlank()
          ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class'=>PasswordReset::class,
      'csrf_protection'=>false
    ]);
  }
}
