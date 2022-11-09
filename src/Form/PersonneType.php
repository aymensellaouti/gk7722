<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('hobbies', EntityType::class, [
                'class' => Hobby::class,
                'choice_label'=>'designation',
                'expanded'=>true,
                'multiple'=>true
            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
