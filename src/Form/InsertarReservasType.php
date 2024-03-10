<?php

namespace App\Form;

use App\Entity\Clientes;
use App\Entity\Habitaciones;
use App\Entity\Reservas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InsertarReservasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaInicio', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de inicio',
            ])
            ->add('fechaFin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de fin',
            ])
            ->add('habitacion', EntityType::class, [
                'class' => Habitaciones::class,
                'choice_label' => 'numero', // Usar el número de la habitación como etiqueta
                'label' => 'Habitación',
            ])
            ->add('cliente', EntityType::class, [
                'class' => Clientes::class,
                'choice_label' => 'dni', // Usar el DNI del cliente como etiqueta
                'label' => 'Cliente',
            ])
            ->add('guardar', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-warning'], // Clase CSS para el botón
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservas::class,
        ]);
    }
}
