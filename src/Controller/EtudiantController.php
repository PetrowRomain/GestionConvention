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
// <br/>LYCEE GUY CHAUVET Rue de l'??peron 86200 LOUDUN ???Tel : 05 49 98 17 51 -Fax 05 49 98 79 09 ???Mail : 0860021F@ac-poitiers.fr
// </footer></center></font>
	
	// <center> <b><font size = 4> ANNEE SCOLAIRE 2020-2021<br/><br/>

// SECTION DE TECHNICIENS SUPERIEURS<br/>
// SERVICES INFORMATIQUES AUX ORGANISATIONS<br/>
// DEUXIEME ANNEE<br/><br/>

// CONVENTION DE STAGE</center></font></b><br/><br/>

// <div align=&ldquo; center>
// <b><font>ARTICLE 1<size = 2></b><br/>
// La pr??sente convention r??gle les rapports entre<br/>
// <b><u>l'entreprise ou l???organisme d???accueil</b></u><br/>
// Raison sociale : ............................................................................................................................<br/>
// Adresse : n?? ................ voie   .......................................................................................................<br/>
// Ville :   ........................................................................................... Code postal : .......................<br/>
 // Repr??sent??(e) par :<br/>
 // Nom :  .................................................................Pr??nom : ...........................................................<br/>
 // T??l??phone :  .................................. Qualit?? ou fonction exerc??e : ...............................................
 // <center>ET<br/></center>
 // <b><u>le  Lyc??e  Polyvalent  R??gional  Guy  CHAUVET</b></u> <b>??  LOUDUN</b>,  repr??sent??  par Monsieur<br/>
 // le proviseur du Lyc??e.<br/><br/>
 // Elle  concerne  le  s??jour  en  entreprise  de <u>l?????tudiant.e stagiaire</u> en Section  de  Techniciens<br/>
 // sup??rieurs Services Informatiques aux Organisations, deuxi??me ann??e, d??sign??.eci-apr??s par <br/>
 // l'??tudiant:<br/>
 // Nom :  .............".$NomE."................................................... Pr??nom : ............................................................<br/>
 // Adresse : n?? ................ voie   .......................................................................................................<br/>
 // Ville :  ..............................................................................................  Code postal : ...................<br/>
 // Courriel :  ..............................................................  T??l??phone :  ................................................<br/><br/>
 // <br/><b><font>ARTICLE 2<size = 2></b><br/>
 // Ce s??jour en entreprise doit permettre <b> de pr??parer et r??aliser une ??tude approfondie sur un<br/>
 // probl??me concret li?? ?? l'utilisation de moyens informatiques.</b><br/>
 // Cette ??tude porte sur un probl??me d'informatique de gestion dont le sujet int??resse l'entreprise<br/>
 // et are??u l'agr??ment du professeur responsable.<br/>
 // Durant ce stage, l'??tudiant sera suivi par un.e repr??sentant.e de l'entreprise appel??.e Maitre de<br/>
 // stage:<br/>
 // Nom :  ................................................................. Pr??nom : ...........................................................<br/>
 // Courriel :  ..............................................................  T??l??phone :  ................................................<br/>
 // Qualit?? ou fonction exerc??e : ........................................................<br/><br/>
 // <br/><b><font>ARTICLE 3<size = 2></b><br/>
 // Le stage se d??roulera sur une p??riode de huit semaines du lundi 25 janvier 2021 au dimanche<br/>
 // 21 mars 2021, ces deux dates incluses.<br/><br/>
// <br/><b><font>ARTICLE 4<size = 2></b><br/>
 // L'??tudiant  doit  observer  la  r??glementation  de  l'entreprise  :  horaires  de travail,  r??gles  de <br/>
 // s??curit??, visites m??dicales, ...<br/>
 // En cas de manquement ?? la discipline, il peut ??tre mis fin au stage par le chef d'entreprise, qui<br/>
 // prendra au pr??alable l'avis du proviseur du lyc??e. </div>
// <br/><br/><b><font>ARTICLE 5<size = 2></b><br/>
// Durant  le  stage,  l'??tudiant,  qui  garde  sonstatut  d'??tudiant,  demeure  sous  la  responsabilit??<br/>
  // du Lyc??e en qualit?? d'??tudiant stagiaire. Restant sous statut d'??tudiant, il ne peut pr??tendre ?? une<br/>
  // r??mun??ration de la part de l'entreprise qui, de son c??t??, ne doit pas attendre un profit direct<br/>
  // de l'activit?? de l'??tudiant.<br/>
 // <br/> <b><font>ARTICLE 6<size = 2></b><br/> 
  // L'??tudiant,  ou  son  repr??sentant  l??gal,  certifie  avoir  souscrit  une  assurance  ??  responsabilit??<br/>
  // civile couvrant les dommages occasionn??s aux tiers lors de sa pr??sence en entreprise.<br/>
  // <br/><b><font>ARTICLE 7<size = 2></b><br/>
  // L'??tudiant b??n??ficie de la l??gislation sur les accidents de travail en application de l'article 416-<br/>
  // 2?? du Code de la S??curit?? Sociale, y compris pour les accidents de trajet survenus pendant le<br/>
  // stage (Note de service N?? 86-017 parue au B.O. N?? 5-1986)<br/>
  // En cas d'accident survenant ?? l'??tudiant, soit au cours du travail, soit au cours du trajet, le chef<br/>
  // d'entreprise  s'engage  ??  faire  parvenir  toutes  les  informations,  le  plus  rapidement  possible  ??<br/>
  // Monsieurle  Proviseur  du  Lyc??e  Guy  Chauvet  ??  qui  incombe  la  d??claration  d'accident  du<br/>
  // travail.<br/>
  // <br/><b><font>ARTICLE 8<size = 2></b><br/>
  // A  la  fin  du  stage,  une  attestation  de  stage  fournie  par  le  lyc??e  est  remise  au  stagiaire  par  le <br/>
  // chef  d'entreprise  qui  atteste  de  l'assiduit??  et  de  l'activit??  du  stagiaire.  Cette attestation<br/>
  // pr??cisera les liens avec le r??f??rentiel du BTS (comp??tences professionnelles).<br/>
  // <br/><b><font>ARTICLE 9<size = 2></b><br/>
  // Cette   convention,   ??tablie   en   triple   exemplaire,   n'engage   pas   l'entreprise   ??   recruter
  // ult??rieurement l'??tudiant.<br/><br/><br/><br/>
  // </div>
  // <div>
 // <div align = right> Fait ?? Loudun le ........................................................</div><br/><br/><br/>
 // </div>

 // <table align = center>
	// <tr>
		// <td >Pour l'entreprise </td>
		// <td width = 50>          </td>
		// <td>L'??tudiant.e</td>
		// <td>          </td>
		// <td>Pour le lyc??e Guy Chauvet
	 // </tr>

	// <tr>
		// <td> Le chef d'entreprise </td>
		 // <td >          </td>
		 // <td>ou repr??sentant.e l??gal.e</td>
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
