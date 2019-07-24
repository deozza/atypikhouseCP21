<?php

namespace App\Form\password;

use App\Entity\ActivateUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ActivateUserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $option)
  {
    $builder->add('token', TextType::class, [
        'constraints'=>[
            new Assert\NotBlank()
        ]
    ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class'=>ActivateUser::class,
      'csrf_protection'=>false
    ]);
  }
}
