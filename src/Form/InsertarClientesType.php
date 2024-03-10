<?php

namespace App\Form;

use App\Entity\Clientes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertarClientesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('dni', TextType::class, [
                "label" => "DNI",
                "attr" => ["maxlength" => 9, "pattern" => "[0-9A-Za-z]{9}"], // Limitar a 9 caracteres y permitir números y letras
            ])
                    ->add('telefono', NumberType::class, ["label" => "Teléfono", "scale" => 0])

            ->add('guardar', SubmitType::class, 
            ["label" => "Insertar Cliente", 'attr' => ['class' => 'btn btn-outline-warning']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clientes::class,
        ]);
    }
}
