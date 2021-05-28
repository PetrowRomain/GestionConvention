<?php

namespace App\Form;

use App\Form\EtudiantType;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Entity\Etudiant;
use Doctrine\ORM\EtudiantRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConvType extends AbstractType
{
	
	
	 public function buildForm(FormBuilderInterface $builder, array $options)
    { 
	
	
 
	
        $builder
		
		
           ->add('etudiant', EtudiantType::class)
		   
		   ->add('NomE', EntityType::class, [
		
			'class' => Etudiant::class,
			'choice_label' => 'NomE', 
			])
			
			  
			->add('PrenomE', EntityType::class, [
			'class' => Etudiant::class,
			'choice_label' => 'PrenomE', 
			])
	
				
			->add('EmailE', EntityType::class, [
			'class' => Etudiant::class,
			'choice_label' => 'EmailE', 
			])
	
	
		   ->add('entreprise', EntrepriseType::class)
		   
		   ->add('stage', StageType::class)
			 
		   ->add('maitrestage', MaitreStageType::class)
		   
		   ->add('representant', RepresentantType::class)
		   
		;
		

        
        
    }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'vali' => 'conv'
        ]);
    } 
	
}
