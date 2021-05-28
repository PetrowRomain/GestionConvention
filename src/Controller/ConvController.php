<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Representant;
use App\Entity\Entreprise;
use App\Entity\MaitreStage;
use App\Entity\Stage;

use App\Form\ConvType;

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

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints\DateTime;


use Dompdf\Dompdf;
use Dompdf\Options;

/**
     * @Route("/conv", name="conv")
     */

class ConvController extends AbstractController
{
    /**
     * @Route("/", name="conv_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository, EntrepriseRepository $entrepriseRepository, StageRepository $stageRepository, MaitreStageRepository $maitrestageRepository, RepresentantRepository $representantRepository ): Response
    {
        return $this->render('conv/index.html.twig', [
            'controller_name' => 'ConvController',
			'etudiants' => $etudiantRepository->findAll(),
			'entreprises' => $entrepriseRepository->findAll(),		
			'stages' => $stageRepository->findAll(),
			 'maitre_stages' => $maitrestageRepository->findAll(),
			'representants' => $representantRepository->findAll(), 
        ]);
    }
	
/* 	public static function dateToFrench($date, $format) 
{
    
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($english_months, $french_months, date($format, strtotime($date) ) );
} */

/* public static function mail($email,$pdf_content) 
{
	$message = (new \Swift_Message('Hello Email'))
			->setFrom('convstagetest@gmail.com')
			->setTo($email)
			->setBody('Voici le mail qui contient votre convention de stage sous format pdf');
			$attachment = new \Swift_Attachment($pdf_content, 'mypdf.pdf', 'application/pdf');
			$message->attach($attachment);
		return	$mailer->send($message); 
	
} */
	
	/**
     * @Route("/new", name="conv_new", methods={"GET","POST"})
     */
    public function new(EtudiantRepository $etudiantRepository, Request $request,\Swift_Mailer $mailer): Response
    {
		
		
	
		$maitrestage = new MaitreStage();
		$representant = new Representant();
		$etudiant = new Etudiant();
		$stage = new Stage();
		$entreprise = new Entreprise();
		
		

		
        $form = $this->createForm(ConvType::class, ['etudiant'=> $etudiant,'stage' => $stage,'entreprise' => $entreprise,'maitrestage'=> $maitrestage,'representant' => $representant ]);
		
		
		$form -> handleRequest($request);
		

      if ($form->isSubmitted()) { 
		
		$dyteD = $form["stage"]["DateD"]->getData();
		$dyteF = $form["stage"]["DateF"]->getData();
		
	
		$diff = $dyteF->diff($dyteD);
		
		$DIFF = $diff->days; 
		
		echo $DIFF;
		
		
		
		if ( $dyteF > $dyteD && $DIFF == '56'){
			
			
		$entityManager = $this->getDoctrine()->getManager();
       // $entityManager->persist($etudiant);
		//$entityManager->persist($entreprise);
		//$entityManager->persist($stage);
		//$entityManager->persist($representant);
		//$entityManager->persist($maitrestage);
        $entityManager->flush();
			
		$email = $form["etudiant"]["EmailE"]->getData();
			
		$date = date_create();
		$dhate = date_format($date, 'M');
			
			
	 	if ($dhate == 'string(9) "Sep"' || $dhate == 'string(11) "Nov"' || $dhate =='string(10) "Oct"' || $dhate == 'string(12) "Dec"')
		{
		$op12 =	date_add($date, date_interval_create_from_date_string('1 years'));
		$op1 = date_create();
		$op = date_format($op1, 'Y');
		$op5 = date_format($op12, 'Y');
		}
else
		{	
		$op1 =	date_add($date, date_interval_create_from_date_string('-1 years'));
		$op12 = date_create();
		$op = date_format($op1, 'Y');
		$op5 = date_format($op12, 'Y');
		}	 
			
			$doteD = $form["stage"]["DateD"]->getData();
			$doteF = $form["stage"]["DateF"]->getData();
		
			$diteD =  date_format ( $doteD , "j F Y" );
			$diteF =  date_format ( $doteF , "j F Y" );
			
	 	 	$english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
			$dateD = str_replace($english_months, $french_months, date("j F Y", strtotime($diteD) ) );
			$dateF = str_replace($english_months, $french_months, date("j F Y", strtotime($diteF) ) ); 
			
			/*$dateD = dateToFrench($doteD,"j F Y" );
			$dateF = dateToFrench($doteF,"j F Y" );*/
			
			
			$pdfOptions = new Options();
			$pdfOptions->set('defaultFont', 'Arial');
			$dompdf = new Dompdf($pdfOptions);
			$html = $this->renderView('conv/pdf.html.twig', ['op12'=> $op5,'op' => $op,'dateF' => $dateF,'dateD' => $dateD,'etudiant'=> $etudiant,'stage' => $stage,'entreprise' => $entreprise,'maitrestage'=> $maitrestage,'representant' => $representant ]);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$pdf_content = $dompdf->output();
			$dompdf->stream("mypdf.pdf" , [
		    "Attachment" => false]);   
			
			
			
			
			
			
			
		 	$message = (new \Swift_Message('Convention Stage'))
			->setFrom('romain.petrow@sio-loudun.fr')
			->setTo($email)
			->setBody('Voici le mail qui contient votre convention de stage sous format pdf');
			$attachment = new \Swift_Attachment($pdf_content, 'mypdf.pdf', 'application/pdf');
			$message->attach($attachment);
			$mailer->send($message); 
			
			//mail($email,$pdf_content); 
	  	}	
			
	}	

        return $this->render('conv/new.html.twig', [
			
            'etudiant' => $etudiant,
			'entreprise' => $entreprise,
			'stage' => $stage,
			'maitrestage' => $maitrestage,
			'representant' => $representant,
            'form' => $form->createView(),
		
        ]);
      
	 
	
	}
	
