<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class,array(
                'label'=>'Content',
                'attr' => array('class'=>'form_control','cols'=>'10','rows'=>'10','style'=>'width:525px')
            ))
            ->add('evaluation',NumberType::class,array(
                'label' => 'Evaluation from 1 - 5',
                'attr' => array('class' =>'form-control')
            ))

            ->add('submit', SubmitType::class, ['label' => 'Save', 'attr'=>array('class'=>'form_control')])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
