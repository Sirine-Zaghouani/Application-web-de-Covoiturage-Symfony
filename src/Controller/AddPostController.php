<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Demande;
use App\Entity\User;
use App\Form\AddAnnonceType;
use App\Form\AddDemandeType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AddPostController extends AbstractController
{
    #[Route('/addAnnonce', name: 'add_annonce')]
    public function addAnnonce(Request $request): Response
    {
        $annonce = new Annonce();
        $form=$this->createForm(AddAnnonceType::class,$annonce);
        $form->handleRequest($request);

        $user=$this->getUser();
        $annonce->setUser($user);
        $annonce=$form->getData();

        if($form->isSubmitted() and $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        $demande = new Demande();
        $form1=$this->createForm(AddDemandeType::class,$demande);
        $form1->handleRequest($request);
        $user=$this->getUser();
        $demande->setUser($user);
        $demande=$form1->getData();
        if($form1->isSubmitted() and $form1->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('MyPost');
        }

        return $this->render('Post/index.html.twig', [
           'formAnnonce' => $form->createView(),
            'formDemande' => $form1->createView()
        ]);
    }
    #[Route('/MyPost', name: 'MyPost')]
    public function MyPost(): Response
    {
        $user= ($this->getUser());
        $em=$this->getDoctrine()->getManager();
        $MyAnnonces=$em->getRepository("App\Entity\Annonce")->findBy(array('user' =>  $user));

        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $MyAvis=$em->getRepository("App\Entity\Avis")->findBy(array('user' => $user));

        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $MyDemandes=$em->getRepository("App\Entity\Demande")->findBy(array('user' => $user));


        return $this->render('Post/MyPost.html.twig',[
            "MesAnnonces"=>$MyAnnonces,
            "MesDemandes"=>$MyDemandes,
            "MesAvis"=>$MyAvis
        ]);
    }
    #[Route('/deleteAnnonce/{id}', name: 'AnnonceDelete')]
    public function AnnonceDelete($id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $Annonce=$em->getRepository("App\Entity\Annonce")->find($id);
        if($Annonce!==null){
            $em->remove($Annonce);
            $em->flush();
        }else{
            throw new NotFoundHttpException("l'annonce d'id".$id."n'existe pas");
        }
        return $this->redirectToRoute('MyPost');

    }
    #[Route('/deleteDemande/{id}', name: 'DemandeDelete')]
    public function DemandeDelete($id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $Demande=$em->getRepository("App\Entity\Demande")->find($id);
        if($Demande!==null){
            $em->remove($Demande);
            $em->flush();
        }else{
            throw new NotFoundHttpException("la demande d'id".$id."n'existe pas");
        }
        return $this->confirm('Are you sure you want to delete this item?');
        return $this->redirectToRoute('MyPost');


    }
    #[Route('/updateAnnonce/{id}', name: 'AnnonceUpdate')]
    public function AnnonceUpdate(Request $request,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository("App\Entity\Annonce")->find($id);

        $editform = $this->createForm(AddAnnonceType::class, $Annonce);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() and $editform->isValid()) {
            $em->persist($Annonce);
            $em->flush();

            return $this->redirectToRoute('MyPost');

        }
        return $this->render('Post/UpdateAnnonce.html.twig',['editFormAnnonce' =>$editform->createView()]);
    }
    #[Route('/updateDemande/{id}', name: 'DemandeUpdate')]
    public function DemandeUpdate(Request $request,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Demande = $em->getRepository("App\Entity\Demande")->find($id);

        $editform = $this->createForm(AddDemandeType::class, $Demande);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() and $editform->isValid()) {
            $em->persist($Demande);
            $em->flush();

            return $this->redirectToRoute('MyPost');

        }
        return $this->render('Post/UpdateDemande.html.twig',[
            'editFormDemande' =>$editform->createView()
        ]);

    }
    #[Route('/AllPosts', name: 'AllPosts')]
    public function AllPosts(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $MyAnnonces=$em->getRepository("App\Entity\Annonce")->findAll();

        $em=$this->getDoctrine()->getManager();
        $MyDemandes=$em->getRepository("App\Entity\Demande")->findAll();


        $em=$this->getDoctrine()->getManager();
        $MyAvis=$em->getRepository("App\Entity\Avis")->findAll();

        $em=$this->getDoctrine()->getManager();
        $MyAvisDemande=$em->getRepository("App\Entity\AvisDemande")->findAll();

    return $this->render('Post/AllPosts.html.twig',[
            "LesAnnonces"=>$MyAnnonces,
            "LesDemandes"=>$MyDemandes,
            "lesAvis"=>$MyAvis ,
             "lesAvisDemande"=>$MyAvisDemande]);
    }
    #[Route('/', name: 'home')]
    public function searchPosts(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $annonces = null;

        if($request->isMethod('POST')){
            $adr_depart = $request->request->get("adr_depart");
            $lieu_arrivee = $request->request->get("adr_arrivee");
            $query = $em->createQuery(
                "SELECT a FROM App\Entity\Annonce a  where a.lieu_depart  LIKE '".$adr_depart."' and a.lieu_arrivee  LIKE '".$lieu_arrivee."'");

            $annonces= $query->getResult();
        }

        return $this->render("Post/rechercheAnnonce.html.twig",
            ["annonces"=>$annonces]);
    }

}
