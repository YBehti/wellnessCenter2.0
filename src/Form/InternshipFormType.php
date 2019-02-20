<?php

namespace App\Form;

use App\Entity\Internship;
use App\Entity\Provider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, array(
                'label' => 'Name',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('price', TextType::class, array(
                'label' => 'Price',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('info', TextareaType::class, array(
                'label' => 'MoreInfos',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('start', DateType::class, array(
                'label' => 'Date Start',
                /*'attr' => array('class' => 'form-control'),*/
                'widget' => 'choice',
            ))
            ->add('end', DateType::class, array(
                'label' => 'Date End',
                'widget' => 'choice',
            ))
            ->add('date', DateType::class, array(
                'label' => 'Display start',
                'widget' => 'choice',
            ))
            ->add('display_end', DateType::class, array(
                'label' => 'Display end',
                'widget' => 'choice',
            ))

            ->add('submit', SubmitType::class, ['label' => 'Register'])
        ;

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Internship::class,
        ]);
    }
}
