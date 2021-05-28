<?php

namespace App\Form;

use App\Entity\MaitreStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MaitreStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomMS')
            ->add('PrenomMS')
            ->add('TelMS')
            ->add('FonctionMS')
            ->add('EmailMS')
            ->add('LienEnt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MaitreStage::class,
        ]);
    }
}
