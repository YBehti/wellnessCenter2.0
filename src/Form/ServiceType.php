<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, array(
                'label' => 'Description',
                'attr' => array('class' => 'form-control'),
            ))

            ->add('description',TextareaType::class,array(
                'label' => 'Description',
                'attr' => array('class' => 'form-control')
            ))

            ->add('name', TextType::class,array(
                'label' => 'Name',
                'attr' => array('class' => 'form-control')
            ))
            ->add('vitrine_picture',FileType::class,[

                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Image()
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Register',
                'attr'=>array('class'=>'form-control btn btn-primary')
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
