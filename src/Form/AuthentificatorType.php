<?php

namespace App\Form;

use App\Entity\Credentials;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthentificatorType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $option)
  {
    $builder->add('login')
      ->add('password');
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class'=>Credentials::class,
      'csrf_protection'=>false
    ]);
  }
}
