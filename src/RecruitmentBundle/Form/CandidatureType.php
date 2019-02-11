<?php

namespace RecruitmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CandidatureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('statut')
        ->add('dateReception', DateType::class, [
                'widget' => 'single_text'
            ])
        ->add('note')
        ->add('motifs')
        ->add('dateTest', DateType::class, [
                'widget' => 'single_text'
            ])
        ->add('dateEntretien', DateType::class, [
                'widget' => 'single_text'
            ])
        ->add('commentaireTest')
        ->add('commentaireEntretien')
        ->add('candidat')
        ->add('offre');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RecruitmentBundle\Entity\Candidature'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recruitmentbundle_candidature';
    }


}
