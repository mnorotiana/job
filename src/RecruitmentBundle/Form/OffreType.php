<?php

namespace RecruitmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class OffreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('domaine')
            ->add('description', CKEditorType::class, array(
                'config' => array(
                ),
            ))
            ->add('qualifications', CKEditorType::class, array(
                'config' => array(
                ),
            ))
            ->add('lieu')
            ->add('nombre')
            ->add('contact')
            ->add('dateCloture', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('statut')
            ->add('user');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RecruitmentBundle\Entity\Offre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recruitmentbundle_offre';
    }


}
