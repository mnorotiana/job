<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, array(
                'mapped' => false,
                'required' => true,
                'label'    => 'User Type',
                'choices' => array(
                    'Candidat' => 'ROLE_CANDIDAT',
                    'Société' => 'ROLE_SOCIETE',
                ),
                'expanded'   => true,
                'error_bubbling' => true,
                'data' => 'ROLE_CANDIDAT'
            ))
            ->add('nom')
            ->add('adresse')
            ->add('telephone') 
            ->add('nif') 
            ->add('stat')            
            ;
    }

    public function getParent()
    {
       return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
       return 'user_registration';
    }


}
