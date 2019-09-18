<?php

namespace App\Form\categoryFilter;

use App\Entity\CategoryFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostCategoryFilterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $option)
  {
    $builder->add('title')
      ->add('filters');
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class'=>CategoryFilter::class,
      'csrf_protection'=>false
    ]);
  }
}
