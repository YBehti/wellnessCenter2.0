<?php

namespace App\Form;

use App\Entity\Locality;
use App\Entity\PostCode;
use App\Entity\Surfer;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('email',EmailType::class,array(
                'label' => 'Email',
                'attr' => array('class' =>'form-control')
            ))
            ->add('password',PasswordType::class,array(
                'label' => 'Password',
                'attr' => array('class' =>'form-control')
            ))
            ->add('confirm_password',PasswordType::class,array(
                'label' => 'Confirm Password',
                'attr' => array('class' =>'form-control')
            ))

            ->add('name',TextType::class,array(
                'label' => 'Name',
                'attr' => array('class'=>'form-control')
            ))

            ->add('firstname',TextType::class,array(
                'label' => 'Firstame',
                'attr' => array('class'=>'form-control')
            ))

            ->add('adress_street',TextType::class,array(
                'label' => 'Street',
                'attr' => array('class' =>'form-control')
            ))
            ->add('adress_num',TextType::class,array(
                'label' => 'Street Number',
                'attr' => array('class' =>'form-control')
            ))
            ->add('locality',EntityType::class,array(
                'label' => 'Locality',
                'class'=> Locality::class,
                'placeholder'=>'select your locality',
                'empty_data'=>null,
                'attr' => array('class' =>'form-control')
            ))
            ->add('post_code',EntityType::class,array(
                'label' => 'Zip Code',
                'class' => PostCode::class,
                'placeholder' => 'select your zip code',
                'empty_data' => null,
                'attr' => array('class' =>'form-control')
            ))



            ->add('newsletter',CheckboxType::class,array(
                'label'=> 'Subscribe to the Newsletter',
                'attr'=> array('class' => 'checkbox')
            ))
            ->add('profile_picture',FileType::class,[

                'mapped'=>false,
                'required'=>false
            ])
            ->add('submit', SubmitType::class, array(
                'attr' => array('class'=>'btn btn-primary pull-right')
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Surfer::class,
        ]);
    }
}
