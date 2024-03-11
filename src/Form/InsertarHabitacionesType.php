<?php
namespace App\Form;

use App\Entity\Habitaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertarHabitacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('precioNoche', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'class' => 'form-control',
                    'step' => 0.5
                ]
            ])
            ->add('disponible', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('guardar', SubmitType::class, [
                'label' => 'Guardar Cambios',
                'attr' => ['class' => 'btn btn-warning']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitaciones::class,
        ]);
    }
}
