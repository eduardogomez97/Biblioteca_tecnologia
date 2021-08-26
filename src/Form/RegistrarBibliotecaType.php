<?php

namespace App\Form;

use App\Entity\Biblioteca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrarBibliotecaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(child: 'nombre')
            ->add(child: 'num_trabajadores', type: IntegerType::class)
            ->add(child: 'direccion')
            ->add('fecha_fundacion', DateType::class, [ 
                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => '',
                'attr' => ['class' => 'js-datepicker form-control'],
                'label' => 'Fecha de publicación:'    
                ])
            ->add(child: 'Registrar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biblioteca::class,
        ]);
    }
}
