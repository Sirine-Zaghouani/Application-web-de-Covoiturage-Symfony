<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Avis;
use App\Entity\AvisDemande;
use App\Entity\Demande;
use App\Form\AddAvisDemandesType;
use App\Form\AddAvisType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAvisDemandeController extends AbstractController
{

    #[Route('/addAvisDemande/{id}', name: 'add_avis_demande')]


    public function addAvisDemande(Request $request, $id): Response
    {

        $avisdemande = new AvisDemande();
        $form = $this->createForm(AddAvisDemandesType::class, $avisdemande);
        $form -> handleRequest ($request) ;

        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(Demande::class)->find($id);
        $avisdemande->setDemande($demande);


        $avisdemande->setDateC(new \DateTime());
        $user=$this->getUser();
        $avisdemande->setUser($user);
        $avisdemande=$form->getData();

        if ($form->isSubmitted() and $form->isValid())
        {

            $em->persist($avisdemande);
            $em->flush();
            return $this->redirectToRoute('AllPosts');
        }
        return $this->render('add_avis_demande/index.html.twig',
            ['formAvisdemande' => $form->createView()]);
    }



    #[Route('/Update_Avis_demande/{id}', name: 'Avis_demande_Update')]

    public function update(Request $request,$id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $avisdemande=$em->getRepository( "App\Entity\AvisDemande")->find($id);
        $editform=$this->createForm( AddAvisDemandesType::class,$avisdemande);
        $editform->handleRequest($request);
        if($editform->isSubmitted() and $editform->isValid())
        {
            $em->persist($avisdemande);
            $em->flush();
            return $this->redirectToRoute('AllPosts');
        }
        return $this->render('add_avis_demande/Update_Avis.html.twig',['editFormAvis_demande'=>$editform->createView()]);
    }





    #[Route('/Delete_Avis_demande/{id}', name: 'Avis_Delete_demande')]

    public function delete($id): Response
    {

        $em=$this->getDoctrine()->getManager();
        $avisdemande=$em->getRepository("App\Entity\AvisDemande")->find($id);
        if($avisdemande!==null)
        {
            $em->remove($avisdemande);
            $em->flush();
        }
        return $this->redirectToRoute('AllPosts');
    }
}