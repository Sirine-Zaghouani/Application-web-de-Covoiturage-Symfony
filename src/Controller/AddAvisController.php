<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Annonce;
use App\Entity\Avis;
use App\Form\AddAvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddAvisController extends AbstractController
{
    /**
     * @Route ("/addAvis/{id}",name="add_avis")
     * @param Request $request
     * @param $id
     * @param $user
     * @return Response
     */
    public function addAvis(Request $request, $id): Response
    {

        $avis = new Avis();
        $form = $this->createForm(AddAvisType::class, $avis);
        $form -> handleRequest ($request) ;
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository(Annonce::class)->find($id);
        $avis->setAnnonce($annonce);
        $avis->setDateC(new \DateTime());
        $user=$this->getUser();
        $avis->setUser($user);
        $avis=$form->getData();

        if ($form->isSubmitted() and $form->isValid())
        {

            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('AllPosts');
        }
        return $this->render('add_avis/index.html.twig', [
            'formAvis' => $form->createView()]);

    }




    /**
     * @Route ("/Update_Avis/{id}",name="Avis_Update")
     */
    public function update(Request $request,$id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository( "App\Entity\Avis")->find($id);
        $editform=$this->createForm( AddAvisType::class,$avis);
        $editform->handleRequest($request);
        if($editform->isSubmitted() and $editform->isValid())
        {
            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('AllPosts');
        }
        return $this->render('add_avis/Update_Avis.html.twig',['editFormAvis'=>$editform->createView()]);
    }




    /**
     * @Route ("/Delete_Avis/{id}",name="Avis_Delete")
     */
    public function delete($id): Response
    {

        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository("App\Entity\Avis")->find($id);
        if($avis!==null)
        {
            $em->remove($avis);
            $em->flush();
        }
        return $this->redirectToRoute('AllPosts');
    }
}
