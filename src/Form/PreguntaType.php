<?php
// src/Form/PreguntaType.php
namespace App\Form;

use App\Entity\Pregunta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreguntaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('opcion1', TextType::class, [
                'label' => 'Opción 1',
            ])
            ->add('opcion2', TextType::class, [
                'label' => 'Opción 2',
            ])
            ->add('opcion3', TextType::class, [
                'label' => 'Opción 3',
                'required' => false, // Opcional
            ])
            ->add('opcion4', TextType::class, [
                'label' => 'Opción 4',
                'required' => false, // Opcional
            ])
            ->add('correcta', TextType::class, [
                'label' => 'Opción Correcta',
            ])
            ->add('fechaInicio', DateTimeType::class, [
                'label' => 'Fecha de Inicio',
                'widget' => 'single_text', // Para un solo input de fecha
                'required' => false, // Opcional
            ])
            ->add('fechaFin', DateTimeType::class, [
                'label' => 'Fecha de Fin',
                'widget' => 'single_text', // Para un solo input de fecha
                'required' => false, // Opcional
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pregunta::class,
        ]);
    }
}

