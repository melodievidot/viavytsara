<?php

namespace App\Form;

use App\Entity\Soin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre')
            ->add('prix')
            ->add('description')
            ->add('image', FileType::class, [
                'label'=>'Telecharger une image',
                'data_class'=>null
            ])
            ->add('reservations')
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Soin::class,
        ]);
    }
}
