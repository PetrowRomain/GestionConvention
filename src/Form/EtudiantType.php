<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EtudiantType extends AbstractType
{
 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
		  
        $builder
            
			
		 	->add('NomE')
			->add('PrenomE')
			->add('VilleE')
            ->add('NumRueE')
            ->add('NomRueE')
			->add('CompE')
            ->add('CodePostalE')
            ->add('TelE')
            ->add('EmailE')
		    ->add('stage');

        
	
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }

}


