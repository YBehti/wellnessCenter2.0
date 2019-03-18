<?php

namespace App\Form;

use App\Entity\Locality;
use App\Entity\PostCode;
use App\Entity\Provider;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProviderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder



            ->add('email',EmailType::class,array(
                'label' => 'Email',
                'attr' => array('class' =>'form-control')
            ))
            ->add('email_pro',EmailType::class,array(
                'label' => 'Email Professionel',
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
            /*->add('password_confirm',PasswordType::class,array(
                'label' => 'Password Confirmation',
                'attr' => array(
                    'class' =>'form-control',
                    'mapped' => 'false'
                )
            ))*/
            ->add('phone_number',TextType::class,array(
                'label' => 'Phone Number',
                'attr' => array('class' =>'form-control')
            ))
            ->add('website',UrlType::class,array(
                'label' => 'Website',
                'attr' => array('class' =>'form-control')
            ))
            ->add('VAT_number',NumberType::class,array(
                'label' => 'VAT Number',
                'attr' => array('class' =>'form-control')
            ))
            ->add('name',TextType::class,array(
                'label' => 'Name',
                'attr' => array('class' =>'form-control')
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
            ->add('services',EntityType::class,array(
                'label' => 'Services',
                'class' => Service::class,
                'multiple'=> true,
                'placeholder' => 'select the service(s)',
                'attr' => array('class' =>'form-control')
            ))
            ->add('profile_picture',FileType::class,[

                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Image([
                        'maxSize' => '5M'
                    ]),

                ]
            ])


            ->add('logo_picture',FileType::class,[

                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Image()
                ]
            ])
            ->add('submit', SubmitType::class, array(
                'attr' => array('class'=>'btn btn-primary pull-right')
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Provider::class,
        ]);
    }
}
