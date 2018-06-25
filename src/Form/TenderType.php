<?php

namespace App\Form;

use App\Entity\Tender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId')
            ->add('typeId')
            ->add('methodId')
            ->add('nameRu')
            ->add('fullDescription')
            ->add('customer')
            ->add('binInn')
            ->add('rnn')
            ->add('organizer')
            ->add('amount')
            ->add('location')
            ->add('katoId')
            ->add('openDate')
            ->add('closeDate')
            ->add('appPlaceGet')
            ->add('appOpenDate')
            ->add('appPlaceOpen')
            ->add('agent')
            ->add('link')
            ->add('activity')
            ->add('gzid')
            ->add('fileCdocs')
            ->add('fileItogs')
            ->add('published')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tender::class,
        ]);
    }
}
