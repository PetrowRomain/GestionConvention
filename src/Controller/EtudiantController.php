<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;

/* use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;

use App\Entity\Stage;
use App\Repository\StageRepository;

use App\Entity\MaitreStage;
use App\Repository\MaitrestageRepository;

use App\Entity\Representant;
use App\Repository\RepresentantRepository; */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;


use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/etudiant")
 * 
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }


	

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
	
	/**
     * @Route("/{id}/pdf", name="etudiant_pdf")
	 * 
     */
	
	 public function toPdf(Request $request, Etudiant $etudiant /* , Entreprise $entreprise, Representant $representant, MaitreStage $maitrestage,Stage $stage */ ) : Response
	{
	  $objectsRepository = $this->getDoctrine()->getRepository(Etudiant::class)->findall();
 	  /* $objectsRepository = $this->getDoctrine()->getRepository(Stage::class)->findall();
	  $objectsRepository = $this->getDoctrine()->getRepository(Entreprise::class)->findall();
	  $objectsRepository = $this->getDoctrine()->getRepository(MaitreStage::class)->findall();
	  $objectsRepository = $this->getDoctrine()->getRepository(Representant::class)->findall();  */
	  
		
		 
        // Configure Dompdf according to your needs
        
		
		$pdfOptions = new Options();
		$pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file

         $html = $this->renderView(
      'etudiant/pdf.html.twig', 
      array('etudiant' => $etudiant));
	  
	  // $dompdf->loadHtml(" <html> 







	  
	  // <head>
         // <style>
             // * Define the margins of your page **/
            // @page {
                 // margin: 30px 60px;
             // }

        

             // footer {
                 // position: fixed; 
                 // bottom: -5px; 
                 // left: 0px; 
                // right: 0px;
                 // height: 0px; 

          
            // }
        // </style>
    // </head><body>
	// <footer><center> <font size = 7.5pt> 
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
// <br/>LYCEE GUY CHAUVET Rue de l'éperon 86200 LOUDUN –Tel : 05 49 98 17 51 -Fax 05 49 98 79 09 –Mail : 0860021F@ac-poitiers.fr
// </footer></center></font>
	
	// <center> <b><font size = 4> ANNEE SCOLAIRE 2020-2021<br/><br/>

// SECTION DE TECHNICIENS SUPERIEURS<br/>
// SERVICES INFORMATIQUES AUX ORGANISATIONS<br/>
// DEUXIEME ANNEE<br/><br/>

// CONVENTION DE STAGE</center></font></b><br/><br/>

// <div align=&ldquo; center>
// <b><font>ARTICLE 1<size = 2></b><br/>
// La présente convention règle les rapports entre<br/>
// <b><u>l'entreprise ou l’organisme d’accueil</b></u><br/>
// Raison sociale : ............................................................................................................................<br/>
// Adresse : n° ................ voie   .......................................................................................................<br/>
// Ville :   ........................................................................................... Code postal : .......................<br/>
 // Représenté(e) par :<br/>
 // Nom :  .................................................................Prénom : ...........................................................<br/>
 // Téléphone :  .................................. Qualité ou fonction exercée : ...............................................
 // <center>ET<br/></center>
 // <b><u>le  Lycée  Polyvalent  Régional  Guy  CHAUVET</b></u> <b>à  LOUDUN</b>,  représenté  par Monsieur<br/>
 // le proviseur du Lycée.<br/><br/>
 // Elle  concerne  le  séjour  en  entreprise  de <u>l’étudiant.e stagiaire</u> en Section  de  Techniciens<br/>
 // supérieurs Services Informatiques aux Organisations, deuxième année, désigné.eci-après par <br/>
 // l'étudiant:<br/>
 // Nom :  .............".$NomE."................................................... Prénom : ............................................................<br/>
 // Adresse : n° ................ voie   .......................................................................................................<br/>
 // Ville :  ..............................................................................................  Code postal : ...................<br/>
 // Courriel :  ..............................................................  Téléphone :  ................................................<br/><br/>
 // <br/><b><font>ARTICLE 2<size = 2></b><br/>
 // Ce séjour en entreprise doit permettre <b> de préparer et réaliser une étude approfondie sur un<br/>
 // problème concret lié à l'utilisation de moyens informatiques.</b><br/>
 // Cette étude porte sur un problème d'informatique de gestion dont le sujet intéresse l'entreprise<br/>
 // et areçu l'agrément du professeur responsable.<br/>
 // Durant ce stage, l'étudiant sera suivi par un.e représentant.e de l'entreprise appelé.e Maitre de<br/>
 // stage:<br/>
 // Nom :  ................................................................. Prénom : ...........................................................<br/>
 // Courriel :  ..............................................................  Téléphone :  ................................................<br/>
 // Qualité ou fonction exercée : ........................................................<br/><br/>
 // <br/><b><font>ARTICLE 3<size = 2></b><br/>
 // Le stage se déroulera sur une période de huit semaines du lundi 25 janvier 2021 au dimanche<br/>
 // 21 mars 2021, ces deux dates incluses.<br/><br/>
// <br/><b><font>ARTICLE 4<size = 2></b><br/>
 // L'étudiant  doit  observer  la  réglementation  de  l'entreprise  :  horaires  de travail,  règles  de <br/>
 // sécurité, visites médicales, ...<br/>
 // En cas de manquement à la discipline, il peut être mis fin au stage par le chef d'entreprise, qui<br/>
 // prendra au préalable l'avis du proviseur du lycée. </div>
// <br/><br/><b><font>ARTICLE 5<size = 2></b><br/>
// Durant  le  stage,  l'étudiant,  qui  garde  sonstatut  d'étudiant,  demeure  sous  la  responsabilité<br/>
  // du Lycée en qualité d'étudiant stagiaire. Restant sous statut d'étudiant, il ne peut prétendre à une<br/>
  // rémunération de la part de l'entreprise qui, de son côté, ne doit pas attendre un profit direct<br/>
  // de l'activité de l'étudiant.<br/>
 // <br/> <b><font>ARTICLE 6<size = 2></b><br/> 
  // L'étudiant,  ou  son  représentant  légal,  certifie  avoir  souscrit  une  assurance  à  responsabilité<br/>
  // civile couvrant les dommages occasionnés aux tiers lors de sa présence en entreprise.<br/>
  // <br/><b><font>ARTICLE 7<size = 2></b><br/>
  // L'étudiant bénéficie de la législation sur les accidents de travail en application de l'article 416-<br/>
  // 2° du Code de la Sécurité Sociale, y compris pour les accidents de trajet survenus pendant le<br/>
  // stage (Note de service N° 86-017 parue au B.O. N° 5-1986)<br/>
  // En cas d'accident survenant à l'étudiant, soit au cours du travail, soit au cours du trajet, le chef<br/>
  // d'entreprise  s'engage  à  faire  parvenir  toutes  les  informations,  le  plus  rapidement  possible  à<br/>
  // Monsieurle  Proviseur  du  Lycée  Guy  Chauvet  à  qui  incombe  la  déclaration  d'accident  du<br/>
  // travail.<br/>
  // <br/><b><font>ARTICLE 8<size = 2></b><br/>
  // A  la  fin  du  stage,  une  attestation  de  stage  fournie  par  le  lycée  est  remise  au  stagiaire  par  le <br/>
  // chef  d'entreprise  qui  atteste  de  l'assiduité  et  de  l'activité  du  stagiaire.  Cette attestation<br/>
  // précisera les liens avec le référentiel du BTS (compétences professionnelles).<br/>
  // <br/><b><font>ARTICLE 9<size = 2></b><br/>
  // Cette   convention,   établie   en   triple   exemplaire,   n'engage   pas   l'entreprise   à   recruter
  // ultérieurement l'étudiant.<br/><br/><br/><br/>
  // </div>
  // <div>
 // <div align = right> Fait à Loudun le ........................................................</div><br/><br/><br/>
 // </div>

 // <table align = center>
	// <tr>
		// <td >Pour l'entreprise </td>
		// <td width = 50>          </td>
		// <td>L'étudiant.e</td>
		// <td>          </td>
		// <td>Pour le lycée Guy Chauvet
	 // </tr>

	// <tr>
		// <td> Le chef d'entreprise </td>
		 // <td >          </td>
		 // <td>ou représentant.e légal.e</td>
		// <td width = 50>          </td>
		 // <td>Le Proviseur</td>
	 // </tr>
  // </table>
 // </body>
 // </html>");
    
		
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
		
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
		
			return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }
	

        
}
