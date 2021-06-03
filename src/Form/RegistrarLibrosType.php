<?php

namespace App\Form;

use App\Entity\Libros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RegistrarLibrosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('autor')
            ->add('tipo')
            ->add('fecha_publicacion', type: DateType::class)
            ->add('ejemplares', type: IntegerType::class)
            ->add('biblioteca_id', type: IntegerType::class)
            ->add(child: 'Registrar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Libros::class,
        ]);
    }
}
