<?php

namespace App\Form;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditarLibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('autor')
            ->add('tipo', ChoiceType::class, array(
                'placeholder'=> 'Género',
                'choices' => array(
                    'Aventura' => 'Aventura',
                    'Ciencia Ficción' => 'Ciencia Ficción',
                    'Terror' => 'Terror'
                )
            ))
            ->add('fecha_publicacion', DateType::class, [ 
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker form-control'],

                ])
            ->add('ejemplares', type: IntegerType::class)
           
            ->add(child: 'Editar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
