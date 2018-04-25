<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\Type\TagsInputType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
            [
                'label'=>'title',
                'required'=>'required'
            ])
            ->add('content', TextareaType::class,
                    [
                        'label'=>'contenido',
                        'required'=>'required',

                    ])
            ->add('tags', TagsInputType::class, [
                'label' => 'Tags',
                'required' => false,
                'attr' => [
                'data-role' => 'tagsinput',
                
                'class' => 'form-control form-control'
            ]
            ])

            
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
