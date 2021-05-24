<?php

namespace App\Form;

use App\Entity\Biblioteca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditarBibliotecaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(child: 'nombre')
            ->add(child: 'num_trabajadores', type: IntegerType::class)
            ->add(child: 'direccion')
            ->add(child: 'fecha_fundacion', type: DateTimeType::class)
            ->add(child: 'Editar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biblioteca::class,
        ]);
    }
}