	/**
     * @Route("/new2", name="conv_new2", methods={"GET","POST"})
     */
    public function new2(Request $request,\Swift_Mailer $mailer): Response
    {
		
		
	
		$maitrestage = new MaitreStage();
		$representant = new Representant();
		$etudiant = new Etudiant();
		$stage = new Stage();
		$entreprise = new Entreprise();
		
		
		
		$form = $this->createForm(ConvType::class, ['etudiant'=> $etudiant,'stage' => $stage,'entreprise' => $entreprise,'maitrestage'=> $maitrestage,'representant' => $representant ]);
		
		
		$form -> handleRequest($request);
		

      if ($form->isSubmitted()) { 
		
		$dyteD = $form["stage"]["DateD"]->getData();
		$dyteF = $form["stage"]["DateF"]->getData();
		
	
		$diff = $dyteF->diff($dyteD);
		
		$DIFF = $diff->days; 
		
		echo $DIFF;
		
		
		if ( $dyteF > $dyteD && $DIFF == '35'){
			
			
		$entityManager = $this->getDoctrine()->getManager();
        //$entityManager->persist($etudiant);
		//$entityManager->persist($entreprise);
		//$entityManager->persist($stage);
		//$entityManager->persist($representant);
		//$entityManager->persist($maitrestage);
        $entityManager->flush();
			
		$email = $form["etudiant"]["EmailE"]->getData();
		
		$date = date_create();
		$dhate = date_format($date, 'M');
			
			
		if ($dhate == 'string(9) "Sep"' || $dhate == 'string(11) "Nov"' || $dhate =='string(10) "Oct"' || $dhate == 'string(12) "Dec"')
		{
		$op12 =	date_add($date, date_interval_create_from_date_string('1 years'));
		$op1 = date_create();
		$op = date_format($op1, 'Y');
		$op5 = date_format($op12, 'Y');
		}
else
		{	
		$op1 =	date_add($date, date_interval_create_from_date_string('-1 years'));
		$op12 = date_create();
		$op = date_format($op1, 'Y');
		$op5 = date_format($op12, 'Y');
		}	
			
			$doteD = $form["stage"]["DateD"]->getData();
			$doteF = $form["stage"]["DateF"]->getData();
		
			$diteD =  date_format ( $doteD , "j F Y" );
			$diteF =  date_format ( $doteF , "j F Y" );
			
	 	 	$english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
			$dateD = str_replace($english_months, $french_months, date("j F Y", strtotime($diteD) ) );
			$dateF = str_replace($english_months, $french_months, date("j F Y", strtotime($diteF) ) ); 
			
			/*$dateD = dateToFrench($doteD,"j F Y" );
			$dateF = dateToFrench($doteF,"j F Y" );*/
			
			
			
			
			
			
			
			$pdfOptions = new Options();
			$pdfOptions->set('defaultFont', 'Arial');
			$dompdf = new Dompdf($pdfOptions);
			$html = $this->renderView('conv/pdf2.html.twig', ['op12'=> $op5,'op' => $op,'dateF' => $dateF,'dateD' => $dateD,'etudiant'=> $etudiant,'stage' => $stage,'entreprise' => $entreprise,'maitrestage'=> $maitrestage,'representant' => $representant ]);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$pdf_content = $dompdf->output();
			$dompdf->stream("mypdf.pdf" , [
		    "Attachment" => false]);   
			
			
			
			
			
			
			
		 	$message = (new \Swift_Message('Convention Stage'))
			->setFrom('romain.petrow@sio-loudun.fr')
			->setTo($email)
			->setBody('Voici le mail qui contient votre convention de stage sous format pdf');
			$attachment = new \Swift_Attachment($pdf_content, 'mypdf.pdf', 'application/pdf');
			$message->attach($attachment);
			$mailer->send($message); 
			
			//mail($email,$pdf_content); 
	  	}	
			
	}	

        return $this->render('conv/new2.html.twig', [
			
            'etudiant' => $etudiant,
			'entreprise' => $entreprise,
			'stage' => $stage,
			'maitrestage' => $maitrestage,
			'representant' => $representant,
            'form' => $form->createView(),
		
        ]);
	
	

	}
}



