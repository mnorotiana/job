<?php

namespace RecruitmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexe', ChoiceType::class, array(
                'label'    => 'Sexe',
                'choices' => array(
                    'Féminin' => 'Feminin',
                    'Masculin' => 'Masculin'
                ),
                'expanded'   => true,
            ))
            ->add('situationMatrimoniale', ChoiceType::class, array(
                'label'    => 'Situation matrimoniale',
                'choices' => array(
                    'Célibataire' => 'Celibataire',
                    'Marié' => 'Marie',
                    'Divorcé' => 'Divorce',
                    'Veuf' => 'Veuf',
                ),
                'expanded'   => true,
            ))
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'by_reference' => true,
                'required'=>false
            ])
            ->add('lieuNaissance')
            ->add('adresse')
            ->add('ville')
            ->add('codePostal')
            ->add('telephone')
            ->add('email')
            ->add('pseudoSkype')
            ->add('domaineCompetence')
            ->add('diplome1')
            ->add('etablissement1')
            ->add('dateObtention1', DateType::class, [
                'widget' => 'single_text',
                'by_reference' => true,
                'required'=>false
            ])
            ->add('diplome2')
            ->add('etablissement2')
            ->add('dateObtention2', DateType::class, [
                'widget' => 'single_text',
                'by_reference' => true,
                'required'=>false
            ])
            ->add('diplome3')
            ->add('etablissement3')
            ->add('dateObtention3', DateType::class, [
                'widget' => 'single_text',
                'by_reference' => true,
                'required'=>false
            ])
            ->add('intitulePoste1')
            ->add('societe1')
            ->add('duree1')
            ->add('referent1')
            ->add('mailReferent1')
            ->add('telephoneReferent1')
            ->add('domainePoste1')
            ->add('intitulePoste2')
            ->add('societe2')
            ->add('duree2')
            ->add('referent2')
            ->add('mailReferent2')
            ->add('telephoneReferent2')
            ->add('domainePoste2')
            ->add('cv',FileType::class, array('data_class' => null,'required' => false))
            ->add('lm',FileType::class, array('data_class' => null,'required' => false))
            ->add('diplome',FileType::class, array('data_class' => null,'required' => false))
            ->add('statut', ChoiceType::class, array(
                'label'    => 'Statut',
                'choices' => array(
                    'En recherche d\'emploi' => 'chercheur',
                    'Salarié' => 'salarie',
                    'Etudiant' => 'etudiant'
                ),
                'expanded'   => false,
            ))
            ->add('dureePreavis')
            ->add('candidat')
            ->add('step1', SubmitType::class, array('label' => 'Enregister'))
            ->add('step2', SubmitType::class, array('label' => 'Enregister'))
            ->add('step3', SubmitType::class, array('label' => 'Enregister'))
            ->add('step4', SubmitType::class, array('label' => 'Soumettre'))
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RecruitmentBundle\Entity\Profil'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recruitmentbundle_profil';
    }

}
