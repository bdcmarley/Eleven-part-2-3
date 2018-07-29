<?php

namespace App\Form;

use App\Entity\Offers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OffersType extends AbstractType
{
    /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            // ->add('picture', TextType::class)
            ->add('description')
            ->add('price');
            // ->add('save', SubmitType::class);
            // die(var_dump($builder));
    }

    /**
   * @param OptionsResolverInterface $resolver
   */
   public function setDefaultOptions(OptionsResolverInterface $resolver)
   {
       $resolver->setDefaults(array(
           'data_class' => 'App/Entity/Offers'

       ));
   }
}
