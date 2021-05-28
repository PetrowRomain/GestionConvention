<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Representant;
use App\Entity\Entreprise;
use App\Entity\MaitreStage;
use App\Entity\Stage;

use App\Form\ConvType;
use App\Form\EtudiantType;

use App\Repository\EtudiantRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
 use App\Repository\MaitreStageRepository;
use App\Repository\RepresentantRepository; 

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class ListeController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
     
    public function index(EtudiantRepository $etudiantRepository, EntrepriseRepository $entrepriseRepository, StageRepository $stageRepository , MaitreStageRepository $maitrestageRepository, RepresentantRepository $representantRepository ): Response
    {
        return $this->render('liste/index.html.twig', [
            'controller_name' => 'ListeController',
			'etudiants' => $etudiantRepository->findAll(),
			'entreprises' => $entrepriseRepository->findAll(),		
			'stages' => $stageRepository->findAll(),
		 	'maitre_stages' => $maitrestageRepository->findAll(),
			'representants' => $representantRepository->findAll(), 
        ]);
    }
	
	
	 /**
     * @Route("/liste/CSV", name="CSV")
     */
	
	public function upload(Request $request): Response
{

   
   
    return $this->render('/liste/CSV.html.twig',[
        'form' => $form->createView()
    ]);
}
}